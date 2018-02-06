<?php

namespace Dooki\Exceptions;

use Exception;

use Dooki\DookiRequest;
use Dooki\DookiResponse;

class DookiRequestException extends Exception
{
    private $request;

    private $response;

    /**
     * @return int
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return int
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * DookiRequestException constructor.
     *
     * @param string $message
     * @param integer $request
     * @param integer $response
     */
    public function __construct($message, DookiRequest $request = null, DookiResponse $response = null)
    {
        $this->request = $request;

        $this->response = $response;

        parent::__construct($message);
    }
}
