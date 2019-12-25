<?php
/**
 * Filtro Componente
 * 
 * @package     Bootstrap.Controller.Component
 * @author      Adriano Moura
 */
namespace Bootstrap\Controller\Component;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Utility\Inflector;
/**
 * Mantém o filtro do plugin Bootstrap.
 */
class FiltroComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Controller de herança
     *
     * @var     Object
     */
    private $controller         = '';

    /**
     * Destino usado para redirecionamento quando o form de filtro é postado.
     * 
     * @var     string
     */
    private $redirect           = '';

    /**
     * Nome da chave.
     * 
     * @var     string
     */
    private $chave              = '';

    /**
     * Propriedades de cada campo.
     * 
     * @var     array
     */
    private $schema             = [];

    /**
     * Método de inicilização do componente.
     * 
     * ### Config
     * 
     * @param   array   $config     Configurações do componente.
     * @return  \Cake\Http\Response|null
     */
    public function initialize( array $config=[] )
    {
        $controller                 = $this->_registry->getController();
        $this->controller           = $this->_registry->getController();
        $this->schema               = isset($config['schema'])      ? $config['schema'] : [];
        $this->chave                = isset($config['chave'])       ? $config['chave'] : $controller->name;
        $this->redirect             = isset($config['redirect'])    ? $config['redirect'] : '/'.Inflector::dasherize($controller->name);
        $modelClass                 = isset($config['modelClass'])  ? $config['modelClass'] : $controller->modelClass;
        $Sessao                     = $controller->request->getSession();
        $params                     = @$controller->request->getParam('?');
        $pass                       = @$controller->request->getParam('pass');
        $chave                      = $this->chave;

        // se pediu pra limpar o filtro
        if ( @strtolower($pass[0]) === 'limpar')
		{
			$Sessao->delete($this->chave);
			return $controller->redirect( $this->redirect );
        }

        // populando a view
        $controller->request->addParams( ['modelClass'=>$modelClass, 'chave'=>$this->chave] );
        $controller->set( compact('chave') );
    }

    /**
     * Configura as propriedades de um campo do schema.
     * 
     * @param   string  $field      Nome do campo, no formato Table_field
     * @param   array   $params     Propriedades do campo.
     * @return  \Cake\Http\Response|null
     */
    public function setSchema( $field='', $params=[] )
    {
        $this->schema[ $field ] = $params;
    }

    /**
     * Retorna o parâmetro de um campo do schema.
     * 
     * @param   string  $fieldParam     Nome do campo e do parâmetro, exemplo: Usuario.nome.name
     * @return  string  $valor          Valor da chave.
     */
    public function getSchema( $fieldParam='' )
    {
        $arrFieldParam  = explode( '.', $fieldParam );
        $field          = $arrFieldParam[0].'_'.$arrFieldParam[1];
        $fieldPonto     = $arrFieldParam[0].'.'.$arrFieldParam[1];
        $parametro      = str_replace($fieldPonto.'.','', $fieldParam);
        $arrOriginal    = $this->schema[$field];
        $total          = (int) substr_count($parametro, '.');
        $retorno        = @$arrOriginal[$parametro];

        if ( $total )
        {
            $arrLoop    = explode('.', $parametro);
            $arr        = @$arrOriginal[$arrLoop[0]];
            unset($arrLoop[0]);
            foreach( $arrLoop as $_l => $_tag )
            {
                if ( !isset($arr[$_tag]) ) return null;

                if ( is_array( $arr[$_tag] ) )
                {
                    $arr        = $arr[$_tag];
                    $retorno    = $arr;
                } else
                {
                    $retorno    = $arr[$_tag];
                }
            }
        }

        return $retorno;
    }

    /**
     * Configura o filtro na sessão e redireciona, caso o form seja postado.
     * 
     * @param   Array   $config     Configurações padrão do filtro.
     * @return  \Cake\Http\Response|null
     */
    private function setFiltro( array $config=[] )
    {
        $controller = $this->_registry->getController();
        $Sessao     = $controller->request->getSession();

        // se o form filtro foi postado
        if ( $controller->request->is('post') )
        {
            $postData = $controller->request->getData();
            $this->controller->log($postData);
    
            foreach($postData as $_campo => $_vlr)
            {
                if ( !strlen($_vlr) )
                {
                    unset($postData[$_campo]);
                }
            }
    
            $Sessao->write($this->chave.'.filtros', $postData );
            $Sessao->write($this->chave.'.pagina', 1);
    
            return $controller->redirect( $this->redirect );
        }

        // calculando o total de filtros e jogando na request para ser recuperada na view.
        $totalFiltros = count( $Sessao->read($this->chave.'.filtros') );
        $controller->request->addParams( ['totalFiltros'=>$totalFiltros] );
    }

    /**
     * Retorna os filtros da sessão.
     */
    private function getFiltros()
    {
        $filtros        = [];
        $controller     = $this->_registry->getController();
        $Sessao         = $controller->request->getSession();

        // configurando o filtro da sessão
        $sessaoFiltros  = $Sessao->read($this->chave.'.filtros');
        if ( count($sessaoFiltros) )
        {
            foreach($sessaoFiltros as $_campo => $_vlr)
            {
                $campo      = ucfirst(str_replace('_','.',Inflector::underscore($_campo)));
                $propField  = isset($this->schema[$campo])          ? $this->schema[$campo]     : [];
                $field      = isset($propField['name'])             ? $propField['name']        : '';
                $field      = empty($field)                         ? str_replace('_','.',$_campo)  : $field;
                $operador   = isset($propField['operator'])         ? $propField['operator']    : '';
                $mask       = isset($propField['mask'])             ? $propField['mask']        : '';

                if ( strlen(trim($_vlr)) && strlen($field) )
                {
                    $vlr = $_vlr;
                    if ( strlen($mask) )
                    {
                        if ( strpos($mask,'u') > -1 )
                        {
                            $vlr = str_replace( 'u', mb_strtoupper($vlr), $mask );
                        }
                        if ( strpos($mask,'v') > -1 )
                        {
                            $vlr = str_replace( 'v', $vlr, $mask );
                        }
                    }
                    $filtros[] = [trim(str_replace('_','.',Inflector::underscore($field)).' '.$operador) => $vlr];
                }
            }
        }

        return $filtros;
    }

    /**
     * Configura os campos que serão filtrados na paginação.
     *
     * @param   Array   $fields     Campos do filtro, no formato Table.field
     * @return  \Cake\Http\Response|null
     */
    private function setFilterFields()
    {
        $configFilter   = [];
        $Sessao         = $this->controller->request->getSession();

        foreach( $this->schema as $_field => $_arrProp)
        {
            $title      = isset($_arrProp['title']) ? $_arrProp['title'] : Inflector::singularize($_field);
            $field      = Inflector::camelize(str_replace('.', '_', $_field));
            $configFilter['fields'][$field] =
            [
                'id'            => 'Filtro'.$field,
                'name'          => $field,
                'label'         => false,
                'class'         => 'form-control mx-2',
                'value'         => $Sessao->read($this->chave.'.filtros.'.$field),
                'placeholder'   => "-- $title --"
            ];
        }

        $this->controller->set( compact('configFilter') );
    }

    /**
     * Configura os campos da table
     *
     * @return  \Cake\Http\Response|null
     */
    private function setTableFields ()
    {
        $modelClass     = $this->controller->modelClass;
        foreach( $this->schema as $_field => $_arrProp)
        {
            $naTable = @$_arrProp['table'];
            if ( $naTable )
            {
                $configTable['fields'][] = $_field;
            }
        }

        $this->controller->set( compact('configTable') );
    }

    /**
     * Executa a paginação.
     * *
     * @param   array   $config     Parâmetros da paginação
     * @return  \Cake\Http\Response|null
     */
    public function setPaginacao( array $config=[] )
    {
        // configura o filtro na sessão.
        $this->setFiltro( $config );

        // variáveis locais
        $controller                 = $this->_registry->getController();
        $Sessao                     = $controller->request->getSession();
        $modelClass                 = $controller->modelClass;
        $pass0                      = @strtolower($controller->request->getParam('pass')[0]);

        // se possui ordem padrão
        if ( isset($config['order']) )
        {
            $Sessao->write($this->chave.'.ordem', $config['order']);
        }
        // se possui filtro padrão
        if ( isset($config['conditions']) )
        {
            $Sessao->write($this->chave.'.filtros', $config['conditions']);
        }

        // configurando a paginação
        $paramsPaginate = 
		[
			'limit' 	=> $Sessao->read($this->chave.'.limite'),
			'page' 		=> $Sessao->read($this->chave.'.pagina'),
			'direction' => $Sessao->read($this->chave.'.direcao'),
            'order'     => $Sessao->read($this->chave.'.ordem'),
            'conditions'=> $this->getFiltros(),
			'fields' 	=> isset($config['fields'])     ? $config['fields'] : null,
			'contain' 	=> isset($config['contain'])    ? $config['contain']: null,
			'group' 	=> isset($config['group'])      ? $config['group']  : null
        ];

        $this->setFilterFields();

        $this->setTableFields();

        // populando a view com a paginação e mais alguns atributos gerais
        $controller->paginate       = $paramsPaginate;
        $data                       = $controller->paginate($controller->$modelClass);
        $controller->request->addParams( ['data'=>$data, 'schema'=>$this->schema]);
    }

    /**
     * Exportando o filtro
     * 
     * @return  \Cake\Http\Response|null
     */
    public function exportar()
    {
        unset($paramsPaginate['limit']);
        unset($paramsPaginate['page']);
        $arquivo = $controller->name.'Csv-'.date('d-m-Y_H:i:s').".csv";

        $textoCsv   = '';
        $separador  = ';';
        $data       = $controller->$modelClass->find('all', $paramsPaginate)->toArray();
        $Entity     = $controller->$modelClass->newEntity();

        foreach($data as $_l => $_Entity)
        {
            $arrFields      = $_Entity->toArray();
            $aliasFields    = $_Entity->_aliasFields;
            if ( !$_l)
            {
                foreach($arrFields as $_field => $_vlrField)
                {
                    $field = Inflector::camelize($_field);
                    $textoCsv .= $field . $separador;
                }
                $textoCsv .= "\n";
            }
            foreach($arrFields as $_field => $_vlrField)
            {
                if ( !is_array($_vlrField) )
                {
                    $textoCsv .= $_vlrField . $separador;
                } else
                {
                    foreach($_vlrField as $_field2 => $_vlrField2)
                    {
                        if ( !is_array($_vlrField2) )
                        {
                            $textoCsv .= $_vlrField2.', ';
                        } else
                        {
                            foreach($_vlrField2 as $_field3 => $_vlrField3)
                            {
                                $textoCsv .= $_vlrField3.', ';
                            }
                        }
                    }
                }
            }

            $textoCsv .= "\n";
        }

        $controller->viewBuilder()->setLayout('csv');
        $controller->autoRender = false;
        $controller->response = $controller->response->withStringBody($textoCsv);
        $controller->response = $controller->response->withType('csv');
        $controller->response = $controller->response->withDownload($arquivo);
        return $controller->response;
    }
}
