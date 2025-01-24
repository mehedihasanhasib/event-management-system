<?php

namespace Middlewares;

class GuestMiddleware
{
    public function handle()
    {
        if (auth()) {
            redirect(route('home'));
        }
    }
}
