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
		// carregando
		$this->loadModel('Auditorias');
		$this->loadComponent( 'Bootstrap.Filtro' );

		// configurando os campos de filtro.s
		$this->Filtro->setSchema('Auditorias.descricao', 	['name'=>'Auditorias.descricao', 'operator'=>'like', 'mask'=>'%u%', 'arroz'=>['feijao'=>'batata','a'=>['b'=>'c']]] );
		$this->Filtro->setSchema('Auditorias.ip', 			['name'=>'Auditorias.ip'] );

		// paginando
		$params 			= [];
		$params['contain'] 	= 'Usuarios';
		$params['fields'] 	= ['Auditorias.id', 'Auditorias.motivo', 'Auditorias.ip', 'Auditorias.descricao', 'Auditorias.data', 'Usuarios.nome'];
		$params['sort'] 	= ['Auditorias.id'=>'DESC'];
		$this->Filtro->setPaginacao( $params );
	}
}
