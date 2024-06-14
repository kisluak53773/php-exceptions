<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
class InvalidFormatException extends Exception
{
    protected $message = 'Invalid input format';
}