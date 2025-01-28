<?php

use App\Core\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middlewares\AuthMiddleware;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\EventUserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/events', [EventUserController::class, 'index'])->name('events');
Route::get('/event/{slug}', [EventUserController::class, 'show'])->name('event.show');

Route::get('/event/attendees/{id}', [AttendeeController::class, 'index'])->name('attendee.index');
Route::post('/attendee/store', [AttendeeController::class, 'store'])->name('attendee.store');

Route::get('/my-events', [EventController::class, 'index'])->name('myevents')->middleware(AuthMiddleware::class);
Route::get('/event/create', [EventController::class, 'create'])->name('event.create')->middleware(AuthMiddleware::class);
Route::post('/event/store', [EventController::class, 'store'])->name('event.store')->middleware(AuthMiddleware::class);
Route::get('/event/edit/{id}', [EventController::class, 'edit'])->name('event.edit')->middleware(AuthMiddleware::class);
Route::put('/event/update', [EventController::class, 'update'])->name('event.update')->middleware(AuthMiddleware::class);


require BASE_PATH . "/routes/auth.php";
