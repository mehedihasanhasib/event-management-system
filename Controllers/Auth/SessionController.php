<?php

namespace Controllers\Auth;

use Core\Controller;
use Core\Http\Request;
use Core\Session;

class SessionController extends Controller
{
    public function create()
    {
        return $this->view('auth.login');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function destroy()
    {
        session_destroy();
        Session::flush();

        return redirect(route('home'));
    }
}
