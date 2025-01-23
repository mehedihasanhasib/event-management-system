<?php

namespace Core;

class Router
{
    private $routes = [];
    public $namedRoutes = [];

    public function get($uri, $controller)
    {
        $this->addRoute('GET', $uri, $controller);
        return $this; // Allow method chaining
    }

    public function post($uri, $controller)
    {
        $this->addRoute('POST', $uri, $controller);
        return $this; // Allow method chaining
    }

    public function put($uri, $controller)
    {
        $this->addRoute('PUT', $uri, $controller);
        return $this; // Allow method chaining
    }

    public function delete($uri, $controller)
    {
        $this->addRoute('DELETE', $uri, $controller);
        return $this; // Allow method chaining
    }

    private function addRoute($method, $uri, $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
        ];
    }

    public function name($name)
    {
        $lastRoute = end($this->routes);
        if ($lastRoute) {
            $this->namedRoutes[$name] = [
                'uri' => $lastRoute['uri'],
                'method' => $lastRoute['method'],
                'controller' => $lastRoute['controller'],
            ];
        }

        return $this;
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

    public function url($name, $params = [])
    {
        
        $uri = $this->namedRoutes[$name]['uri'];
        return $uri;
    }
}
