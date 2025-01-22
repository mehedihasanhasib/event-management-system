<?php

use Controllers\HomeController;

$router->get('/', [HomeController::class, 'index']);

require BASE_PATH . "/routes/auth.php";