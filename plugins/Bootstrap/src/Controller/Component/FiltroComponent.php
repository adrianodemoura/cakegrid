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

        // se pediu pra limpar o filtro
        $pass0 = @strtolower($this->request->getParam('pass')[0]);
        if ( $pass0 === 'limpar')
		{
			$Sessao->delete($this->chave);
			return $controller->redirect( ['controller'=>$this->controllerRedirect, 'action'=>$this->actionRedirect] );
        }
        
        // se o form foi postado
        if ( $controller->request->is('post') )
        {
            $postData = $this->request->getData();
            $this->log($postData, 'debug');
            foreach($postData as $_campo => $_vlr)
            {
                if ( !strlen($_vlr) )
                {
                    unset($postData[$_campo]);
                }
            }

            $Sessao->write($this->chave.'.Filtro', $postData );
            $Sessao->write($this->chave.'.pagina', 1);

            return $controller->redirect( ['controller'=>$this->controllerRedirect, 'action'=>$this->actionRedirect] );
        }

        // gravando o filtro na sessão
        $ordem 		= $Sessao->check($this->chave.'.ordem') 	? $Sessao->read($this->chave.'.ordem') 	: $controller->$modelClass->displayField();
		$direcao	= $Sessao->check($this->chave.'.direcao')   ? $Sessao->read($this->chave.'.direcao') 	: 'ASC';
		$limite		= $Sessao->check($this->chave.'.limite') 	? $Sessao->read($this->chave.'.limite') 	: 10;
		$pagina		= $Sessao->check($this->chave.'.pagina') 	? $Sessao->read($this->chave.'.pagina') 	: 1;
		$pagina 	= isset($this->request->getParam('?')['page'])		? $this->request->getParam('?')['page'] 		: $pagina;
		$ordem 		= isset($this->request->getParam('?')['sort']) 		? $this->request->getParam('?')['sort'] 		: $ordem;
		$direcao 	= isset($this->request->getParam('?')['direction']) ? $this->request->getParam('?')['direction'] 	: $direcao;
		$limite 	= isset($this->request->getParam('?')['limit'])     ? $this->request->getParam('?')['limit'] 	    : $limite;
		$Sessao->write($this->chave.'.ordem', $ordem);
		$Sessao->write($this->chave.'.direcao', $direcao);
        $Sessao->write($this->chave.'.pagina', $pagina);
        $Sessao->write($this->chave.'.limite', $limite);

        // populando a view
        $this->request->params['modelClass']= $modelClass;
        $this->request->params['chave']     = $this->chave;
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
			'contain' 	=> isset($config['contain']) ? $config['contain'] : null
        ];

        // populando a view com a paginação e mais alguns atributos gerais
        $controller->paginate   = $paramsPaginate;
        $this->request->data    = $controller->paginate($controller->$modelClass);
    }
}
