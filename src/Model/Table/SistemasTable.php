<?php
/**
 * Sistemas Table
 */
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * maném a tabela Sistemas.
 */
class SistemasTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('sistemas');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Sistema');

        $this->hasMany('Perfis',
        [
            'foreignKey'        => 'sistema_id',
            'joinTable'         => 'perfis'
        ]);
        $this->hasMany('Recursos',
        [
            'foreignKey'        => 'sistema_id',
            'joinTable'         => 'recursos'
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
            ->boolean('ativo')
            ->notEmptyString('ativo');

        return $validator;
    }
}
