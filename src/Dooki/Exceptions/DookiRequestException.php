<?php

namespace Dooki\Exceptions;

use Exception;

class DookiRequestException extends Exception
{
	public function __construct($message, $code)
	{
		parent::__construct($message, $code);
	}
}