<?php

namespace Dooki;

use Dooki\DookiRequestException;
use Dooki\DookiPagination;

class DookiResponse
{
    private $response = [];

    private $data = [];

    private $meta = [];

    /**
     * Sets Dooki's entire response.
     *
     * @param array $response
     */
    private function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Sets Dooki data key's data.
     *
     * @param array $data
     */
    private function setData($data)
    {
        $this->data = $data;
    }

    /**
     * setMeta
     *
     * @param array $data
     */
    private function setMeta($value)
    {
        $this->meta = $value;
    }

    /**
     * getMeta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * pagination
     * @return array
     */
    public function pagination()
    {
        return new DookiPagination($this->getMeta()['pagination']);
    }

    /**
     * DookiResponse constructor.
     *
     * @param string $response
     */
    public function __construct($response)
    {
        if (!is_array($response)) {
            $response = json_decode($response, true);
        }

        $this->setResponse($response);

        if (isset($response['meta'])) {
            $this->setMeta($response['meta']);
        }

        if (isset($response['data'])) {
            $this->setData($response['data']);
        }
    }

    /**
     * Get Dooki response's HTTP status code.
     *
     * @return integer
     */
    public function getStatusCode()
    {
        if (isset($this->response['status_code'])) {
            return $this->response['status_code'];
        }

        return 0;
    }

    /**
     * Gets Dooki's entire response.
     *
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Gets Dooki data key's data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
