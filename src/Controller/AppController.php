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
use Cake\Utility\Inflector;
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
        // recuperando a sessão
        $Sessao = $this->request->getSession();

        // configurando o pca
        $pca = '/'.Inflector::dasherize($this->request->getParam('controller'));
        $pca .= '/'.Inflector::dasherize($this->request->getParam('action'));
        if ( !empty($this->request->getParam('plugin')) )
        {
            $pca = '/'.Inflector::dasherize($this->request->getParam('plugin')).$pca;
        }
        $pca = strtolower($pca);
        $this->pca = $pca;

        parent::initialize();

        // componentes
        $this->loadComponent('RequestHandler', ['enableBeforeRedirect' => false]);
        $this->loadComponent('Flash');
        $paramsAuth = [];
        $paramsAuth['authorize']            = 'Controller';
        $paramsAuth['authenticate']         = ['Form'=>['fields'=>['username'=>'email', 'password'=>'senha'], 'userModel'=>'Usuarios']];
        $paramsAuth['authError']            = __('Você não possui permissão para acessar '.$this->pca);
        $paramsAuth['loginAction']          = ['controller'=>'Painel', 'action'=>'login'];
        $paramsAuth['unauthorizedRedirect'] = ['controller'=>'Painel', 'action'=>'acessoNegado'];
        $this->loadComponent('Auth', $paramsAuth);

        // definindo o tema padrão
        $this->viewBuilder()->setTheme('Bootstrap');

        // definindo o layout padrão
        $this->viewBuilder()->setLayout('publico');

        // Se o usuário está logado, mas ainda não foi definido o papel. força sua escolha.
        if ( $Sessao->check('Auth.User.id') && !$Sessao->check('Auth.User.PapelAtivo') )
        {
            $Sessao->delete('Flash');
            $Sessao->delete('flash');
            $this->Flash->error( __('O Papel ainda não foi definido !') );

            // se o papel não foi escolhido ainda, força sua escolha.
            if ( !in_array(strtolower($this->pca), ['/ferramentas/trocar-papel', '/painel/logout']) )
            {
                return $this->redirect( ['controller'=>'Ferramentas', 'action'=>'trocarPapel'] );
            }
        }
    }

    /**
     * Verifica a autenticação
     *
     * @param   array   $user   Dados do Usuário logado, incluindo registro e permissões no formato PERFIL-UNIDADE-PERMISSÕES.
     * @return  void 
     */
    public function isAuthorized($user = null)
    {
        // recuperando a sessão
        $Sessao     = $this->request->getSession();
        $papelAtivo = $Sessao->read('Auth.User.PapelAtivo');
        
        // alterando o layout administrativo.
        $this->viewBuilder()->setLayout('admin');

        // permitindo alguns pcas
        $pcasSemPermissao = ['/painel/index', '/painel/logout', '/painel/acesso-negado', '/ferramentas/trocar-papel'];
        if ( in_array($this->pca, $pcasSemPermissao) || isset($user['Permissoes'][$papelAtivo][$this->pca]) )
        {
            //$this->log('tem permissão: '.$this->pca);
            return true;
        }
        
        //$this->log('NÃO tem permissão: '.$this->pca);
        return false;
    }
}
