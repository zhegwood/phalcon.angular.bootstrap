<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;

class AuthajaxController extends ControllerBase {

    private $adminActions = [

    ];

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
}