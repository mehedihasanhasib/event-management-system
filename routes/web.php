<?php

use Controllers\HomeController;

$router->get('/', [HomeController::class, 'index'])->name('home');

$router->get('/event-registration', [HomeController::class, 'eventRegistration'])->name('event.registration');

require BASE_PATH . "/routes/auth.php";
