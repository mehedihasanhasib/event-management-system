<?php

namespace App\Http\Controllers\Auth;

use App\Core\Auth;
use App\Core\Session;
use App\Core\Controller;
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
            unset($user['password']);
            Auth::login($user);
            return json_response(['status' => true, 'message' => 'Successfully logged in'], 200);
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
