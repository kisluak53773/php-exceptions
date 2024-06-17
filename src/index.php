<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Exceptions\InvalidFormatException;

try {
    12/0;
} catch (ArithmeticError $e){
    echo 'Don\'t divide by zero' . PHP_EOL;
}

/**
 * @param string $str
 * @return bool
 * @throws InvalidFormatException
 */
function isValidEmail(string $str): bool
{
    $pattern = '/(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i';

    $result = preg_match($pattern, $str);

    if (!$result) {
        throw new InvalidFormatException();
    }

    return true;
}

try {
    isValidEmail('sadads');
} catch (InvalidFormatException $e){
    echo $e->getMessage() . PHP_EOL;
}