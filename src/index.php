<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Router\RouterMapper;
use App\Controller\HomeController;
use App\Router\Exception\RouterException;
use App\Controller\FrontController;
use Monolog\Logger;
use App\Service\ExceptionLogger;

header('Content-Type: application/json');

$logger = new Logger('router');
$exceptionLogger = new ExceptionLogger($logger);

$router = new RouterMapper();

$router->addGetRoute('/{id}',[FrontController::class, 'home']);

$router->addGetRoute('/about',[HomeController::class, 'about']);

try {
    $router->handleRoute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (RouterException $e) {
    $exceptionLogger->log($e);
}