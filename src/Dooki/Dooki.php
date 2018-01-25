<?php

namespace Dooki;

class Dooki
{
    private $request;

    /**
     * Create an instance of Dooki choosing the environment where the requests will be send.
     *
     * @param string $jwt The user's current JSON Web Token.
     * @param DookiRequest $environment 
     *                     The environment: {@link DookiRequest::production()} or {@link DookiRequest::sandbox()} or {@link DookiRequest::local()}
     */
    public function __construct($jwt, DookiRequest $environment = null)
    {
        if (is_null($environment))
        {
            $environment = $jwt;

            $jwt = null;
        }

        $this->request = $environment;

        if ( ! is_null($jwt))
        {
            $this->request->setJwt($jwt);
        }
    }
    
    /**
     * Magic __call method is triggered whenever an unexisting method is called in a class. This is 
     * the case whenever any DookiRequest's or DookiAuth's method is called from the Dooki wrapper.
     * Its job is to redirect the method call to the DookiRequest's class.
     * 
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, array $arguments)
    {
        call_user_func_array(array($this->request, $name), $arguments);
    }
}