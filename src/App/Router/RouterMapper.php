<?php

declare(strict_types=1);

namespace App\Router;

use App\Router\Exception\ControllerMethodNotDefined;
use App\Router\Exception\ControllerNotFound;
use App\Router\Exception\NotFoundException;
use App\Router\Exception\WrongControllerDefinition;

class RouterMapper
{
    private array $routes = [];

    public function register(string $routeUrl, string $method, array $action): void
    {
        $this->routes[$routeUrl][$method] = $action;
    }

    public function addGetRoute($routeUrl, array $action): void
    {
        $this->register($routeUrl, 'GET', $action);
    }

    public function addPostRoute($routeUrl, array $action): void
    {
        $this->register($routeUrl, 'POST', $action);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function parseUrl(string $routeUrl, string $pattern): array|false
    {
        $regex = preg_replace('/\{(\w+)\}/', '(?P<${1}>\d+)', $pattern);
        $regex = str_replace('/', '\/', $regex);

        echo preg_match('/^'.$regex.'$/', $pattern, $matches);

        var_dump($matches);

        if (preg_match('/^'.$regex.'$/', $routeUrl, $matches)) {
            return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        }

        return false;
    }

    /**
     * @param string $routeUrl
     * @param string $method
     * @return mixed
     * @throws ControllerMethodNotDefined
     * @throws ControllerNotFound
     * @throws NotFoundException
     * @throws WrongControllerDefinition
     */
    public function handleRoute(string $routeUrl, string $method): mixed
    {
        foreach ($this->routes as $storedUrl => $actions) {
            $params = $this->parseUrl($routeUrl, $storedUrl);
            if (is_array($params)) {
                if (!isset($actions[$method])) {
                    http_response_code(404);
                    echo json_encode(["message" => "Route not found."]);
                    throw new NotFoundException();
                }

                $action = $actions[$method];

                if (!$action) {
                    http_response_code(404);
                    echo json_encode(["message" => "Route not found."]);
                    throw new NotFoundException();
                }

                if (!is_array($action)) {
                    http_response_code(500);
                    echo json_encode(["message" => "Something went wrong"]);
                    throw new WrongControllerDefinition();
                }

                [$class, $method] = $action;

                if (!class_exists($class)) {
                    http_response_code(500);
                    echo json_encode(["message" => "Something went wrong"]);
                    throw new ControllerNotFound();
                }

                $classInstance = new $class();

                if (!method_exists($classInstance, $method)) {
                    http_response_code(500);
                    echo json_encode(["message" => "Something went wrong"]);
                    throw new ControllerMethodNotDefined();
                }

                return call_user_func_array([$classInstance, $method], [...$params]);

            }
        }

        http_response_code(404);
        echo json_encode(["message" => "Route not found."]);
        throw new NotFoundException();
    }
}