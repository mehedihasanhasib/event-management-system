<?php

use Controllers\HomeController;
use Middlewares\AuthMiddleware;
use Controllers\EventController;
use Controllers\EventUserController;

$router->get('/', [HomeController::class, 'index'])->name('home');
$router->get('/events', [EventUserController::class, 'index'])->name('events');
$router->get('/event', [EventUserController::class, 'show'])->name('event.show');

$router->get('/my-events', [EventController::class, 'index'])->name('myevents')->middleware(AuthMiddleware::class);
$router->get('/event/create', [EventController::class, 'create'])->name('event.create')->middleware(AuthMiddleware::class);
$router->post('/event/store', [EventController::class, 'store'])->name('event.store')->middleware(AuthMiddleware::class);
$router->get('/event/edit', [EventController::class, 'edit'])->name('event.edit')->middleware(AuthMiddleware::class);
$router->put('/event/update', [EventController::class, 'update'])->name('event.update')->middleware(AuthMiddleware::class);

// $router->get('/attendees', [AttendeeController::class, 'index'])->name('attendees');


require BASE_PATH . "/routes/auth.php";
