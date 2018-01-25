<?php

namespace Dooki;

class DookiAuth
{
    private $token;

    private $type;

    private $expiresIn;

    /**
     * @param array $params
     *
     * @throws Dooki\DookiRequestException if anything gets wrong.
     */
    public function login(array $params)
    {
        $response = $this->request('POST', 'auth/login', $params);

        dd($response->getResponse());
    }
}