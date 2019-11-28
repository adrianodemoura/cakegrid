<?php
namespace App\Controller;

use App\Controller\AppController;

class FerramentasController extends AppController {
	/**
	 * Exibe a página inicial do cadastro de ferramentas.
	 *
	 * @return 	void
	 */
	public function index()
	{
	}

	/**
     * Limpa o cache
     *
     * @return \Cake\Network\Response|null
     */
    public function limparCache()
    {

    	$shell 	= new \Cake\Console\ShellDispatcher();
        $output = $shell->run(['cake', 'cache', 'clear_all']);

        if (0 === $output)
        {
        	$this->Flash->success(__('O Cache foi limpo com sucesso !'));
        } else
        {
            $this->Flash->error(__('Não foi possível limpar o cache !'));
        }

        return $this->redirect('/');
    }
}