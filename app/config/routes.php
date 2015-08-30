<?php

use Phalcon\Mvc\Router;

$router = new Router(false);

$router->setDI($di);

/*AJAX Routes*/
$router->addGet("/ajax/user",[
    'controller' => 'noauthajax',
    'action' => 'authuser'
]);

$router->addPost("/ajax/login",[
    'controller' => 'noauthajax',
    'action' => 'login'
]);

$router->addPost("/ajax/valid-email",[
    'controller' => 'noauthajax',
    'action' => 'validemail'
]);

$router->addPost("/ajax/create-account",[
    'controller' => 'noauthajax',
    'action' => 'createaccount'
]);


/*Page routes*/
$router->addGet("/login",[
    'controller' => 'noauth',
    'action' => 'login'
]);

$router->addGet("/logout",[
    'controller' => 'auth',
    'action' => 'logout'
]);

$router->addGet("/create-account",[
    'controller' => 'noauth',
    'action' => 'createaccount'
]);

$router->addGet("/activate-success",[
    'controller' => 'noauth',
    'action' => 'activatesuccess'
]);

$router->addGet("/activate-failure",[
    'controller' => 'noauth',
    'action' => 'activatefailure'
]);

$router->add("/activate/{hash}",[
    'controller' => 'noauth',
    'action' => 'activate'
]);

$router->addGet("/login",[
    'controller' => 'noauth',
    'action' => 'login'
]);

$router->addGet("/secure",[
    'controller' => 'auth',
    'action' => 'secure'
]);

$router->addGet("/admin",[
    'controller' => 'auth',
    'action' => 'admin'
]);

$router->setDefaults([
    'controller' => 'noauth',
    'action'     => 'index'
]);

$router->handle();