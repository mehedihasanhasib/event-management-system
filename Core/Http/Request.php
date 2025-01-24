<?php

namespace Core\Http;

class Request
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data ?? $_POST;
    }

    public function input($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function all()
    {
        return $this->data;
    }
}
