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
     * @param string $email
     * @param string $passw
     *
     * @throws DookiRequestException
     */
    public function login($email, $passw)
    {
        dd($email, $passw);
    }
}