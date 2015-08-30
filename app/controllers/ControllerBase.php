<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;

class ControllerBase extends Controller {
    
    public function beforeExecuteRoute(Dispatcher $dispatcher) {
        $user = $this->session->get('auth');
        $controller = $dispatcher->getControllerName();
        if (empty($user) && ($controller == "auth" || $controller == "authajax")) {
            $response = new Response();
            $response->redirect("/login",false);
            $response->send();
        }
    }
    
    public function errors($messages) {
        $arr = [];
        foreach ($messages as $message) {
            $arr[] = $message->getMessage();
        }
        return implode("<br/>",$arr);
    }
    
    public function getResponse($success = false) {
        return [
            "success"=>$success,
            "error"=>"",
            "data"=>[]
        ];
    }
    
    public function getRequest() {
        return json_decode(file_get_contents("php://input"));
    }
    
    public function respond($response) {
        echo json_encode($response);
        die();
    }

}