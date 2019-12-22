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
     * Nome da chave.
     * 
     * @var     string
     */
    private $chave  = '';

    /**
     * Controller de redirecionamentos.
     * 
     * @var     string
     */
    private $controllerRedirect = '';

    /**
     * Action de redirecionamentos
     * 
     * @var     string
     */
    private $actionRedirect = 'index';

    /**
     * Método de inicilização do componente.
     * 
     * ### Config
     * 
     * @param   array   $config     Configurações do componente.
     */
    public function initialize( array $config=[] )
    {
        $controller                 = $this->_registry->getController();
        $this->chave                = isset($config['chave']) ? $config['chave'] : $controller->name;
        $this->controllerRedirect   = isset($config['controllerRedirect']) ? $config['controllerRedirect'] : $controller->name;
        $this->actionRedirect       = isset($config['actionRedirect']) ? $config['actionRedirect'] : $this->actionRedirect;
        $modelClass                 = isset($config['modelClass']) ? $config['modelClass'] : $controller->modelClass;
        $Sessao                     = $controller->request->getSession();
        $totalFiltros               = count($Sessao->read($this->chave.'.Filtro'));
        $params                     = @$controller->request->getParam('?');
        $pass                       = @$controller->request->getParam('pass');
        $pagina                     = 1;

        // se pediu pra limpar o filtro
        if ( @strtolower($pass[0]) === 'limpar')
		{
			$Sessao->delete($this->chave);
			return $controller->redirect( ['controller'=>$this->controllerRedirect, 'action'=>$this->actionRedirect] );
        }
        
        // se o form foi postado
        if ( $controller->request->is('post') )
        {
            $postData = $controller->request->getData();

            foreach($postData as $_campo => $_vlr) { if ( !strlen($_vlr) ) { unset($postData[$_campo]); }}

            $Sessao->write($this->chave.'.Filtro', $postData );
            $Sessao->write($this->chave.'.pagina', 1);

            return $controller->redirect( ['controller'=>$this->controllerRedirect, 'action'=>$this->actionRedirect] );
        }

        // gravando o filtro na sessão
        $ordem 		= $Sessao->check($this->chave.'.ordem') 	? $Sessao->read($this->chave.'.ordem') 	: $controller->$modelClass->displayField();
		$direcao	= $Sessao->check($this->chave.'.direcao')   ? $Sessao->read($this->chave.'.direcao') 	: 'ASC';
		$limite		= $Sessao->check($this->chave.'.limite') 	? $Sessao->read($this->chave.'.limite') 	: 10;
		$pagina		= $Sessao->check($this->chave.'.pagina') 	? $Sessao->read($this->chave.'.pagina') 	: $pagina;
		$pagina 	= isset($params['page'])		? $params['page'] 		: $pagina;
		$ordem 		= isset($params['sort']) 		? $params['sort'] 		: $ordem;
		$direcao 	= isset($params['direction'])   ? $params['direction'] 	: $direcao;
        $limite 	= isset($params['limit'])       ? $params['limit'] 	    : $limite;
        if ( !@$params['page'] && @$params['sort'] ) // primeira página porque o filho de uma égua do PaginatorHelper não escreve o page na url.
        {
            $pagina = 1;
        }
		$Sessao->write($this->chave.'.ordem', $ordem);
		$Sessao->write($this->chave.'.direcao', $direcao);
        $Sessao->write($this->chave.'.pagina', $pagina);
        $Sessao->write($this->chave.'.limite', $limite);

        // populando a view
        $controller->request->addParams(['modelClass'=>$modelClass, 'chave'=>$this->chave, 'totalFiltros'=>$totalFiltros]);
        $controller->set( ['chave'=>$this->chave] );
    }

    /**
     * Executa a paginação.
     * *
     * @param   array   $config     Parâmetros da paginação
     * @return  \Cake\Http\Response|null
     */
    public function setPaginacao( array $config=[] )
    {
        // variáveis locais
        $controller                 = $this->_registry->getController();
        $Sessao                     = $this->request->getSession();
        $modelClass                 = $controller->modelClass;
        $pass0                      = @strtolower($this->request->getParam('pass')[0]);
        $filtros                    = [];

        // configurando o filtro da sessão
        $sessaoFiltros = $Sessao->read($this->chave.'.Filtro');
        if ( count($sessaoFiltros) )
        {
            foreach($sessaoFiltros as $_campo => $_vlr)
            {
                $field      = isset($config[$_campo]['name'])       ? $config[$_campo]['name']      : '';
                $field      = empty($field)                         ? str_replace('_','.',$_campo)  : $field;
                $operador   = isset($config[$_campo]['operator'])   ? $config[$_campo]['operator']  : '';
                $mask       = isset($config[$_campo]['mask'])       ? $config[$_campo]['mask']      : '';
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
                    $filtros[] = [trim($field.' '.$operador) => $vlr];
                }
            }
        }

        // incrementando filtros obrigatórios
        if ( isset($config['conditions']) )
        {
            $filtros += $config['conditions'];
        }

        // configurando a paginação
        $paramsPaginate = 
		[
			'limit' 	=> $Sessao->read($this->chave.'.limite'),
			'page' 		=> $Sessao->read($this->chave.'.pagina'),
			'sort' 		=> $Sessao->read($this->chave.'.ordem'),
			'direction' => $Sessao->read($this->chave.'.direcao'),
            'conditions'=> $filtros,
			'fields' 	=> isset($config['fields'])     ? $config['fields'] : null,
			'contain' 	=> isset($config['contain'])    ? $config['contain']: null,
			'group' 	=> isset($config['group'])      ? $config['group']  : null
        ];

        if ( $pass0 === 'exportar' )
        {
            unset($paramsPaginate['limit']);
            unset($paramsPaginate['page']);
            $arquivo = $controller->name.'Csv-'.date('d-m-Y_H:i:s').".csv";

            $textoCsv   = '';
            $separador  = ';';
            $data       = $controller->$modelClass->find('all', $paramsPaginate)->toArray();
            $Entity     = $controller->$modelClass->newEntity();
            $this->log($Entity->aliasFields);
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
        } else
        {
            // populando a view com a paginação e mais alguns atributos gerais
            $controller->paginate       = $paramsPaginate;
            $controller->request->data  = $controller->paginate($controller->$modelClass);
        }

    }
}
