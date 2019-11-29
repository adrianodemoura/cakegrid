<?php
/**
 * Class UsuariosTable
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
 * Mantém a tabela de usuários.
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
            ->email('nome',null,'e-mail inválido !')
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->email('email',null,'e-mail inválido !')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('senha')
            ->maxLength('senha', 100)
            ->requirePresence('senha', 'create')
            ->notEmptyString('senha');

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
        $rules->add($rules->isUnique(['email']), 'Este e-mail já está em uso');

        return $rules;
    }

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
            ->order( ['Recursos.menu', 'Recursos.titulo'])
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
