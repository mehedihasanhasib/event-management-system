<?php

namespace Controllers;

use Core\Controller;

class AttendeeController extends Controller
{
    public function index()
    {
        return $this->view('attendees.index');
    }
}
