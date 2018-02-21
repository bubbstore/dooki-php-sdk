<?php

namespace Dooki;

use Dooki\DookiRequestException;

class DookiAuth
{
    private $authToken = null;

    private $authTokenType = null;

    /**
     * Sets the auth token.
     *
     * @param string $token
     */
    public function setAuthToken($token)
    {
        $this->authToken = $token;
    }

    /**
     * Sets the auth token type.
     *
     * @param string $type {@link 'bearer' which means JWT} or {@link 'token'}
     */
    public function setAuthTokenType($type)
    {
        $this->authTokenType = $type;
    }

    /**
     * Gets the auth token.
     *
     * @return string
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * Gets the auth token type.
     *
     * @return string
     */
    public function getAuthTokenType()
    {
        return $this->authTokenType;
    }

    /**
     * @param array $params
     *
     * @throws Dooki\DookiRequestException if anything gets wrong.
     */
    public function login($params)
    {
        $response = $this->request('POST', 'auth/login', $params)->getResponse();

        if (! (isset($response['access_token']) && isset($response['token_type']))) {
            throw new DookiRequestException('Login could not be completed. Dooki\'s response was incomplete.', 200);
        }

        $this->setAuthToken($response['access_token']);

        $this->setAuthTokenType($response['token_type']);

        return $this;
    }

    /**
     * @param string $token
     */
    public function userToken($token)
    {
        $this->setAuthToken($token);

        $this->setAuthTokenType('user-token');

        return $this;
    }
}
