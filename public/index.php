<?php
session_start();
use Core\Session;

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . "/Helpers/functions.php";

spl_autoload_register(function ($class) {
    $class  = str_replace("\\", DIRECTORY_SEPARATOR, $class) . '.php';
    require BASE_PATH . DIRECTORY_SEPARATOR . "$class";
});

require_once BASE_PATH . "/bootstrap/app.php";