<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;

class AuthController extends ControllerBase {
    
    private $adminActions = [
        "admin"
    ];
    
    public function initialize() {
        $this->view->setTemplateAfter('layout');
    }
    
    public function beforeExecuteRoute(Dispatcher $dispatcher) {
        $user = $this->session->get('auth');
        $action = $dispatcher->getActionName();
        $response = new Response();
        if (empty($user)) {
            $response->redirect("/login",false);
            $response->send();
        }
        if ($user->role_id != 2 && in_array($action,$this->adminActions)) {
            $response->redirect("/",false);
            $response->send();
        }
    }
    
    public function adminAction() {
        $this->view->pick('admin/index');
    }
    
    public function logoutAction() {
        $response = new Response();
        $this->session->destroy();
        $response->redirect("/",false);
        $response->send();
    }
    
    public function secureAction() {
        $this->view->pick('secure');
    }

}