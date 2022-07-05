<?php

namespace mimilun\router;

use mimilun\controllers\ErrorController;

class Router
{
    protected static string $nameSpace = 'mimilun\controllers\\';

    public static function run(): void
    {
        $matches = [];
        $uri = $_GET['route'] ?? '';
        $isRouterFound = false;

        $routers = require_once __DIR__ . '/../settings/routes.php';

        foreach ($routers as $pattern => $router) {
            if (preg_match($pattern, $uri, $matches) === 1) {
                $isRouterFound = true;
                break;
            }
        }

        if ($isRouterFound) {
            $controller = $router[0];
            $action = $router[1];
            unset($matches[0]);

            (new $controller())->$action(...$matches);
        } else {
            (new ErrorController())->error();
        }
    }
}