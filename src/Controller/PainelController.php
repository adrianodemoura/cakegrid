<?php
/**
 * Controller Painel
 *
 * @package     cakegrid.Controller
 * @author      Adriano Moura
 */
namespace App\Controller;
use App\Controller\AppController;
use Exception;
/**
 * Mantém o painel do sistema.
 */
class PainelController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $tituloPagina   = SISTEMA.' - Página Inicial';

        $this->loadModel('Usuarios');
        $permissoes = $this->Usuarios->getPermissoes($_SESSION['Auth']['User']['id']);

        $this->set( compact( 'tituloPagina' ) );
    }

    /**
     * Executa o logout do sistema.
     *
     * @return  \Cake\Http\Response|null
     */
    public function logout()
    {
        $this->loadModel('Auditorias');

        $this->Auditorias->auditar('acessos', 'O Usuário saiu do sistema');

        $this->Flash->success( __('Logout efetuado com sucesso.') );
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Exibe a tela de login
     *
     * @return  \Cake\Http\Response|null
     */
    public function login()
    {
        $tituloPagina = 'Login';
        $Sessao = $this->request->getSession();

        if ( $Sessao->check('Auth.User') )
        {
            $this->Flash->error( __('O usuário já se encontra autenticado !') );
            return $this->redirect('/');
        }

        $LoginForm = new \App\Form\LoginForm();

        if ( $this->request->is('post') )
        {
            try
            {
                $this->loadModel('Usuarios');
                $this->loadModel('Auditorias');

                if ( !$LoginForm->execute($this->request->getData()) )
                {
                    throw new Exception(__('Parâmetro errado para login !'), 1);
                }

                $usuario = $this->Auth->identify();
                if ( !$usuario )
                {
                    throw new Exception(__('Usuário ou senha inválido, tente novamente !'), 2);
                }

                // atualizando o último acesso do usuário
                $agora = date('Y-m-d H:i:s', strtotime('now'));
                $this->Usuarios
                    ->query()
                    ->update()
                    ->set( ['Usuarios.ultimo_acesso' => $agora] )
                    ->where( ['Usuarios.id' => $usuario['id']] )
                    ->execute();

                // configurando a sessão com os dados e permissões do usuário
                $usuario['Permissoes'] = $this->Usuarios->getPermissoes( $usuario['id'] );
                $this->Auth->setUser( $usuario );

                // auditando o acesso do usuário
                $this->Auditorias->auditar('acessos', 'O Usuário entrou no sistema');

                // retornando pra página inicial
                $this->Flash->success( __('Usuário logado com sucesso !') );
                return $this->redirect('/');
            } catch (Exception $e)
            {
                $erro = $e->getMessage();
                if ( $e->getCode() === 500) { $erro = 'A instalação não foi executada ainda !'; }

                $this->Flash->error( $erro );
                return $this->redirect( ['action'=>'login']);
            }
        }

        // populando a view
        $this->set(compact('tituloPagina', 'LoginForm'));
    }

    /**
     * Exibe a tela de informações do 
     *
     * @return  void
     */
    public function info()
    {
        //
    }

    /**
     * Exibe a tela para usuários sem permissão.
     *
     * @return  void
     */
    public function acessoNegado()
    {
        $Sessao     = $this->request->getSession();
        $pcaNegada  = $Sessao->read('Flash.flash.0.message');

        $this->set( compact('pcaNegada') );
    }
}
