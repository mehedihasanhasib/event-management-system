<?php

namespace Controllers;

use Core\Controller;

class EventController extends Controller
{
    public function index()
    {
        return $this->view('events.index');
    }

    public function create()
    {
        return $this->view('event.create');
    }
}
