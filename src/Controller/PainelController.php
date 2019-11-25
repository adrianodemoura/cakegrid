<?php
namespace App\Controller;

use App\Controller\AppController;
use Exception;

/**
 * Painel Controller
 *
 *
 * @method \App\Model\Entity\Painel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PainelController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
    	// variáveis locais
        $tituloPagina = SISTEMA.' - Página Inicial';

        $this->set(compact('tituloPagina'));
    }

    /**
     * Exiba a tela de login
     *
     * @return  \Cake\Http\Response|null
     */
    public function login()
    {
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
                $this->setUsuario($usuario);

                $this->Flash->success( __('Usuário logado com sucesso !') );
                    
            } catch (Exception $e)
            {
                $this->Flash->error( $e->getMessage() );
            }

            return $this->redirect( ['action'=>'login']);
        }

        // populando a view
        $this->set(compact('tituloPagina', 'LoginForm'));
    }

    /**
     * Configura a autorização do usuário
     *
     * @param   object  $usuario    Dados do Usuário, como id e e-mail
     * @return  void
     */
    private function setUsuario($usuario=null)
    {
        // recupera as permissões do usuário e configura na sessão
        $usuario['permissoes'] = 
        [
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
                'url'       => '/auditorias/index',
            ],
            '/permissoes/index' => 
            [
                'menu'      => 'Cadastros',
                'title'     => 'Permissões',
                'url'       => '/permissoes/index',
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
}
