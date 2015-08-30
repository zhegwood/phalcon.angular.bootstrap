<?php

use Phalcon\Mvc\Application;

try {
    
    $config = include __DIR__."/../app/config/config.php";
    
    include __DIR__."/../app/config/loader.php";
    include __DIR__."/../app/config/services.php";
    include __DIR__."/../vendor/autoload.php";
    
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch(\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}