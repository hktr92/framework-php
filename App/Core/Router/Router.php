<?php

namespace App\Core\Router;

use App\Core\Config;

class Router
{
    private $routes;

    public function __construct(Config $routes)
    {
        $this->routes = [];

        $routesData = $routes->getData();

        foreach ($routesData["routes"] as $route) {
            $url = $route["url"];
            $method = $route["method"];
            $view = $route["view"];

            $model = "";
            $controller = "";
            $action = "";

            if (isset($route["model"])) {
                $model = $route["model"];
            }

            if (isset($route["controller"])) {
                $controller = $route["controller"];

                if (isset($route["action"])) {
                    $action = $route["action"];
                }
            }

            $this->routes[$method][$url] = new BaseRoute($view, $model, $controller, $action);
        }
    }

    public function match(string $request, string $requestMethod)
    {
        if (isset($this->routes[$requestMethod][$request])) {
            return $this->routes[$requestMethod][$request];
        }

        return null;
    }
}