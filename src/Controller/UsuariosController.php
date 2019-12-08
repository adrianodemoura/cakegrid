<?php
/**
 * Controller Usuarios
 * 
 * @package     cakeGrid.Controller
 * @author      Adriano Moura
 */
namespace App\Controller;
use App\Controller\AppController;
use Exception;
/**
 * Mantém o cadastro de usuários.
 */
class UsuariosController extends AppController {
    /**
     * Método index
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->loadModel('Usuarios');
        $this->loadComponent('Bootstrap.Filtro');
        
        $listaMunicipios = $this->Usuarios->Municipios->getLista();

        $params                     = ['contain'=>'Municipios'];
        $params['Usuarios_codigo']  = ['name'=>'Usuarios.id'];
        $params['Usuarios_nome']        = ['name'=>'Usuarios.nome', 'operator'=>'LIKE', 'mask'=>'%v%'];
        $params['Usuarios_municipio']   = ['name'=>'Usuarios.municipio_id'];
        $this->Filtro->setPaginacao($params);
        
        $this->set( compact('listaMunicipios') );
    }
}
