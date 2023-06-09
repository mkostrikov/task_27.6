<?php

namespace App\Core;

use App\Core\Exceptions\NotFoundException;

class Route
{
    public static function start()
    {
        $route = $_SERVER['REQUEST_URI'];
        $routes = require_once ROUTES . 'routes.php';

        $isRouteFound = false;
        foreach ($routes as $pattern => [$controllerName, $actionName])
        {
            preg_match($pattern, $route, $matches);
            if (!empty($matches)) {
                $isRouteFound = true;
                break;
            }
        }

        if ($isRouteFound === false) {
            throw new NotFoundException();
        }

        unset($matches[0]);

        $controller = new $controllerName;
        $controller->$actionName(...$matches);
    }
}