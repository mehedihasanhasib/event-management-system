<?php

use Controllers\Auth\RegistrationController;
use Controllers\Auth\SessionController;
use Middlewares\AuthMiddleware;
use Middlewares\GuestMiddleware;

$router->get('/login', [SessionController::class, 'create'])->name('login')->middleware(GuestMiddleware::class);
$router->post('/login/store', [SessionController::class, 'store'])->name('login.store');

$router->get('/register', [RegistrationController::class, 'create'])->name('register')->middleware(GuestMiddleware::class);
$router->post('/register/store', [RegistrationController::class, 'store'])->name('register.store');

$router->post('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware(AuthMiddleware::class);
