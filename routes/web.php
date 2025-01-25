<?php

use Controllers\AttendeeController;
use Controllers\EventController;
use Controllers\HomeController;
use Middlewares\AuthMiddleware;

$router->get('/', [HomeController::class, 'index'])->name('home');

$router->get('/my-events', [EventController::class, 'index'])->name('myevents')->middleware(AuthMiddleware::class);
$router->get('/event/create', [EventController::class, 'create'])->name('event.create')->middleware(AuthMiddleware::class);
$router->post('/event/store', [EventController::class, 'store'])->name('event.store')->middleware(AuthMiddleware::class);

// $router->get('/attendees', [AttendeeController::class, 'index'])->name('attendees');


require BASE_PATH . "/routes/auth.php";
