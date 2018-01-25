<?php

namespace Dooki;

class DookiRequest extends DookiAuth
{
    private $api;

    /**
     * DookiRequest constructor.
     *
     * @param string $api
     */
    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * @return DookiRequest
     */
    public static function production()
    {
        return new DookiRequest('https://api.dooki.com.br/v2');
    }

    /**
     * @return DookiRequest
     */
    public static function sandbox()
    {
        return new DookiRequest('https://api-sandbox.dooki.com.br/v2');
    }
    
    /**
     * @return DookiRequest
     */
    public static function local()
    {
        return new DookiRequest('http://bubbstore-api-v2.local');
    }
}