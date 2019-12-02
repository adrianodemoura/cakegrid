<?php
/**
 * Class Municipios
 */
namespace App\Controller;
use App\Controller\AppController;
use Exception;
/**
 * Mantém o cadastro de municipios
 */
class MunicipiosController extends AppController {
	/**
	 * Tela inicial do cadastro de auditorias
	 */
	public function index()
	{
		$this->loadModel('Municipios');

		$listaMunicipios = $this->Municipios->getLista();

		$this->log($listaMunicipios);
	}
}
