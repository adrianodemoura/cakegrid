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
     * Recarregar as permissões do Usuário
     *
     * @param   integer     $idUSuario  Id do usuário, recuperado da sessão.
     * @return  \Cake\Network\Response|null
     */
    public function recarregarPermissoes()
    {
        $Sessao     = $this->request->getSession();

        $idUsuario  = $Sessao->read('Auth.User.id');

        $this->loadModel('Usuarios');

        $Sessao->write('Auth.User.Permissoes', $this->Usuarios->getPermissoes( $idUsuario ) );

        $this->Flash->success(__('As permissões foram atualizadas com sucesso !'));

        return $this->redirect('/');
    }

    /**
     * Exibe a tela para trocar de papel
     *
     * @return  \Cake\Http\Response|null
     */
    public function trocarPapel()
    {
        $tituloPagina       = 'Escolhendo o Papel';
        $Sessao             = $this->request->getSession();
        $FormTrocarPapel    = new \App\Form\FormTrocarPapel();

        if ( $this->request->is('post') )
        {
            try
            {
                if ( !$FormTrocarPapel->execute($this->request->getData()) )
                {
                    throw new Exception(__('Erro ao escolher Papel !'), 1);
                }

                $Sessao->write('Auth.User.PapelAtivo', $this->request->data['papel']);

                $this->Flash->success( __('Papel Atualizado com sucesso para: '.$Sessao->read('Auth.User.PapelAtivo')) );
            } catch (Exception $e)
            {
                $this->Flash->error( $e->getMessage() );
            }
            return $this->redirect( '/' );
        }

        // populando a view
        $this->set( compact('tituloPagina', 'FormTrocarPapel') );
    }
}