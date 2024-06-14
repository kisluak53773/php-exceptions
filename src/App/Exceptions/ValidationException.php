<?php

declare(strict_types=1);

namespace App\Exceptions;

class ValidationException extends BaseException
{
    protected $message = "The given data was invalid.";
}