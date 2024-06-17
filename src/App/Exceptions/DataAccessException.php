<?php

declare(strict_types=1);

namespace App\Exceptions;

class DataAccessException extends BaseException
{
    protected $message = "Access to this data is forbidden";
}