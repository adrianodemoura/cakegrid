<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vinculacoes Model
 *
 * @property \App\Model\Table\SistemasTable&\Cake\ORM\Association\BelongsTo $Sistemas
 * @property \App\Model\Table\UnidadesTable&\Cake\ORM\Association\BelongsTo $Unidades
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \App\Model\Table\PapeisTable&\Cake\ORM\Association\BelongsTo $Papeis
 *
 * @method \App\Model\Entity\Vinculaco get($primaryKey, $options = [])
 * @method \App\Model\Entity\Vinculaco newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Vinculaco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vinculaco|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vinculaco saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vinculaco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Vinculaco[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vinculaco findOrCreate($search, callable $callback = null, $options = [])
 */
class VinculacoesTable extends Table
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

        $this->setTable('vinculacoes');
        $this->setDisplayField('usuario_id');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Vinculacao');

        $this->belongsTo('Unidades',
        [
            'foreignKey'    => 'unidade_id',
            'joinType'      => 'INNER'
        ]);
        $this->belongsTo('Usuarios',
        [
            'foreignKey'    => 'usuario_id',
            'joinType'      => 'INNER'
        ]);
        $this->belongsTo('Perfis',
        [
            'foreignKey'    => 'perfil_id',
            'joinType'      => 'INNER',
            'className'     => 'Perfis'
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
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));
        $rules->add($rules->existsIn(['unidade_id'], 'Unidades'));
        $rules->add($rules->existsIn(['perfil_id'], 'Perfis'));

        return $rules;
    }
}
