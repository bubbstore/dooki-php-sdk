<?php

namespace Dooki;

use Exception;

class DookiRequestException extends Exception
{
    private $dookiStatusCode;

    private $dookiMessage;

    /**
     * @return int
     */
    public function getDookiStatusCode()
    {
        return $this->dookiStatusCode;
    }

    /**
     * @return int
     */
    public function getDookiMessage()
    {
        return $this->dookiMessage;
    }

    /**
     * DookiRequestException constructor.
     *
     * @param string $message
     * @param integer $statusCode {@link 0 means the request did not reached Dooki}
     */
    public function __construct($message, $statusCode = 0)
    {
        $this->dookiStatusCode = $statusCode;

        parent::__construct($message);
    }
}
