<?php

use Controllers\Auth\LoginController;
use Controllers\Auth\RegistrationController;

$router->get('/login', [LoginController::class, 'create'])->name('login');

$router->get('/register', [RegistrationController::class, 'create'])->name('register');
$router->post('/register/store', [RegistrationController::class, 'store'])->name('register.store');