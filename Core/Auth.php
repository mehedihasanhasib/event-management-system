<?php

namespace Core;

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
}
