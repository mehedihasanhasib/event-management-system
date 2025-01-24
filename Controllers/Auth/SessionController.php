<?php

namespace Controllers\Auth;

use Core\Auth;
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
        if ($user = Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            if (!password_verify($request->input('password'), $user['password'])) {
                return json_response(['errors' => 'Credentials doesn\'t match'], 401);
            }
            Auth::login(['name' => $user['name'], 'email' => $user['email']]);
            return json_response(['status' => true, 'message' => 'Login Successfull']);
        }

        return json_response(['errors' => 'Credentials doesn\'t match'], 401);
    }

    public function destroy()
    {
        session_destroy();
        Session::flush();

        return redirect(route('home'));
    }
}
