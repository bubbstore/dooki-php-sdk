<?php

namespace Dooki;

use GuzzleHttp\Client as Client;

class DookiRequest extends DookiAuth
{
    private $api;

    private $method;

    private $route;

    private $headers = array();

    private $query = array();

    private $json = array();

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
    public static function local($api = 'http://bubbstore-api-v2.local/v2')
    {
        return new DookiRequest($api);
    }

    /**
     * Sets the request's HTTP method.
     * 
     * @param string $method
     *
     * @throws Dooki\DookiRequestException if anything gets wrong.
     */
    public function setMethod($method)
    {
        if ( ! ($method == 'GET' || $method == 'POST' || $method == 'PUT' || $method == 'DELETE')) {
            throw new DookiRequestException($method . ' is not a valid HTTP method. Use GET, POST, PUT or DELETE instead.');
        }

        $this->method = $method;
    }

    /**
     * Sets the request's API route.
     * 
     * @param string $route
     *
     * @throws Dooki\DookiRequestException if anything gets wrong.
     */
    public function setRoute($route)
    {
        if ( ! ($route[0] == '/')) {
            $route = '/' . $route;
        }

        $this->route = $route;
    }

    /**
     * Sets a body param to the query or json property.
     * 
     * @param string $property {@link 'query'} or {@link 'json'}
     * @param string $key
     * @param string $name
     *
     * @throws Dooki\DookiRequestException if anything gets wrong.
     */
    public function setBodyParam($property, $key, $name)
    {
        if ( ! property_exists($this, $property))
        {
            throw new DookiRequestException($property . ' is not a valid property for DookiRequest. Use headers, query or json.');
        }

        $this->$property[$key] = $name;
    }

    /**
     * Sets the request's body.
     * 
     * @param array $body
     */
    public function setBody(array $body)
    {
        foreach ($body as $key => $param) {
            $this->setBodyParam(($this->getMethod() == 'GET' ? 'query' : 'json'), $key, $param);
        }
    }

    /**
     * Gets the request's HTTP method.
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Gets the request's API route.
     * 
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Gets the request's API.
     * 
     * @return string
     */
    public function getApi()
    {
        // Handles merchant aliases and other params.

        return $this->api . $this->route;
    }

    /**
     * Gets the request's body.
     * 
     * @return array
     */
    public function getBody()
    {
        return [
            'headers' => $this->headers,
            'query' => $this->query,
            'json' => $this->json
        ];
    }

    /**
     * Requests Dooki.
     *
     * @param string $method
     * @param string $route
     * @param array $body
     * 
     * @throws Dooki\DookiRequestException if anything gets wrong.
     *
     * @return array
     */
    public function request($method, $route, array $body = array())
    {
        $this->setMethod($method);

        $this->setRoute($route);

        $this->setBody($body);

        $client = new Client();
        dd($this->getBody());
        $request = $client->request($this->getMethod(), $this->getApi(), $this->getBody());

        dd($request);

        dd($http, $route, $params);
    }
    
    /**
     * @return void
     */
    public function skipCache()
    {
        $this->setBodyParam('query', 'skipCache', 'true');

        return $this;
    }
}