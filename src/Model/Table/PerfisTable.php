<?php
/**
 * Perfis Table
 */
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * maném a tabela perfis.
 */
class PerfisTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('Perfis');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Perfil');

        $this->belongsToMany('Recursos',
        [
            'foreignKey'        => 'perfil_id',
            'targetForeignKey'  => 'recurso_id',
            'joinTable'         => 'perfis_recursos'
        ]);
        $this->belongsToMany('Usuarios',
        [
            'foreignKey'        => 'perfil_id',
            'targetForeignKey'  => 'usuario_id',
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
}
