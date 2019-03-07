<?php

namespace Dooki;

use Dooki\DookiRequest;
use Dooki\Exceptions\DookiRequestException;
use Dooki\Exceptions\DookiValidationException;
use Dooki\DookiResponse;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\ClientException;

class DookiRequest extends DookiAuth
{
    private $api;

    private $method;

    private $merchant;

    private $route;

    private $headers = [];

    private $query = [];

    private $json = [];

    private $userAgent = 'dooki-php-sdk';

    private $version = 'v2';

    private $forceAlias = false;

    private $forgetAlias = false;

    /**
     * DookiRequest constructor.
     *
     * @param string $api
     */
    public function __construct($api)
    {
        $this->api = $api;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function forceAlias()
    {
        $this->forceAlias = true;
        return $this;
    }

    public function forgetAlias()
    {
        $this->forgetAlias = true;
        return $this;
    }

    /**
     * getUserAgent
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return DookiRequest
     */
    public static function production()
    {
        return new DookiRequest('https://api.dooki.com.br');
    }

    /**
     * @return DookiRequest
     */
    public static function sandbox()
    {
        return new DookiRequest('https://api-sandbox.dooki.com.br');
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
        if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
            throw new DookiRequestException($method . ' is not a valid HTTP method. Use GET, POST, PUT, PATCH or DELETE instead.');
        }

        $this->method = $method;

        return $this;
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
        if (! ($route[0] == '/')) {
            $route = '/' . $route;
        }

        $this->route = $route;

        return $this;
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
        if (! property_exists($this, $property)) {
            throw new DookiRequestException($property . ' is not a valid property for DookiRequest. Use headers, query or json.');
        }

        $this->$property[$key] = $name;

        return $this;
    }

    /**
     * Sets the request's body.
     *
     * @param array $body
     */
    public function setBody($body)
    {
        foreach ($body as $key => $param) {
            $this->setBodyParam(($this->getMethod() == 'GET' ? 'query' : 'json'), $key, $param);
        }

        return $this;
    }

    /**
     * Sets the request's merchant alias.
     *
     * @param string $alias
     */
    public function setMerchant($alias)
    {
        $alias = ltrim($alias, '/');

        $this->merchant = '/' . $alias;

        return $this;
    }

    /**
     * {@link->includes(['skus', 'images'])}
     * @return void
     */
    public function includes($includes)
    {
        $this->setBodyParam('query', 'include', implode(',', $includes));
        return $this;
    }

    /**
     * {@link ->search(['name' => 'Entity\'s Name'])}
     * @return void
     */
    public function search($search)
    {
        $searchString = '';

        foreach ($search as $field => $value) {
            if (!is_array($value)) {
                $searchString .= $field . ':' . $value;
                if (! (next($search) === false)) {
                    $searchString .= ';';
                }
            }
        }
        
        $this->setBodyParam('query', 'search', $searchString);

        return $this;
    }
    
    /**
     * {@link ->searchFields(['name' => 'like'])}
     * @return void
     */
    public function searchFields($searchFields)
    {
        $searchFieldsString = '';

        foreach ($searchFields as $field => $value) {
            $searchFieldsString .= $field . ':' . $value;
            if (! (next($searchFields) === false)) {
                $searchFieldsString .= ';';
            }
        }
        
        $this->setBodyParam('query', 'searchFields', $searchFieldsString);

        return $this;
    }
    
    /**
     * @return void
     */
    public function period($field, $start, $end = null)
    {
        if (is_null($end)) {
            $end = $start;

            $start = $field;

            $field = 'created_at';
        }

        $this->setBodyParam('query', 'date', $field . ':' . $start . '|' . $end);

        return $this;
    }

    /**
     * {@link ->orderBy('name')}
     * @return void
     */
    public function orderBy($orderBy)
    {
        $this->setBodyParam('query', 'orderBy', $orderBy);

        return $this;
    }

    /**
     * {@link ->sortedBy('name')}
     * @return void
     */
    public function sortedBy($sortedBy)
    {
        $this->setBodyParam('query', 'sortedBy', $sortedBy);

        return $this;
    }

    /**
     * {@link ->limit(20)}
     * @return void
     */
    public function limit($limit)
    {
        $this->setBodyParam('query', 'limit', $limit);

        return $this;
    }

    /**
     * {@link ->page(2)}
     * @return void
     */
    public function page($page)
    {
        $this->setBodyParam('query', 'page', $page);

        return $this;
    }

    /**
     * {@link ->skipCache()}
     * @return void
     */
    public function skipCache()
    {
        $this->setBodyParam('query', 'skipCache', 'true');

        return $this;
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
        $fragments = explode("/", ltrim($this->route, '/'));

        $ignoredPaths = ['auth', 'users', 'pvt'];

        if (!$this->forgetAlias) {
            if ((!in_array($fragments[0], $ignoredPaths) || $this->forceAlias)) {
                $this->route = $this->merchant . $this->route;
            }
        }

        return $this->api . '/'.$this->getVersion() . $this->route;
    }

    /**
     * Gets the request's body.
     *
     * @return array
     */
    public function getBody()
    {
        $headers = [];

        if ($this->getAuthTokenType() == 'bearer') {
            $headers['Authorization'] = 'Bearer ' . $this->getAuthToken();
        }

        if ($this->getAuthTokenType() == 'user-token') {
            $headers['User-Token'] = $this->getAuthToken();
        }

        $headers['User-Agent'] = $this->getUserAgent();

        return [
            'headers' => array_merge($this->headers, $headers),
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
    public function request($method, $route, $body = [])
    {
        $this->setMethod($method);

        $this->setRoute($route);

        $this->setBody($body);

        try {
            $client = new Client;
            $request = $client->request($this->getMethod(), $this->getApi(), $this->getBody());
            $response = $request->getBody()->getContents();
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);

            // Validation exception
            if ($e->getCode() == 422) {
                throw new DookiValidationException($response['message'], $e->getCode(), $response['errors']);
            }
            
            // Generic exception
            throw new DookiRequestException($response['message'], $this, new DookiResponse($response), $e->getCode());
        }

        return new DookiResponse($response);
    }
}
