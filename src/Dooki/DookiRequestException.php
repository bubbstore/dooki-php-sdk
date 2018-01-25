<?php

namespace Dooki;

use Exception;

class DookiRequestException extends Exception
{
    private $statusCode;

    public function __construct($message, $statusCode = 0)
    {
        $this->statusCode = $statusCode;
        
        parent::__construct($message);
    }
}