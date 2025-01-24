<?php

use Controllers\AttendeeController;
use Controllers\EventController;
use Controllers\HomeController;
use Middlewares\AuthMiddleware;

$router->get('/', [HomeController::class, 'index'])->name('home');

$router->get('/my-events', [EventController::class, 'index'])->name('myevents')->middleware(AuthMiddleware::class);
// $router->get('/event/create', [EventController::class, 'create'])->name('event.create');

// $router->get('/attendees', [AttendeeController::class, 'index'])->name('attendees');


require BASE_PATH . "/routes/auth.php";
