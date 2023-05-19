<?php

namespace App\Core;

class Route
{
    public static function start()
    {
        $controllerName = 'Home';
        $model = null;
        $actionName = 'index';
        $payload = [];

        $routes = explode(DIRECTORY_SEPARATOR, $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controllerName = ucfirst($routes[1]);
        }

        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        $controllerClassName = 'App\\Controllers\\' . $controllerName;
        $modelClassName = 'App\\Models\\' . $controllerName;

        $modelFile = MODEL . $controllerName . '.php';
        if (file_exists($modelFile)) {
            $model = new $modelClassName;
        }
        $controllerFile = CONTROLLER . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            $controller = new $controllerClassName($model);

        } else {
            Route::errorPage404();
        }

        if (method_exists($controller, $actionName)) {
            $controller->$actionName($payload);
        } else {
            Route::errorPage404();
        }
    }

    public static function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        header('Location:' . $host . 'error');
    }
}