<?php

namespace App\Http\Controllers\Auth;

use Core\Auth;
use Core\Session;
use Core\Controller;
use App\Http\Request;

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
            Auth::login([
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'profile_picture' => $user['profile_picture'],
            ]);
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
