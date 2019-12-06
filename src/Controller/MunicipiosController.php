<?php
/**
 * Class Municipios
 */
namespace App\Controller;
use App\Controller\AppController;
use Exception;
/**
 * Mantém o cadastro de municipios.
 */
class MunicipiosController extends AppController {
	/**
	 * Tela inicial do cadastro de municípios.
	 *
	 * @return 	\Cake\Http\Response|null
	 */
	public function index()
	{
		$chave 		= $this->name;
		$Sessao 	= $this->request->getSession();
		$pass0 		= @strtolower($this->request->getParam('pass')[0]);
		$filtros 	= [];

		if ( $pass0 === 'limpar')
		{
			$Sessao->delete($chave);
			return $this->redirect( ['action'=>'index'] );
		}

		if ( $this->request->is('post') )
        {
        	$Sessao->write($chave.'.Filtro', $this->request->getData());
        	return $this->redirect( ['action'=>'index'] );
        }
        if ( $Sessao->check($chave.'.Filtro.Municipios_estado') )
        {
        	$filtros[] = ['Municipios.desc_estd' => $Sessao->read($chave.'.Filtro.Municipios_estado')];
        }


		$this->loadModel('Municipios');
		$listaEstado= $this->Municipios->getListaEstado();

		$ordem 		= $Sessao->check($chave.'.ordem') 	? $Sessao->read($chave.'.ordem') 	: $this->Municipios->displayField();
		$direcao	= $Sessao->check($chave.'.direcao') ? $Sessao->read($chave.'.direcao') 	: 'ASC';
		$pagina		= $Sessao->check($chave.'.pagina') 	? $Sessao->read($chave.'.pagina') 	: 1;

		$pagina 	= isset($this->request->getParam('?')['page'])		? $this->request->getParam('?')['page'] 		: $pagina;
		$ordem 		= isset($this->request->getParam('?')['sort']) 		? $this->request->getParam('?')['sort'] 		: $ordem;
		$direcao 	= isset($this->request->getParam('?')['direction']) ? $this->request->getParam('?')['direction'] 	: $direcao;

		$Sessao->write($chave.'.ordem', $ordem);
		$Sessao->write($chave.'.direcao', $direcao);
		$Sessao->write($chave.'.pagina', $pagina);

		$this->paginate =
		[
			'limit' 	=> 10,
			'page' 		=> $Sessao->read($chave.'.pagina'),
			'sort' 		=> $Sessao->read($chave.'.ordem'),
			'direction' => $Sessao->read($chave.'.direcao'),
			'conditions'=> $filtros
			//'contain' 	=> ['Usuarios']
		];

		$dados = $this->paginate($this->Municipios);

		$this->set( compact('dados', 'listaEstado', 'chave') );
	}
}
