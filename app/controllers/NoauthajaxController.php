<?php

class NoauthajaxController extends ControllerBase {
        
    public function authuserAction() {
        $response = $this->getResponse(true);

        $response['data']['user'] = $this->session->get('auth');

        $this->respond($response);
    }
    
    public function createaccountAction() {
        $response = $this->getResponse();
        $request = $this->getRequest();
        
        $user = new User();
        
        if ($user->saveUser($request)) {
            $response['success'] = true;
            $response['data']['user'] = $user;
        } else {
            $response['error'] = implode("<br/>",$user->getMessages());
        }
        
        $this->respond($response);
    }
    
    public function loginAction() {
        $response = $this->getResponse();
        $request = $this->getRequest();

        $user = User::findFirstByEmail($request->email);

        if (empty($user)) {
            $response['error'] = "Invalid username or password.";
        } else if ($user->login($request)) {
            $response['success'] = true;
            $response['data']['user'] = $this->session->get('auth');
        } else {
            $response['error'] = $this->errors($user->getMessages());
        }
        
        $this->respond($response);
    }
    
    public function validemailAction() {
        $response = $this->getResponse();
        $request = $this->getRequest();
        
        $user = new User();
        
        if ($user->emailExists($request)) {
            $response['success'] = true;
        } else {
            $response['error'] = "Email address is taken.";
        }
        
        echo json_encode($response);
        die();
    }
}