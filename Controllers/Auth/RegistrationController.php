<?php

namespace Controllers\Auth;

use Core\Controller;

class RegistrationController extends Controller
{
    public function index()
    {
        $this->view('auth.register');
    }
}
