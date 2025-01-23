<?php

use Controllers\Auth\LoginController;
use Controllers\Auth\RegistrationController;

$router->get('/login', [LoginController::class, 'index'])->name('login');
$router->get('/register', [RegistrationController::class, 'index'])->name('register');