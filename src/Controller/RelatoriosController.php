<?php
/**
 * Relatorios Controller
 *
 * @package 	cakeGrid.Controoler
 * @author 		Adriano Moura
 */
namespace App\Controller;
use App\Controller\AppController;
/**
 * Mantém os relatórios do sistema.
 */
class RelatoriosController extends AppController {
	/**
	 * Exibe a tela principal de Relatórios
	 *
	 * @return 	\Cake\Http\Response|null
	 */
	public function index()
	{
		//
	}

	/**
	 * Exibe o relatório, paginado, de usuários.
	 *
	 * @return 	\Cake\Http\Response|null
	 */
	public function usuarios()
	{
		$this->loadModel('Usuarios');

		$this->paginate =
		[
			'limite' 	=> 10,
			'contain' 	=> ['Municipios']
		];

		$this->request->data = $this->paginate($this->Usuarios);
	}
}