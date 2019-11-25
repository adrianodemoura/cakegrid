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
     * Métdo de inicialização.
     *
     * @return void
     */
    public function initialize()
    {
        $pca = strtolower( $this->request->getParam('controller').'-'.$this->request->getParam('action') );
        if ( !empty($this->request->getParam('plugin')) ) { $pca = strtolower($this->request->getParam('plugin')).'-'.$pca; }
        $Sessao = $this->request->getSession();

        parent::initialize();

        $this->loadComponent('RequestHandler', ['enableBeforeRedirect' => false]);

        $this->loadComponent('Flash');

        $paramsAuth = [];
        $paramsAuth['authenticate']         = ['Form'=>['fields'=>['username'=>'email', 'password'=>'senha'], 'userModel'=>'Usuarios']];
        $paramsAuth['authError']            = false;
        $paramsAuth['loginAction']          = ['controller'=>'Usuarios', 'action'=>'login'];
        $paramsAuth['unauthorizedRedirect'] = $this->referer();

        $this->loadComponent('Auth', $paramsAuth);

        // definindo o tema padrão
        $this->viewBuilder()->setTheme('Bootstrap');

        // definindo o layout padrão
        if ( $Sessao->check('Auth.User') )
        {
            $this->viewBuilder()->setLayout('admin');
        } else
        {
            $this->viewBuilder()->setLayout('publico');
        }

    }

    /**
     * Verifica a autenticação
     *
     * @return  void 
     */
    public function isAuthorized($user)
    {
        $pca = strtolower( $this->request->getParam('controller').'-'.$this->request->getParam('action') );
        if ( !empty($this->request->getParam('plugin')) ) { $pca = strtolower($this->request->getParam('plugin')).'-'.$pca; }

        $this->log($pca, 'debug');

        return false;
    }
}
