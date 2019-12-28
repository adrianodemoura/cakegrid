<?php
/**
 * Schema helper
 */
namespace Bootstrap\View\Helper;
use Cake\View\Helper;
use Cake\View\View;
/**
 * mantém o Schema
 */
class SchemaHelper extends Helper {
    /**
     * Configuração padrão.
     *
     * @var     array
     */
    protected $_defaultConfig = [];

    /**
     * Campos do schema.
     *
     * @var     array
     */
    private $fields = [];

    /**
     * Constructor hook method.
     *
     * Implement this method to avoid having to overwrite the constructor and call parent.
     *
     * @param array $config The configuration settings provided to this helper.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->fields = $config['schema'];
    }

    /**
     * Retorn atodos os campos do schema.
     *
     * @return  array   this.fields
     */
    public function fields()
    {
        return $this->fields;
    }

     /**
     */

    public function field(String $field='')
    {
        return $this->fields[$field];
    }

    /**
     * Retorna as informações
     *
     * @param   string  $field  Nome do campo no schema.
     * @return  void
     */
    public function info(String $field='')
    {
        if ( strlen($field) ) 
        {
            return [ $field => $this->fields[$field]];
        }

        return $this->fields;
    }

    /**
     * Configura o schema que está no request.
     *
     * @param   string  $fieldPath      Nome do campo seguindo seu atributo.
     * @param   mixed   $vlr            Valor a ser configurando no atributo do schema.
     */
    public function set(String $fieldPath='', $vlr=null)
    {
        $arrField   = explode('.', $fieldPath);
        $field      = $arrField[0].'.'.$arrField[1];
        $tag        = $arrField[2];

        $this->fields[$field][$tag] = $vlr;
    }

}
