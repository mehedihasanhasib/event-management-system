<?php

use App\Core\Route;
use App\Http\Controllers\Api\EventController;

Route::get('/api/events', [EventController::class, 'index']);
