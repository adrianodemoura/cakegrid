<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Municipios Model
 *
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\HasMany $Usuarios
 *
 * @method \App\Model\Entity\Municipio get($primaryKey, $options = [])
 * @method \App\Model\Entity\Municipio newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Municipio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Municipio|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Municipio saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Municipio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Municipio[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Municipio findOrCreate($search, callable $callback = null, $options = [])
 */
class MunicipiosTable extends Table
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

        $this->setTable('municipios');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Municipio');

        $this->addBehavior('Lista');

        $this->hasMany('Usuarios', [
            'foreignKey' => 'municipio_id'
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
            ->scalar('uf')
            ->maxLength('uf', 2)
            ->notEmptyString('uf');

        $validator
            ->scalar('codi_estd')
            ->maxLength('codi_estd', 2)
            ->notEmptyString('codi_estd');

        $validator
            ->scalar('desc_estd')
            ->maxLength('desc_estd', 50)
            ->notEmptyString('desc_estd');

        return $validator;
    }

    /**
     * Retorna a lista de Ufs
     *
     * @return  array   $lista  Lista de ufs.
     */
    public function getListaUf()
    {
        $_lista = $this->find()
            ->select( ['Municipios.uf', 'Municipios.uf'] )
            ->group( ['Municipios.uf'] )
            ->order( ['Municipios.uf'] )
            ->toArray();
        foreach($_lista as $_l => $_Municipio)
        {
            $lista[$_Municipio->uf] = $_Municipio->uf;
        }

        return $lista;
    }

    /**
     * Retorna a lista de Ufs
     *
     * @return  array   $lista  Lista de ufs.
     */
    public function getListaEstado()
    {
        $_lista = $this->find()
            ->select( ['Municipios.desc_estd', 'Municipios.desc_estd'] )
            ->group( ['Municipios.desc_estd'] )
            ->order( ['Municipios.desc_estd'] )
            ->toArray();
        foreach($_lista as $_l => $_Municipio)
        {
            $lista[$_Municipio->desc_estd] = $_Municipio->desc_estd;
        }

        return $lista;
    }
}
