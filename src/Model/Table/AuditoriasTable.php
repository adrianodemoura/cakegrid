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
 * Auditorias Model
 *
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 *
 * @method \App\Model\Entity\Auditoria get($primaryKey, $options = [])
 * @method \App\Model\Entity\Auditoria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Auditoria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Auditoria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Auditoria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Auditoria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Auditoria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Auditoria findOrCreate($search, callable $callback = null, $options = [])
 */
class AuditoriasTable extends Table
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

        $this->setTable('auditorias');
        $this->setDisplayField('motivo');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Auditoria');
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
            ->scalar('ip')
            ->maxLength('ip', 20)
            ->notEmptyString('ip');

        $validator
            ->scalar('motivo')
            ->maxLength('motivo', 50)
            ->notEmptyString('motivo');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 250)
            ->notEmptyString('descricao');

        $validator
            ->dateTime('data')
            ->notEmptyDateTime('data');

        return $validator;
    }

    /**
     * Modifica a entidade antes de salvar, desta forma os campos serão persistidos no banco de dados também.
     *
     * @param   \Cake\Event\Event                   $event The beforeSave event that was fired
     * @param   \Cake\Datasource\EntityInterface    $entity The entity that is going to be saved
     * @param   \ArrayObject                        $options the options passed to the save method
     * @return  void
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $entity['ip']               = IP;
        $entity['data']             = date('Y-m-d H:i:s');
        $entity['usuario_id']       = $_SESSION['Auth']['User']['id'];
    }

    /**
     * Salva uma auditoria
     *
     * @param   string      $motivo     Motivo da auditoria
     * @param   string      $descricao  Descrição da Auditoria.
     * @return  boolean     boolean     Verdadeiro em caso de sucesso, Falso se não.
     */
    public function auditar($motivo='', $descricao='')
    {
        $Auditoria                  = $this->newEntity();
        $Auditoria->motivo          = $motivo;
        $Auditoria->descricao       = $descricao;

        if ( !$this->save($Auditoria) ) return false; else return true;
    }
}
