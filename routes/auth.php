<?php

use App\Http\Middlewares\AuthMiddleware;
use App\Http\Middlewares\GuestMiddleware;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\RegistrationController;

$router->get('/login', [SessionController::class, 'create'])->name('login')->middleware(GuestMiddleware::class);
$router->post('/login/store', [SessionController::class, 'store'])->name('login.store');

$router->get('/register', [RegistrationController::class, 'create'])->name('register')->middleware(GuestMiddleware::class);
$router->post('/register/store', [RegistrationController::class, 'store'])->name('register.store');

$router->post('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware(AuthMiddleware::class);
