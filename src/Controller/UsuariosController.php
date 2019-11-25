<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Usuarios Controller
 *
 *
 * @method \App\Model\Entity\Usuario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsuariosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        
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
}
