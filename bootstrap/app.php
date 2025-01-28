<?php

define("DEFAULT_USER_AVATAR", "images/user-avatar/default-avatar.png");
define("DEFAULT_EVENT_BANNER", "images/image-placeholder.jpg");
define("DEFAULT_BANNER_UPLOAD_PATH", "uploads/banners/");

require_once BASE_PATH . "/app/Core/Router.php";

$router = new \App\Core\Router();

require_once BASE_PATH . "/routes/web.php";

$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

$method = $_POST['_method'] ?? $_SERVER["REQUEST_METHOD"];

$router->route($uri, $method);

\App\Core\Session::unflash();
