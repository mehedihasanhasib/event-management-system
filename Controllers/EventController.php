<?php

namespace Controllers;

use Core\Controller;

class EventController extends Controller
{
    public function index()
    {
        return $this->view('event.index');
    }

    public function create()
    {
        return $this->view('event.create');
    }
}
