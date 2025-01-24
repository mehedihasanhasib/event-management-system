<?php

use Controllers\Auth\LoginController;
use Controllers\Auth\RegistrationController;
use Middlewares\GuestMiddleware;

$router->get('/login', [LoginController::class, 'create'])->name('login')->middleware(GuestMiddleware::class);
$router->get('/register', [RegistrationController::class, 'create'])->name('register')->middleware(GuestMiddleware::class);
$router->post('/register/store', [RegistrationController::class, 'store'])->name('register.store');
