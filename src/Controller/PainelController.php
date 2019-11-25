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
            $this->Flash->erro( __('O usuário já se encontra autenticado !') );
            return $this->redirect('/');
        }

        $LoginForm = new \App\Form\LoginForm();

        if ( $this->request->is('post') )
        {
            if ( $LoginForm->execute($this->request->getData()) )
            {
                try
                {
                    $usuario = $this->Auth->identify();
                    $this->log($usuario);
                    if ( !$usuario )
                    {
                        throw new Exception(__('Usuário ou senha inválido, tente novamenteeee !'), 1);
                    }

                    $this->Auth->setUser($usuario);
                    $this->Flash->sucesso( __('Usuário logado com sucesso !') );
                } catch (Exception $e)
                {
                    //$this->Flash->erro( $e->getMessage() );
                }
            } else
            {
                $this->Flash->erro( $LoginForm->errors() );
            }

            return $this->redirect( ['action'=>'index']);
        }


        // populando a view
        $this->set(compact('tituloPagina', 'LoginForm'));
    }
}
