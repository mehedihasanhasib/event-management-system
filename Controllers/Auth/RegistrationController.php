<?php

namespace Controllers\Auth;

use Core\Auth;
use Models\User;
use Core\Validator;
use Core\Controller;
use Core\Http\Request;


class RegistrationController extends Controller
{
    public function create()
    {
        return $this->view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = new Validator();
        $validator->make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'confirm:password'],
        ]);

        if ($validator->fails()) {
            return json_response(['errors' => $validator->errors()], 422);
        }

        try {
            $user = new User();
            $user->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => password_hash($request->input('password'), PASSWORD_BCRYPT)
            ]);
            Auth::login(['name' => $request->input('name'), 'email' => $request->input('email')]);
            return json_response(['status' => true, 'message' => 'Registration successful'], 201);
        } catch (\Throwable $th) {
            return json_response(['status' => false, 'errors' => ['Something went worng! Try again']], 500);
        }
    }
}
