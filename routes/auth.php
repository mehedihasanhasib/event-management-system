<?php

use Controllers\Auth\LoginController;

$router->get('/login', [LoginController::class, 'index']);