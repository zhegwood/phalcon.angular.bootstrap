<?php

use \Phalcon\Config;

return new Config([
    'database' => [
        "host" => "localhost",
        "username" => "webuser",
        "password" => "webuser",
        "dbname" => "bootstrap"
    ],
    'application' => [
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir' => __DIR__ . '/../../app/models/',
        'viewsDir' => __DIR__ . '/../../app/views/',
        'baseUri' => '/',
        'debug' => '1'
    ]
]);
