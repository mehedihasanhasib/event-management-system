<?php

use Controllers\AttendeeController;
use Controllers\EventController;
use Controllers\HomeController;

$router->get('/', [HomeController::class, 'index'])->name('home');

$router->get('/events', [EventController::class, 'index'])->name('events');
$router->get('/event/create', [EventController::class, 'create'])->name('event.create');

$router->get('/attendees', [AttendeeController::class, 'index'])->name('attendees');


require BASE_PATH . "/routes/auth.php";
