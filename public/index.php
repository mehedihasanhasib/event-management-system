<?php
session_start();
use Core\Session;

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . "/Helpers/functions.php";

// dd($_SERVER['HTTP']);

spl_autoload_register(function ($class) {
    $class  = str_replace("\\", DIRECTORY_SEPARATOR, $class) . '.php';
    require BASE_PATH . DIRECTORY_SEPARATOR . "$class";
});

require_once BASE_PATH . "/Core/Router.php";

// dd(auth());

$router = new \Core\Router();

require_once BASE_PATH . "/routes/web.php";


$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

$method = $_POST['_method'] ?? $_SERVER["REQUEST_METHOD"];

$router->route($uri, $method);

Session::unflash();
