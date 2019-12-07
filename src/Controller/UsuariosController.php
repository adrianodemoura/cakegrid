<?php
namespace App\Controller;

use App\Controller\AppController;
use Exception;

/**
 * Usuarios Controller
 *
 * @method \App\Model\Entity\Usuario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsuariosController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->loadModel('Usuarios');
		$this->loadComponent('Bootstrap.Filtro');

		$params = ['contain'=>'Municipios'];
		$this->Filtro->setPaginacao($params);
    }
}
