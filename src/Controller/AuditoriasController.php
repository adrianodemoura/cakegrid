<?php
/**
 */
namespace App\Controller;
use App\Controller\AppController;
//use Exception;
/**
 * Mantém o cadastro de auditorias
 */
class AuditoriasController extends AppController {
	/**
	 * Tela inicial do cadastro de auditorias
	 */
	public function index()
	{
		// carregando o model
		$this->loadModel( 'Auditorias' );

		// carregando o componente filtro
		$arrSchema = 
		[
			'Auditorias.id' 		=> ['table'=>true, 'title'=>'Código', 		'filter'=>true, 'order'=>true],
			'Auditorias.ip' 		=> ['table'=>true, 'title'=>'Ip', 			'filter'=>true],
			'Auditorias.motivo' 	=> ['table'=>true, 'title'=>'Motivo', 		'filter'=>true, 'order'=>true],
			'Auditorias.descricao' 	=> ['table'=>true, 'title'=>'Descrição', 	'operator'=>'like', 'mask'=>'%u%'],
			'Usuario.nome' 			=> ['table'=>true, 'title'=>'Usuário']
		];
		$this->loadComponent( 'Bootstrap.Filtro', ['schema'=>$arrSchema] );

		// paginando
		$params 				= [];
		$params['contain'] 		= 'Usuarios';
		//$params['conditions'] 	= ['Auditorias.motivo'=>'cache'];
		$params['fields'] 		= ['Auditorias.id', 'Auditorias.motivo', 'Auditorias.ip', 'Auditorias.descricao', 'Auditorias.data', 'Usuarios.nome'];
		$params['order'] 		= ['Auditorias.id'=>'DESC'];
		$this->Filtro->setPaginacao( $params );
	}
}
