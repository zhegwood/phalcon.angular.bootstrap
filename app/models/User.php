<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class User extends Model {
    public $id;
    public $email;
    protected $password;
    public $role_id;
    public $active;
    protected $active_hash;
    public $created;
    public $updated;
    public $deleted;
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setPassword($pwd) {
        $this->password = $pwd;
    }
    
    public function getActiveHash() {
        return $this->active_hash;
    }
    
    public function setActiveHash($hash) {
        $this->active_hash = $hash;
    }
    
    public function getCreated() {
        return strtotime($this->created)*1000;
    }
    
    public function setCreated() {
        $this->created = date('Y-m-d\TH:i:s\Z');
    }
    
    public function getUpdated() {
        return strtotime($this->updated)*1000;
    }
    
    public function getDeleted() {
        return strtotime($this->deleted)*1000;
    }
    
    public function setDeleted() {
        $this->deleted = date('Y-m-d\TH:i:s\Z');
    }
    
    public function initialize() {
        $this->setSource("users");

        $this->skipAttributesOnCreate([
            'active',
            'role_id'
        ]);

        $this->addBehavior(new SoftDelete([
            'field' => 'deleted',
            'value' => date('Y-m-d\TH:i:s\Z')
        ]));

        $this->hasOne('role_id','Role','id');
    }
    
    public function validation() {
        $this->validate(new PresenceOf(
            array(
                "field"   => "email",
                "message" => "Email address is required."
            )
        ));

        $this->validate(new PresenceOf(
            array(
                "field"   => "password",
                "message" => "Password is required."
            )
        ));

        $this->validate(new Email(
            array(
                "field"   => "email",
                "message" => "Email address is invalid."
            )
        ));

        $this->validate(new Uniqueness(
            array(
                "field"   => "email",
                "message" => "Email address is taken."
            )
        ));

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
    
    public function beforeValidationOnCreate() {
        $this->created = date('Y-m-d\TH:i:s\Z');
        $this->updated = date('Y-m-d\TH:i:s\Z');
    }
    
    public function afterCreate() {
        $this->sendActivationEmail();
    }

    public function beforeValidationOnUpdate() {
        $this->updated = date('Y-m-d\TH:i:s\Z');
    }
    
    public function activateAccount() {

        if ($this->active == "Y") {
            $this->appendMessage(new Message("user-active"));
            return false;
        }
        $limit = time() - (60*60*24);
        $created = strtotime($this->created);
        if ($created > $limit) {
            $this->active = "Y";
            if ($this->save()) {
                return true;
            } else {
                $this->appendMessage(new Message("activate-failure"));
                return false;
            }
        } else {
            $this->appendMessage(new Message("activate-failure"));
            return false;
        }
    }
    
    public function emailExists($request) {
        $email = $request->email;

        $exists = count($this->find("email='$email'")) > 0;
        $user = $this->getDi()->getShared('session')->get('auth');
        
        if (!empty($user) && $user->email == $email) {
            return true;
        } else if (!$exists) {
            return true;
        }
        
        return false;
    }
    
    public function login($request) {
        if ($this->active != "Y") {
            $this->appendMessage(new Message("Account has not been activated."));
            return false;
        }
        if ($this->getDi()->getShared('security')->checkHash($request->password, $this->password)) {
            $this->getDi()->getShared('session')->set('auth', $this);
            return true;
        } else {
            $this->appendMessage(new Message("Invalid username or password."));
            return false;
        }
    }
    
    public function saveUser($request) {
        $this->email = $request->email;
        $this->password = $this->getDi()->getShared('security')->hash($request->password);
        $this->active_hash = uniqid();

        return $this->save();
    }
    
    public function sendActivationEmail() {
        $sendgrid = new SendGrid('[username]', '[password]');
        $email = new SendGrid\Email();

        $email->addTo($this->email)
            ->setFrom("noreply@zachhegwood.com")
            ->setSubject("Activate your account!")
            ->setHtml("
                <p>Click on the link below to activate your account!</p>
                <a href='http://104.131.144.103:8080/activate/".$this->active_hash."'>Heck Yeah!</a>
            ");
        $sendgrid->send($email);
    }

}