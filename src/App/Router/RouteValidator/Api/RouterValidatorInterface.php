<?php

declare(strict_types=1);

namespace App\Router\RouteValidator\Api;

interface RouteValidatorInterface
{
    public function validate(string $requestUri, string $method, mixed $action = null): void;
}