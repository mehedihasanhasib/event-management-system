<?php

namespace Controllers;

use Core\Controller;
use Core\Database;
use Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // $event = new Event();
        $events = Database::query('SELECT title, description, date, banner FROM events ORDER BY date ASC');
        return $this->view('home.index', ['events' => $events]);
    }
}
