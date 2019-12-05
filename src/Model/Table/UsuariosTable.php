<?php
/**
 * Usuarios Model
 *
 * @package     cakeGrid.Model.Tabel
 * @author      Adriano Moura
 */
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;
use Exception;
/**
 * mantém a tabela de usuários
 */
class UsuariosTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('usuarios');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Usuario');

        $this->belongsTo('Municipios',  ['foreignKey' => 'municipio_id']);
        $this->belongsToMany('Perfis',
        [
            'foreignKey'        => 'usuario_id',
            'targetForeignKey'  => 'perfil_id',
            'joinTable'         => 'vinculacoes'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('nome')
            ->maxLength('nome', 100)
            ->notEmptyString('nome');

        $validator
            ->email('email')
            ->notEmptyString('email');

        $validator
            ->scalar('senha')
            ->maxLength('senha', 100)
            ->notEmptyString('senha');

        $validator
            ->boolean('ativo')
            ->notEmptyString('ativo');

        $validator
            ->dateTime('ultimo_acesso')
            ->notEmptyDateTime('ultimo_acesso');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['municipio_id'], 'Municipios'));

        return $rules;
    }

    /**
     * Executa código antes da exclusão de um registro.
     *
     * - Impede a exclusão do administrador.
     *
     * @return  void
     */
    public function beforeDelete(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity['id'] === 1)
        {
            throw new Exception(__('Impossivel excluir Usuario Administrador !'), 1);
        }
    }

    /**
     * Retorna as permissões do usuários.
     *
     * @param   integer     $idUsuario      id do usuário.
     * @return  array       $permissoes     Permissões do usuário.
     */
    public function getPermissoes($idUsuario=0)
    {
        $permissoes     = [];
        $Vinculacoes    = \Cake\ORM\TableRegistry::get('vinculacoes');
        $dataVinculacoes= $Vinculacoes->find()
            ->where( ['Vinculacoes.usuario_id'=>$idUsuario])
            ->contain( ['Unidades', 'Perfis'] )
            ->order( ['Perfis.nome'] )
            ->toArray();

        foreach($dataVinculacoes as $_l => $_objVinculacao)
        {
            $papel = $_objVinculacao->perfi->nome.' - '.$_objVinculacao->unidade->nome;
            $_permissoes = $Vinculacoes->Perfis->find()
                ->contain( ['Recursos'] )
                ->where( ['Perfis.id'=>$_objVinculacao->perfil_id] )
                ->toArray();
            foreach($_permissoes as $_l2 => $_arrFields)
            {
                foreach($_arrFields['recursos'] as $_l2 => $_objRecurso)
                {
                    if ( !$_objRecurso->ativo ) { continue; }
                    $url = $_objRecurso->url;
                    $permissoes[$papel][$url] =
                    [
                        'url'       => $url,
                        'titulo'    => $_objRecurso->titulo,
                        'menu'      => $_objRecurso->menu
                    ];
                }
            }
        }

        return $permissoes;
    }
}
