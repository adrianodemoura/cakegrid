<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Papeis Model
 *
 * @property \App\Model\Table\SistemasTable&\Cake\ORM\Association\BelongsTo $Sistemas
 * @property \App\Model\Table\RecursosTable&\Cake\ORM\Association\BelongsToMany $Recursos
 *
 * @method \App\Model\Entity\Papei get($primaryKey, $options = [])
 * @method \App\Model\Entity\Papei newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Papei[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Papei|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Papei saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Papei patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Papei[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Papei findOrCreate($search, callable $callback = null, $options = [])
 */
class PapeisTable extends Table
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

        $this->setTable('papeis');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Papel');

        $this->belongsTo('Sistemas',        ['foreignKey' => 'sistema_id']);
        $this->belongsToMany('Recursos',    
        [
            'foreignKey'        => 'papei_id',
            'targetForeignKey'  => 'recurso_id',
            'joinTable'         => 'papeis_recursos'
        ]);
        $this->belongsToMany('Usuarios',    
        [
            'foreignKey'        => 'papei_id',
            'targetForeignKey'  => 'usuarios_id',
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
