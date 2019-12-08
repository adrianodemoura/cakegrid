<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * Lista behavior
 */
class ListaBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Retorna a lista
     *
     * @return 	array 	$lista
     */
    public function getLista($cache=false)
    {
    	$alias 			= $this->_table->getAlias();
    	$pk 			= $this->_table->getPrimaryKey();
    	$displayField 	= $this->_table->getDisplayField();

    	$_lista = $this->_table->find()
    		->select( [$alias .'.'. $pk, $alias .'.'.$displayField] )
    		->order( [$alias .'.'. $displayField] )
    		->toArray();
    	foreach($_lista as $_l => $_Entity)
    	{
    		$lista[$_Entity->$pk] = $_Entity->$displayField;
    	}

    	return $lista;
    }
}
