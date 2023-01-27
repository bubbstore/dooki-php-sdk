<?php

namespace Dooki;

use Dooki\Exceptions\DookiRequestException;

class DookiAuth
{
    private $authToken = null;

    private $userSecretKey = null;

    private $authTokenType = null;

    private $user;

    /**
     * setUser
     *
     * @param array $value
     */
    public function setUser($value)
    {
        $this->user = $value;
    }

    /**
     * getUser
     *
     * @return array
     */
    public function getUser()
    {
        return $this->user;
    }

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

        $this->setAuthToken($response['access_token']);

        $this->setAuthTokenType($response['token_type']);

        $this->setUser($response['user']);

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

    public function setUserSecretKey($value)
    {
        $this->userSecretKey = $value;

        return $this;
    }

    public function getUserSecretKey()
    {
        return $this->userSecretKey;
    }
}
