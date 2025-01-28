<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Database;

class HomeController extends Controller
{
    public function index()
    {
        $events = Database::query('SELECT title, slug, description, date, banner FROM events ORDER BY id DESC LIMIT 3');
        return $this->view('home.index', ['events' => $events]);
    }
}
