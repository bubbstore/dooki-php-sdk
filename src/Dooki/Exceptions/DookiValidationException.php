<?php

namespace Dooki\Exceptions;

use Exception;

class DookiValidationException extends Exception
{
    private $errors;

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * DookiValidationException constructor.
     *
     * @param string $message
     * @param int    $statusCode
     * @param array  $errors
     */
    public function __construct($message, int $statusCode, array $errors)
    {
        $this->errors = $errors;
        parent::__construct($message, $statusCode);
    }
}
