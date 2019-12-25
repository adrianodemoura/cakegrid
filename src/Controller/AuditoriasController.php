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
		$this->loadModel( 'Auditorias' );
		$this->loadComponent( 'Bootstrap.Filtro' );

		// configurando os campos de filtros.
		$this->Filtro->setSchema('Auditorias.id', 			['title'=>'Código', 'order'=>true, 'filter'=>true, 'table'=>true] );
		$this->Filtro->setSchema('Auditorias.descricao', 	['title'=>'Descrição', 'table'=>true, 'operator'=>'like', 'mask'=>'%u%', 'arroz'=>['feijao'=>'batata','a'=>['b'=>'c']]] );
		$this->Filtro->setSchema('Auditorias.motivo', 		['title'=>'Motivo', 'table'=>true] );
		$this->Filtro->setSchema('Auditorias.ip', 			['title'=>'Ip', 'table'=>true, 'order'=>true] );
		$this->Filtro->setSchema('Usuarios.nome', 			['title'=>'Usuário', 'table'=>true] );

		// paginando
		$params 				= [];
		$params['contain'] 		= 'Usuarios';
		$params['conditions'] 	= ['Auditorias.motivo'=>'cache'];
		$params['fields'] 		= ['Auditorias.id', 'Auditorias.motivo', 'Auditorias.ip', 'Auditorias.descricao', 'Auditorias.data', 'Usuarios.nome'];
		$params['order'] 		= ['Auditorias.id'=>'DESC'];
		$this->Filtro->setPaginacao( $params );
	}
}
