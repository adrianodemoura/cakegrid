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
        \Cake\Log\Log\write('debug', $options);
    }

    /**
     * Retorna as permissões do usuários.
     *
     * @param   integer     $idUsuario      id do usuário.
     * @return  array       $permissoes     Permissões do usuário.
     */
    public function getPermissoes($idUsuario=0)
    {
        $permissoes =
        [
            '/auditorias/index' => 
            [
                'menu'      => 'Cadastros',
                'title'     => 'Auditoria',
                'url'       => '/auditorias/index',
            ],
            '/municipios/index' => 
            [
                'menu'      => 'Cadastros',
                'title'     => 'Municípios',
                'url'       => '/municipios/index',
            ],
            '/usuarios/index' => 
            [
                'menu'      => 'Cadastros',
                'title'     => 'Usuários',
                'url'       => '/usuarios/index',
            ],
            '/usuarios/info' => 
            [
                'menu'      => 'Cadastros',
                'title'     => 'Usuários',
                'url'       => '/usuarios/info',
            ],
            '/ferramentas/enviaremail' => 
            [
                'menu'      => 'Ferramentas',
                'title'     => 'Enviar e-mail',
                'url'       => '/ferramentas/enviar-email',
            ],
            '/relatorios/usuarios' => 
            [
                'menu'      => 'Relatórios',
                'title'     => 'Relatório de Usuários',
                'url'       => '/relatorios/usuarios',
            ],
            '/ajuda/manual' => 
            [
                'menu'      => 'Ajuda',
                'title'     => 'Manual',
                'url'       => '/ajuda/manual',
            ],
            '/ajuda/sobre' => 
            [
                'menu'      => 'Ajuda',
                'title'     => 'Sobre',
                'url'       => '/ajuda/sobre',
            ]
        ];

        return $permissoes;
    }
}
