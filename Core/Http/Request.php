<?php

namespace Core\Http;

class Request
{
    protected $data;
    protected $files;

    public function __construct($data = null)
    {
        $this->data = $data ?? $_POST;
        // $this->files = $_FILES;
        foreach ($_FILES as $key => $file) {
            if ($file['size']) {
                $this->files[$key] = $file;
            }
        }
    }

    public function input($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function file($key, $default = null)
    {
        return $this->files[$key] ?? $default;
    }

    public function hasFile($key)
    {
        return isset($this->files[$key]);
    }

    public function query($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    // private function parseJson()
    // {
    //     if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    //         return json_decode(file_get_contents('php://input'), true) ?? [];
    //     }
    //     return [];
    // }

    public function all()
    {
        if (!empty($this->files)) {
            return array_merge($this->data, $this->files);
        } else {
            return $this->data;
        }
    }
}
