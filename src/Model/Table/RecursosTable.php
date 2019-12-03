<?php
/**
 * Recursos Model
 *
 * @package     cakeGrid.Model.Table
 * @author      Adriano Moura
 */
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * mantém a tabela recursos.
 */
class RecursosTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('recursos');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Recurso');

        $this->belongsTo('Sistemas', ['foreignKey' => 'sistema_id']);
        $this->belongsToMany('Papeis', [
            'foreignKey'        => 'recurso_id',
            'targetForeignKey'  => 'papel_id',
            'joinTable'         => 'papeis_recursos'
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
            ->scalar('url')
            ->maxLength('url', 100)
            ->notEmptyString('url');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 100)
            ->notEmptyString('titulo');

        $validator
            ->scalar('menu')
            ->maxLength('menu', 100)
            ->notEmptyString('menu');

        $validator
            ->boolean('ativo')
            ->notEmptyString('ativo');

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
        $rules->add($rules->existsIn(['sistema_id'], 'Sistemas'));

        return $rules;
    }
}
