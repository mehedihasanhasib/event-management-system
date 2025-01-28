<?php
session_start();
use Core\Session;

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . "/Helpers/functions.php";

require_once BASE_PATH . "/public/autoload.php";

require_once BASE_PATH . "/bootstrap/app.php";