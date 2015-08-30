<?php
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Security;

$di = new FactoryDefault();

$di->set('config', $config);

$di->set('url', function() use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
}, true);

$di->set('security', function(){
    $security = new Security();
    //Set the password hashing factor to 12 rounds
    $security->setWorkFactor(12);
    return $security;
}, true);

$di->set('view', function() use ($config){
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

$di->set('db', function() use ($config){
    return new DbAdapter([
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->dbname
    ]);
});

$di->set('router',function () use ($di) {
    require __DIR__.'/routes.php';
    return $router;
});

$di->set('session', function() {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});