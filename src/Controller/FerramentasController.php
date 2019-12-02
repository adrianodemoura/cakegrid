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
            $this->loadModel('Auditorias');
            $this->Auditorias->auditar('cache', 'Limpei o cache do sistema');

        	$this->Flash->success(__('O Cache foi limpo com sucesso !'));
        } else
        {
            $this->Flash->error(__('Não foi possível limpar o cache !'));
        }

        return $this->redirect('/');
    }

    /**
     * Recarregar as permissões
     *
     * @return  \Cake\Network\Response|null
     */
    public function recarregarPermissoes()
    {
        $Sessao     = $this->request->getSession();
        $idUsuario  = $Sessao->read('Auth.User.id');

        $this->loadModel('Usuarios');

        $permissoes = $this->Usuarios->getPermissoes( $idUsuario );

        $Sessao->write('Auth.User.Permissoes', $permissoes);

        $this->Flash->success(__('As permissões foram atualizadas com sucesso !'));

        return $this->redirect('/');
    }

    /**
     * Exibe a tela para alterar a Unidade
     *
     * @return  \Cake\Network\Response|null
     */
    public function alterarUnidade()
    {
        
    }
}