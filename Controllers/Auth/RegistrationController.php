<?php

namespace Controllers\Auth;

use Core\Validator;
use Core\Controller;
use Core\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        return $this->view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request->all());
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

        return json_response(['status' => true, 'message' => 'Registration successful'], 201);
    }
}
