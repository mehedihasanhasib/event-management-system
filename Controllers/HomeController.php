<?php

namespace Controllers;

use Core\Controller;
use Core\Database;
use Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $events = Database::query('SELECT title, description, date, banner FROM events ORDER BY date DESC LIMIT 3');
        return $this->view('home.index', ['events' => $events]);
    }
}
