<?php

use Phalcon\Mvc\Model;

class Role extends Model {
    public $id;
    public $name;
    
    public function initialize() {
        $this->setSource("roles");
    }
}