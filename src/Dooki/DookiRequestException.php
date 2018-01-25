<?php

namespace Dooki;

use Exception;

class DookiRequestException extends Exception
{
	private $statusCode;

	/**
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * DookiRequestException constructor.
	 * 
	 * @param string $message
	 * @param integer $statusCode {@link 0 means the request did not reached Dooki}
	 */
    public function __construct($message, $statusCode = 0)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message);
    }
}