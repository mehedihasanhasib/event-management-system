<?php
function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo "</pre>";

    exit;
}

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
    echo $router->url($name, $params);
}
