<?php
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
 * Usuarios Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $Municipios
 * @property &\Cake\ORM\Association\HasMany $Vinculacoes
 *
 * @method \App\Model\Entity\Usuario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Usuario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Usuario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Usuario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Usuario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Usuario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Usuario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Usuario findOrCreate($search, callable $callback = null, $options = [])
 */
class UsuariosTable extends Table
{
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

        $this->belongsTo('Municipios', [
            'foreignKey' => 'municipio_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Vinculacoes', [
            'foreignKey' => 'usuario_id'
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
        $Recursos = \Cake\ORM\TableRegistry::get('Recursos');

        $lista = $Recursos->find()
            ->where( ['Recursos.ativo'=>1] )
            ->order( ['Recursos.id', 'Recursos.menu', 'Recursos.titulo'])
            ->toArray();
        $permissoes = [];
        foreach($lista as $_l => $_objRecurso)
        {
            $indice = strtolower(str_replace('-','',$_objRecurso->url));
            $permissoes[$indice] = ['menu'=>$_objRecurso->menu, 'titulo'=>$_objRecurso->titulo, 'url'=>$_objRecurso->url];
        }
        //\Cake\Log\Log::write('debug', $permissoes);

        return $permissoes;
    }
}
