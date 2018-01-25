<?php

namespace Dooki;

class DookiAuth
{
    private $jwt;

    /**
     * Sets the DookiAuth's JSON Web Token.
     * 
     * @param string $jwt
     */
    public function setJwt($jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Gets the DookiAuth's JSON Web Token.
     * 
     * @return string
     */
    public function getJwt()
    {
        return $this->jwt;
    }

    /**
     * @param array $params
     *
     * @throws Dooki\DookiRequestException if anything gets wrong.
     */
    public function login(array $params)
    {
        $this->request('POST', 'auth/login', $params);
    }
}