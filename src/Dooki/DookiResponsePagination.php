<?php

namespace Dooki;

use Dooki\DookiRequest;

class DookiResponsePagination
{
    private $pagination = array();

    /**
     * DookiResponsePagination constructor.
     *
     * @param array $pagination
     */
    public function __construct(array $pagination = array()) 
    {
        $this->pagination = $pagination;
    }

    /**
     * Request Dooki's next page.
     * 
     * @return boolean
     */
    public function getNext()
    {
        if (empty($this->pagination)) {
            return false;
        }

        dd($this->request);
    }

    /**
     * Request Dooki's previous page.
     * 
     * @return boolean
     */
    public function getPrev()
    {

    }
}
