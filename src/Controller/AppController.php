<?php
/**
 * Class AppController
 *
 * @package     cakeGrid.Controller
 * @author      Adriano Moura
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use Cake\Controller\Controller;
use Cake\Event\Event;
/**
 * Mantém o controlador pai de todos
 */
class AppController extends Controller {
    /**
     * Plugin, Controller e Action
     *
     * @var     string
     * @access  private
     */
    private $pca = '';

    /**
     * Métdo de inicialização.
     *
     * @return void
     */
    public function initialize()
    {
        // configurando o pca
        $pca = '/'.$this->request->getParam('controller').'/'.$this->request->getParam('action');
        if ( !empty($this->request->getParam('plugin')) ) { $pca = '/'.$this->request->getParam('plugin').$pca; }
        $this->pca = $pca;

        parent::initialize();

        // componentes
        $this->loadComponent('RequestHandler', ['enableBeforeRedirect' => false]);
        $this->loadComponent('Flash');
        $paramsAuth = [];
        $paramsAuth['authorize']            = 'Controller';
        $paramsAuth['authenticate']         = ['Form'=>['fields'=>['username'=>'email', 'password'=>'senha'], 'userModel'=>'Usuarios']];
        $paramsAuth['authError']            = __('Você não possui permissão para acessar '.$pca);
        $paramsAuth['loginAction']          = ['controller'=>'Painel', 'action'=>'login'];
        $paramsAuth['unauthorizedRedirect'] = $this->referer();
        $this->loadComponent('Auth', $paramsAuth);

        // definindo o tema padrão
        $this->viewBuilder()->setTheme('Bootstrap');

        // definindo o layout padrão
        $this->viewBuilder()->setLayout('publico');
    }

    /**
     * Verifica a autenticação
     *
     * @return  void 
     */
    public function isAuthorized($user = null)
    {
        //return true;
        // recuperando a sessão
        $Sessao = $this->request->getSession();

        // alteando o layout administrativo.
        $this->viewBuilder()->setLayout('admin');

        // pcas sem permissão
        $pcasSemPermissao = ['/painel/logout', '/painel/acessonegado'];

        // permitindo alguns pcas
        if ( in_array(strtolower($this->pca), $pcasSemPermissao) || isset($user['Permissoes'][strtolower($this->pca)]) )
        {
            return true;
        }

        //$this->log($user['Permissoes']);
        $this->Flash->error( __('Acesso negado para '.$this->pca) );

        return $this->redirect( ['controller'=>'Painel', 'action'=>'acessoNegado'] );
    }
}
