<?php

use App\Core\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middlewares\AuthMiddleware;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\EventUserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/event/attendees/{id}', [AttendeeController::class, 'index'])->name('attendee.index');
// Route::post('/attendee/store', [AttendeeController::class, 'store'])->name('attendee.store');

// Route::get('/events', [EventUserController::class, 'index'])->name('events');
// Route::get('/event/{slug}', [EventUserController::class, 'show'])->name('event.show');

// Route::get('/event/create', [EventController::class, 'create'])->name('event.create')->middleware(AuthMiddleware::class);
// Route::post('/event/store', [EventController::class, 'store'])->name('event.store')->middleware(AuthMiddleware::class);
// Route::get('/event/edit/{id}', [EventController::class, 'edit'])->name('event.edit')->middleware(AuthMiddleware::class);
// Route::put('/event/update', [EventController::class, 'update'])->name('event.update')->middleware(AuthMiddleware::class);
// Route::get('/my-events', [EventController::class, 'index'])->name('myevents')->middleware(AuthMiddleware::class);

// ===============
Route::get('/events', [EventUserController::class, 'index'])->name('events'); // Public event list
Route::get('/event/{slug}', [EventUserController::class, 'show'])->name('event.show'); // Public event details

// Creator's Event Management Routes
Route::get('/dashboard/events', [EventController::class, 'index'])->name('creator.events')->middleware(AuthMiddleware::class); // Event list for the creator
Route::get('/dashboard/event/create', [EventController::class, 'create'])->name('event.create')->middleware(AuthMiddleware::class); // Create new event
Route::post('/dashboard/event/store', [EventController::class, 'store'])->name('event.store')->middleware(AuthMiddleware::class); // Store new event
Route::get('/dashboard/event/edit/{id}', [EventController::class, 'edit'])->name('event.edit')->middleware(AuthMiddleware::class); // Edit a specific event
Route::put('/dashboard/event/update', [EventController::class, 'update'])->name('event.update')->middleware(AuthMiddleware::class); // Update an event
Route::delete('/event/delete/{id}', [EventController::class, 'destroy'])->name('event.delete')->middleware(AuthMiddleware::class); // Delete an event

// Attendee Routes
Route::get('/event/{id}/attendees', [AttendeeController::class, 'index'])->name('attendee.index'); // Attendees list for a specific event
Route::post('/event/attendee/store', [AttendeeController::class, 'store'])->name('attendee.store'); // Register new attendee for a specific event

// dd(Route::$routes);
require BASE_PATH . "/routes/auth.php";
