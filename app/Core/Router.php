<?php

namespace App\Core;

use App\Http\Middlewares\VerifyCsrf;
use App\Http\Request;


class Route
{
    public static $routes = [];
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
            $routePattern = preg_replace('/\{([a-zA-Z0-9_-]+)\}/', '([a-zA-Z0-9_-]+)', $route['uri']);
            $routePattern = "#^" . $routePattern . "$#";

            if ($route['uri'] == $uri || preg_match($routePattern, $uri, $matches)) {
                // check method
                if ($method != $route['method']) {
                    http_response_code(405);
                    die("$method method is not supported on this route\n");
                }

                // varify csrf token
                if ($method != "GET") {
                    (new VerifyCsrf)->handle();
                }

                // apply middleware
                if ($route['middleware'] != null) {
                    (new $route['middleware'])->handle();
                }

                $controller = new $route['controller'][0]();
                $method = $route['controller'][1];
                $request = new Request();

                if (isset($matches) && $matches == true) {
                    array_shift($matches);
                    $controller->$method($request, ...$matches);
                    return;
                } else {
                    $controller->$method($request);
                    return;
                }
            }
        }

        http_response_code(404);
        require_once '../views/404.php';
        exit;
    }

    public static function url($name, $params = [])
    {
        if (!isset(self::$namedRoutes[$name])) {
            throw new \Exception("Route with name {$name} not found.");
        }
        $uri = self::$namedRoutes[$name]['uri'];

        foreach ($params as $key => $value) {
            $uri = str_replace("{" . $key . "}", $value, $uri);
        }

        return $uri;
    }
}
