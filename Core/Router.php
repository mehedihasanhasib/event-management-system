<?php

namespace Core;

class Router
{
    private $routes = [];

    public function get($uir, $controller)
    {
        $this->routes[] = [
            'method' => 'GET',
            'uri' => $uir,
            'controller' => $controller
        ];
    }

    public function post($uir, $controller)
    {
        $this->routes[] = [
            'method' => 'POST',
            'uri' => $uir,
            'controller' => $controller
        ];
    }

    public function put($uri, $controller)
    {
        $this->routes[] = [
            'method' => 'PUT',
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    public function delete($uri, $controller)
    {
        $this->routes[] = [
            'method' => 'DELETE',
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] == $uri) {
                if ($method != $route['method']) {
                    http_response_code(405);
                    die("$method method is not supported on this route\n");
                }
                $controller = new $route['controller'][0]();
                $method = $route['controller'][1];
                $controller->$method();
                return;
            }
        }
        http_response_code(404);
        require_once '../views/404.php';
    }
}
