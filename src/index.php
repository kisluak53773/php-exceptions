<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Exceptions\{BaseException, ValidationException};

try {
    throw new ValidationException();
} catch (BaseException $e) {
    echo $e->getMessage() . PHP_EOL;
}

try {
    throw new BaseException();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
    error_log($e->getMessage());
}