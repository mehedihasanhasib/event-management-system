<?php
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . "/Core/functions.php";


spl_autoload_register(function ($class) {
    $class  = str_replace("\\", DIRECTORY_SEPARATOR, $class) . '.php';
    require BASE_PATH . DIRECTORY_SEPARATOR . "$class";
});

require_once BASE_PATH . "/Core/Router.php";


$router = new \Core\Router();

require_once BASE_PATH . "/routes/web.php";


$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

$method = $_POST['_method'] ?? $_SERVER["REQUEST_METHOD"];

$router->route($uri, $method);
