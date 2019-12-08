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
		$this->loadModel('Municipios');
		$listaEstado= $this->Municipios->getListaEstado();
		$this->set( compact('listaEstado') );

		$this->loadComponent('Bootstrap.Filtro');

		$params = [];
		$params['contain'] 			= ['Usuarios'];
		$params['Municipios_estado']= ['name'=>'Municipios.desc_estd'];
		$params['Municipios_nome'] 	= ['name'=>'Municipios.nome', 'operator'=>'like', 'mask'=>'%u%'];
		$this->Filtro->setPaginacao($params);
	}
}
