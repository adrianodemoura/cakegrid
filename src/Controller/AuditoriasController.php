<?php
/**
 */
namespace App\Controller;
use App\Controller\AppController;
use Exception;
/**
 * Mantém o cadastro de auditorias
 */
class AuditoriasController extends AppController {
	/**
	 * Tela inicial do cadastro de auditorias
	 */
	public function index()
	{
		$this->loadModel('Auditorias');
		$this->loadComponent('Bootstrap.Filtro');

		$params = [];
		$params['contain'] 				= 'Usuarios';
		$params['fields'] 				= ['Auditorias.id', 'Auditorias.motivo', 'Auditorias.ip', 'Auditorias.descricao', 'Auditorias.data', 'Usuarios.nome'];
		$params['Auditorias_descricao'] = ['name'=>'Auditorias.descricao', 'operator'=>'like', 'mask'=>'%u%'];
		$params['Auditorias_ip'] 		= ['name'=>'Auditorias.ip'];

		$this->Filtro->setPaginacao( $params );
	}
}
