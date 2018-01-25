<?php

namespace Dooki;

use Dooki\DookiRequestException;

class DookiResponse
{
    private $response = array();

    private $data = array();

    /**
     * Sets Dooki's entire response.
     * 
     * @param array $response
     */
    private function setResponse(array $response)
    {
        $this->response = $response;
    }

    /**
     * Sets Dooki data key's data.
     * 
     * @param array $data
     */
    private function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * DookiResponse constructor.
     *
     * @param string $response
     */
    public function __construct($response)
    {
        $response = json_decode($response, true);

        $this->setResponse($response);

        if (isset($response['data'])) {
            $this->setData($response['data']);
        }
    }

    /**
     * Gets Dooki's entire response.
     * 
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * Gets Dooki data key's data.
     * 
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}