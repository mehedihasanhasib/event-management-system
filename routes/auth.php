<?php

use App\Core\Route;
use App\Http\Middlewares\AuthMiddleware;
use App\Http\Middlewares\GuestMiddleware;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\RegistrationController;

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware(GuestMiddleware::class);
Route::post('/login/store', [SessionController::class, 'store'])->name('login.store');

Route::get('/register', [RegistrationController::class, 'create'])->name('register')->middleware(GuestMiddleware::class);
Route::post('/register/store', [RegistrationController::class, 'store'])->name('register.store');

Route::post('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware(AuthMiddleware::class);
