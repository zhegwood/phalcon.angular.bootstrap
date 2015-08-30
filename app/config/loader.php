<?php

use \Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs([
    $config->application->controllersDir,
    $config->application->modelsDir
])->register();