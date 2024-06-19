<?php

declare(strict_types=1);

namespace App\Router\RouteValidator;

use App\Router\RouteValidator\Api\RouteValidatorInterface;

class ValidateRouteIsSet implements RouteValidatorInterface
{
    public function validate(string $requestUri, string $method, mixed $action = null): void
    {
        if (!isset($this->routes[$routeUrl]) || !isset($this->routes[$routeUrl][$method])) {
            http_response_code(404);
            echo json_encode(["message" => "Route not found."]);
            throw new NotFoundException();
        }
    }
}