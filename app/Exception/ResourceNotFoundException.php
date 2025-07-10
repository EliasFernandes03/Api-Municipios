<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class ResourceNotFoundException extends Exception
{
    public function __construct(string $message = 'Resource Not Found')
    {
        parent::__construct($message);
    }
}