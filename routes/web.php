<?php

use Controllers\HomeController;

$router->get('/', [HomeController::class, 'index'])->name('home');

require BASE_PATH . "/routes/auth.php";