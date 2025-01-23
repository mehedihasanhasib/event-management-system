<?php

namespace Controllers\Auth;

use Core\Controller;

class LoginController extends Controller
{
    public function create()
    {
        return $this->view('auth.login');
    }

    public function store()
    {
        
    }
}
