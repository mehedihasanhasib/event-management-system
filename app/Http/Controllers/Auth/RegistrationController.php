<?php

namespace App\Http\Controllers\Auth;

use App\Core\Auth;
use App\Helpers\File;
use App\Core\Validator;
use App\Models\User;
use App\Core\Controller;
use App\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        return $this->view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'confirm:password'],
            'profile_picture' => ['image', 'size:2048', 'mimes:jpg,png,jpeg,webp']
        ]);

        if ($validator->fails()) {
            return json_response(['errors' => $validator->errors()], 422);
        }

        try {
            $user = new User();
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $path = "uploads/";
                $image = File::upload($file, $path);
            }
            $new_user = $user->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'profile_picture' => $image ?? null,
                'password' => password_hash($request->input('password'), PASSWORD_BCRYPT)
            ]);
            unset($new_user['password']);

            Auth::login($user);
            Auth::login($new_user);
            return json_response(['status' => true, 'message' => 'Registration successful'], 201);
        } catch (\Throwable $th) {
            return json_response(['status' => false, 'errors' => ['Something went worng! Try again']], 500);
        }
    }
}
