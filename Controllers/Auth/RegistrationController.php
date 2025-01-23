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
        $validator = new Validator();
        $validator->make($request->all(), [
            'name' => ['required', 'string', 'max:5'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'max:1'],
        ]);

        if ($validator->fails()) {
            json_response($validator->errors(), 422);
        }
    }
}
