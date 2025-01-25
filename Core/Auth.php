<?php

namespace Core;

use Models\User;

class Auth
{
    public static function login($data)
    {
        session_regenerate_id(true);
        Session::put('auth', true);
        Session::put('user', $data);
    }

    public static function user()
    {
        return Session::get('user') ?? null;

    }

    public static function attempt($credentials = [])
    {
        $user = new User();
        return $user->where('email', $credentials['email']);
    }
}
