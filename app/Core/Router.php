<?php

namespace App\Core;

use App\Http\Request;


class Route
{
    protected static $routes = [];
    protected static $namedRoutes = [];

    public static function get($uri, $controller)
    {
        return self::addRoute('GET', $uri, $controller);
    }

    public static function post($uri, $controller)
    {
        return self::addRoute('POST', $uri, $controller);
    }

    public static function put($uri, $controller)
    {
        return self::addRoute('PUT', $uri, $controller);
    }

    public static function delete($uri, $controller)
    {
        return self::addRoute('DELETE', $uri, $controller);
    }

    private static function addRoute($method, $uri, $controller)
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'middleware' => null
        ];
        return new self();
    }

    public function name($name)
    {
        $lastRoute = end(self::$routes);
        if ($lastRoute) {
            self::$namedRoutes[$name] = [
                'uri' => $lastRoute['uri'],
                'method' => $lastRoute['method'],
                'controller' => $lastRoute['controller'],
            ];
        }

        return $this;
    }

    public function middleware($key)
    {
        return self::$routes[array_key_last(self::$routes)]['middleware'] = $key;
    }

    public static function route($uri, $method)
    {
        foreach (self::$routes as $route) {
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

    public static function url($name, $params = [])
    {
        $uri = self::$namedRoutes[$name]['uri'];
        return $uri;
    }
}
