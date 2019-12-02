<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Unidades Model
 *
 * @property \App\Model\Table\VinculacoesTable&\Cake\ORM\Association\HasMany $Vinculacoes
 *
 * @method \App\Model\Entity\Unidade get($primaryKey, $options = [])
 * @method \App\Model\Entity\Unidade newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Unidade[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Unidade|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Unidade saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Unidade patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Unidade[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Unidade findOrCreate($search, callable $callback = null, $options = [])
 */
class UnidadesTable extends Table
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

        $this->setTable('unidades');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Unidade');

        $this->hasMany('Vinculacoes', [
            'foreignKey' => 'unidade_id'
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
            ->numeric('cnpj')
            ->notEmptyString('cnpj');

        $validator
            ->boolean('ativo')
            ->notEmptyString('ativo');

        return $validator;
    }
}
