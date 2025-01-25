<?php

use Core\Auth;

function layout(string $layout, array $data = [])
{
    $layout_folder = ".views.layouts.";
    extract($data);
    include BASE_PATH . str_replace(".", DIRECTORY_SEPARATOR, $layout_folder) . $layout . ".php";
}

function component(string $component, array $data = [])
{
    $component_folder = ".views.components.";
    extract($data);
    include BASE_PATH . str_replace(".", DIRECTORY_SEPARATOR, $component_folder) . $component . ".php";
}

function route($name, $params = [])
{
    global $router;
    return $router->url($name, $params);
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function json_response($data, $status_code = 200)
{
    // send json response with status code
    header('Content-Type: application/json');
    $response = $data;
    echo json_encode($response);
    http_response_code($status_code);
    // exit;
}

function asset($path)
{
    $baseUrl = ($_SERVER['HTTPS'] ?? 'off') === 'on' ? "https://{$_SERVER['HTTP_HOST']}" : "http://{$_SERVER['HTTP_HOST']}";
    return $baseUrl . '/' . ltrim($path, '/');
}

function auth()
{
    if (\Core\Session::get('auth')) {
        return Auth::user();
    } else {
        return false;
    }
}

function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo "</pre>";
    http_response_code(500);
    exit;
}
