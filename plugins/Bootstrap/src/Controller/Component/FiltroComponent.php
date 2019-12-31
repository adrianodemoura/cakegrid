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
class FiltroComponent extends Component {
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
     * Instância da Sessão do controller.
     *
     * @var     Object
     */
    private $sessao             = '';

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
        $this->controller           = $this->_registry->getController();
        $this->sessao               = $this->controller->request->getSession();
        $this->schema               = isset($config['schema'])      ? $config['schema'] : [];
        $this->chave                = isset($config['chave'])       ? $config['chave'] : $this->controller->name;
        $this->redirect             = isset($config['redirect'])    ? $config['redirect'] : '/'.Inflector::dasherize($this->controller->name);
        $modelClass                 = isset($config['modelClass'])  ? $config['modelClass'] : $this->controller->modelClass;
        $pass                       = @$this->controller->request->getParam('pass');
        $params                     = @$this->controller->request->getParam('?');

        // se pediu pra limpar o filtro
        if ( @strtolower($pass[0]) === 'limpar')
		{
			$this->sessao->delete($this->chave);
			return $this->controller->redirect( $this->redirect );
        }

        // populando a view
        $this->controller->request->addParams( ['modelClass'=>$modelClass, 'chave'=>$this->chave] );
        $this->controller->set( ['schema'=>$this->schema] );
    }

    /**
     * Configura o filtro na sessão e redireciona, caso o form seja postado.
     * 
     * @param   Array   $config     Configurações padrão do filtro.
     * @return  \Cake\Http\Response|null
     */
    private function setFiltro( array $filtros=[] )
    {
        $params             = @$this->controller->request->getParam('?');
        $pass               = @$this->controller->request->getParam('pass');
        $pagina             = 1;
        $pagina             = $this->sessao->check($this->chave.'.pagina') ? $this->sessao->read($this->chave.'.pagina') : 1;
        $limite             = $this->sessao->check($this->chave.'.limite') ? $this->sessao->read($this->chave.'.limite') : 10;
        $paramsPagina       = isset( $params['page'] )  ? (int) $params['page']   : $pagina;
        $paramsPagina       = isset( $params['pagina'] )? (int) $params['pagina'] : $paramsPagina;
        $paramsLimite       = isset( $params['limit'] ) ? (int) $params['limit']  : $limite;
        $paramsLimite       = isset( $params['limite'] )? (int) $params['limite'] : $paramsLimite;
        $filtrosEstaticos   = [];
        $urlCorrente        = $this->controller->request->here;
        $urlAnterior        = $this->controller->referer();

        // configurando a primeira página, pois o paginator helper não escreve a url completa (fio de uma égua).
        if ( !isset($params['page']) && !isset($params['sort']) && strpos($urlAnterior, $urlCorrente) )
        {
            //$paramsPagina = 1;
        }

        // gravando a página na sessão
        if ( $paramsPagina !== $pagina || !$this->sessao->check($this->chave.'.pagina'))
        {
            $this->sessao->write($this->chave.'.pagina', $paramsPagina);
        }

        // gravando o limite na sessão
        if ( $paramsLimite != $limite || !$this->sessao->check($this->chave.'.limite'))
        {
            $this->sessao->write($this->chave.'.limite', $paramsLimite);
        }

        // se possui filtro padrão
        foreach( $filtros as $_field => $_vlr)
        {
            $field = Inflector::camelize(str_replace('.','_',$_field));
            $filtrosEstaticos[] = $field;
            if ( !$this->sessao->check($this->chave.'.filtros.'.$field) ) $this->sessao->write($this->chave.'.filtros.'.$field, $_vlr);
        }
        $this->controller->request->addParams( ['filterStatics'=>$filtrosEstaticos] );

        // se o form filtro foi postado
        if ( $this->controller->request->is('post') )
        {
            $totalFilters   = 0;
            $postData       = $this->controller->request->getData();
            $this->sessao->write($this->chave.'.pagina', 1);
            $this->sessao->delete($this->chave.'.totalFiltros');

            foreach($postData as $_field => $_vlr)
            {
                if ( in_array($_field, $filtrosEstaticos) ) continue;

                if ( !strlen($_vlr) )
                {
                    $this->sessao->delete($this->chave.'.filtros.'.$_field);
                } else
                {
                    $this->sessao->write($this->chave.'.filtros.'.$_field, $_vlr);
                    $totalFilters++;
                }
            }

            if ( $totalFilters )
            {
                $this->sessao->write($this->chave.'.totalFiltros', $totalFilters);
            }

            return $this->controller->redirect( $this->redirect );
        }
    }

    /**
     * Retorna os filtros da sessão.
     */
    private function getFiltros()
    {
        $filtros        = [];

        // configurando o filtro da sessão
        $sessaoFiltros  = $this->sessao->read($this->chave.'.filtros');
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
     * @return  \Cake\Http\Response|null
     */
    private function setFilterFields()
    {
        $filterFields = [];
        foreach($this->schema as $_field => $_arrProp)
        {
            if ( @$this->schema[$_field]['filter'] )
            {
                $filterFields[] = $_field;
            }
        }

        $this->controller->request->addParams( ['filterFields'=>$filterFields]);
    }

    /**
     * Configura os campos da table
     *
     * @param   Array   $fields     Campos do filtro, no formato Table.field
     * @return  \Cake\Http\Response|null
     */
    private function setTableFields ( array $fields=[] )
    {
        foreach($fields as $_l => $_field)
        {
            $this->schema[$_field]['table'] = true;
        }

        $this->controller->request->addParams( ['tableFields'=>$fields]);
    }

    /**
     * Executa a paginação.
     *
     * @param   array   $config     Parâmetros da paginação
     * @return  \Cake\Http\Response|null
     */
    public function setPaginacao( array $config=[] )
    {
        // variáveis locais
        $modelClass                 = $this->controller->modelClass;
        $config['conditions']       = isset($config['conditions']) ? $config['conditions'] : [];

        // se possui ordem padrão
        if ( isset($config['order']) )
        {
            $this->sessao->write($this->chave.'.ordem', $config['order']);
        }

        // configura o filtro na sessão.
        $this->setFiltro( $config['conditions'] );

        // configurando a paginação
        $paramsPaginate = 
		[
			'limit' 	=> $this->sessao->read($this->chave.'.limite'),
			'page' 		=> $this->sessao->read($this->chave.'.pagina'),
			'direction' => $this->sessao->read($this->chave.'.direcao'),
            'order'     => $this->sessao->read($this->chave.'.ordem'),
            'conditions'=> $this->getFiltros(),
			'fields' 	=> isset($config['fields'])     ? $config['fields'] : null,
			'contain' 	=> isset($config['contain'])    ? $config['contain']: null,
			'group' 	=> isset($config['group'])      ? $config['group']  : null
        ];

        $this->setFilterFields();

        $this->setTableFields();

        // populando a view com a paginação e mais alguns atributos gerais
        $this->controller->paginate     = $paramsPaginate;
        $data                           = $this->controller->paginate($this->controller->$modelClass);
        $this->controller->request->addParams( ['data'=>$data]);
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
        $arquivo = $this->controller->name.'Csv-'.date('d-m-Y_H:i:s').".csv";

        $textoCsv   = '';
        $separador  = ';';
        $data       = $this->controller->$modelClass->find('all', $paramsPaginate)->toArray();
        $Entity     = $this->controller->$modelClass->newEntity();

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

        $this->controller->viewBuilder()->setLayout('csv');
        $this->controller->autoRender = false;
        $this->controller->response = $this->controller->response->withStringBody($textoCsv);
        $this->controller->response = $this->controller->response->withType('csv');
        $this->controller->response = $this->controller->response->withDownload($arquivo);
        return $this->controller->response;
    }
}
