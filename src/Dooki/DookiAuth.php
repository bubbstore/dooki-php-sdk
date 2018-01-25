<?php

namespace Dooki;

use Dooki\DookiRequestException;

class DookiAuth
{
    private $me = null;

    private $authToken = null;

    private $authTokenType = null;

    /**
     * Sets the authed user.
     *
     * @param array $me
     */
    public function setMe(array $me)
    {
        $this->me = $me;
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
     * Gets the auth token me.
     *
     * @return string
     */
    public function getMe()
    {
        return $this->me;
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
    public function login(array $params)
    {
        $response = $this->request('POST', 'auth/login', $params)->getResponse();

        if (! (isset($response['access_token']) && isset($response['token_type']))) {
            throw new DookiRequestException('Login could not be completed. Dooki\'s response was incomplete.', 200);
        }

        $this->setAuthToken($response['access_token']);

        $this->setAuthTokenType($response['token_type']);
        
        $this->setMe($this->request('POST', '/auth/me')->getData());

        return $this;
    }
}
