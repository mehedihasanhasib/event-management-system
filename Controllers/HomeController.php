<?php

namespace Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home.index');
    }

    public function eventRegistration()
    {
        return $this->view('eventRegistration');
    }
}
