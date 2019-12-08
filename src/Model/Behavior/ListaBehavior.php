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
     * @param   boolean $cache      Se verdadeiro joga a lista no cache, se Falso não.
     * @param   array   $arrFields  Primeiro e segundo campo da lista.
     * @return 	array 	$lista      Lista no formato campo1 = campo2
     */
    public function getLista( Array $arrFields=[], $cache=false )
    {
    	$alias 			= $this->_table->getAlias();
    	$pk 			= isset($arrFields[0]) ? $arrFields[0] : $this->_table->getPrimaryKey();
        $displayField 	= isset($arrFields[1]) ? $arrFields[1] : $this->_table->getDisplayField();

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
