<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    /**
     * Métdo de inicialização.
     *
     * @return void
     */
    public function initialize()
    {
        $pca = strtolower( $this->request->getParam('controller').'-'.$this->request->getParam('action') );
        if ( !empty($this->request->getParam('plugin')) ) { $pca = strtolower($this->request->getParam('plugin')).'-'.$pca; }
        $Sessao = $this->request->getSession();

        parent::initialize();

        $this->loadComponent('RequestHandler', ['enableBeforeRedirect' => false]);
        
        $this->loadComponent('Flash');

        $paramsAuth = [];
        $paramsAuth['authenticate']         = ['Form'=>['fields'=>['username'=>'email', 'password'=>'senha'], 'userModel'=>'Usuarios']];
        $paramsAuth['authError']            = __('Usuário inválido !');
        $paramsAuth['loginAction']          = ['controller'=>'Painel', 'action'=>'login'];
        $paramsAuth['unauthorizedRedirect'] = $this->referer();

        $this->loadComponent('Auth', $paramsAuth);

        // definindo o tema padrão
        $this->viewBuilder()->setTheme('Bootstrap');

        // definindo o layout padrão
        if ( $Sessao->check('Auth.User') )
        {
            $this->viewBuilder()->setLayout('admin');
        } else
        {
            $this->viewBuilder()->setLayout('publico');
        }

    }

    /**
     * Verifica a autenticação
     *
     * @return  void 
     */
    public function isAuthorized($user)
    {
        $pca = strtolower( $this->request->getParam('controller').'-'.$this->request->getParam('action') );
        if ( !empty($this->request->getParam('plugin')) ) { $pca = strtolower($this->request->getParam('plugin')).'-'.$pca; }

        $this->log($pca, 'debug');

        return false;
    }
}
