<?php

namespace Core;

use Core\Http\Request;

class Router
{
    private $routes = [];
    public $namedRoutes = [];

    public function get($uri, $controller)
    {
        return $this->addRoute('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->addRoute('POST', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->addRoute('PUT', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->addRoute('DELETE', $uri, $controller);
    }

    private function addRoute($method, $uri, $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'middleware' => null
        ];
        return $this;
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

    public function middleware($key)
    {
        return $this->routes[array_key_last($this->routes)]['middleware'] = $key;
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] == $uri) {
                if ($method != $route['method']) {
                    http_response_code(405);
                    die("$method method is not supported on this route\n");
                }
                if ($route['middleware'] != null) {
                    (new $route['middleware'])->handle();
                }

                $controller = new $route['controller'][0]();
                $method = $route['controller'][1];
                $request = new Request();
                $controller->$method($request);
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
