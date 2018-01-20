<?php

namespace Dooki;

use Dooki\DookiEndpoint;
use Dooki\Exceptions\DookiRequestException;

class Dooki
{

	/**
	 * @var string
	 */
	private $merchant = null;

	/**
	 * @var string
	 */
	private $endpoint;

	public function __construct(DookiEndpoint $endpoint)
	{
		$this->endpoint = $endpoint;
	}

	public function getMerchant()
	{
		return $this->merchant;
	}

	public function setMerchant($value)
	{
		$this->merchant = $value;
		return $this;
	}

	public function getEndpoint()
	{
		return $this->endpoint;
	}

}