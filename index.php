<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

set_include_path(realpath(__DIR__ . DS . 'library') . PS .    
     get_include_path());

require 'Doctrine/Common/ClassLoader.php';
$classLoader = new \Doctrine\Common\ClassLoader();
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Application\Entities',
    __DIR__ . DS . 'Application' . DS . 'Entities');
$classLoader->register();

require 'bootstrap.php';

use Application\Controllers\FrontController as FrontController;

FrontController::dispatch($_GET);

