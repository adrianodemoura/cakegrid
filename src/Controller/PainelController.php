<?php
namespace App\Controller;

use App\Controller\AppController;
use Exception;

/**
 * Painel Controller
 *
 *
 * @method \App\Model\Entity\Painel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PainelController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
    	// variáveis locais
        $tituloPagina   = SISTEMA.' - Página Inicial';

        $this->set( compact( 'tituloPagina' ) );
    }
}
