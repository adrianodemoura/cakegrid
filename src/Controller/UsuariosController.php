<?php
namespace App\Controller;

use App\Controller\AppController;
use Exception;

/**
 * Usuarios Controller
 *
 * @method \App\Model\Entity\Usuario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsuariosController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
    }

    /**
     * Configura a autorização do usuário
     *
     * @param   object  $usuario    Dados do Usuário, como id e e-mail
     * @return  void
     */
    private function setPermissoesUsuario($usuario=null)
    {
        // recupera as permissões do usuário e configura na sessão
        $usuario['permissoes'] = 
        [
            '/painel/index' => 
            [
                'menu'      => '',
                'title'     => 'Página Inicial',
                'url'       => '/painel/index',
            ],
            '/auditorias/index' => 
            [
                'menu'      => 'Cadastros',
                'title'     => 'Auditoria',
                'url'       => '/auditorias/index',
            ],
            '/municipios/index' => 
            [
                'menu'      => 'Cadastros',
                'title'     => 'Municípios',
                'url'       => '/municipios/index',
            ],
            '/usuarios/index' => 
            [
                'menu'      => 'Cadastros',
                'title'     => 'Usuários',
                'url'       => '/usuarios/index',
            ],
            '/ferramentas/index' => 
            [
                'menu'      => 'Ferramentas',
                'title'     => 'Enviar e-mail',
                'url'       => '/ferramentas/enviar-email',
            ],
            '/relatorios/usuarios' => 
            [
                'menu'      => 'Relatórios',
                'title'     => 'Relatório de Usuários',
                'url'       => '/relatorios/usuarios',
            ],
            '/ajuda/manual' => 
            [
                'menu'      => 'Ajuda',
                'title'     => 'Manual',
                'url'       => '/ajuda/manual',
            ],
            '/ajuda/sobre' => 
            [
                'menu'      => 'Ajuda',
                'title'     => 'Sobre',
                'url'       => '/ajuda/sobre',
            ]
        ];

        // atualiza a sessão do usuário
        $this->Auth->setUser($usuario);
    }

    /**
     * Executa o logout da aplicação
     *
     * @return 	\Cake\Http\Response|null
     */
    public function logout()
    {
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
                $agora = strtotime('now');
                $this->Usuarios
                    ->query()
                    ->update()
                    ->set( ['Usuarios.ultimo_acesso' => $agora] )
                    ->where( ['Usuarios.id' => $usuario['id']])
                    ->execute();

                // configurando a sessão com os dados e permissões do usuário
                $usuario['Permissoes'] = $this->Usuarios->getPermissoes( $usuario['id']);
                $this->Auth->setUser( $usuario );

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
        $this->set(compact('tituloPagina', 'LoginForm', 'tituloPagina'));
    }

    /**
     * Exibe a tela de permissões
     *
     * @return  void
     */
    public function permissoes()
    {
        //
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

    }
}
