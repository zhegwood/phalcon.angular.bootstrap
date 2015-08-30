<?php

use Phalcon\Http\Response;

class NoauthController extends ControllerBase {

    public function initialize() {
        $this->view->setTemplateAfter('layout');
    }

    public function indexAction() {
        $this->view->pick("home");
    }

    public function loginAction() {
        $this->view->pick("login");
    }
    
    public function createaccountAction() {
        $this->view->pick("create-account");
    }
    
    public function activateAction() {
        $response = new Response();

        $user = User::findFirstByActiveHash($this->dispatcher->getParam("hash"));
        
        if (empty($user)) {
            $response->redirect("/activate-failure",false);
            $response->send();
        } else if ($user->activateAccount()) {
            $response->redirect("/activate-success",false);
            $response->send();
        } else {
            $messages = $user->getMessages();
            foreach($messages as $message) {
                switch($message) {
                    case "activate-failure":
                        $response->redirect("/activate-failure",false);
                        $response->send();
                        break;
                    case "user-active":
                        $response->redirect("http://104.131.144.103:8080/login",false);
                        $response->send();
                        break;
                }
            }
        }
    }
    
    public function activatesuccessAction() {
        $this->view->pick("activate-success");
    }
    
    public function activatefailureAction() {
        $this->view->pick("activate-failure");
    }
}