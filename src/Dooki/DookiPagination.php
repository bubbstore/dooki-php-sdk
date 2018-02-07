<?php

namespace Dooki;

class DookiPagination
{
    
    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $perPage;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $totalPages;

    /**
     * @var string
     */
    private $nextLink;

    /**
     * @var string
     */
    private $previousLink;

    public function __construct($pagination)
    {
        $this->total = $pagination['total'];
        $this->count = $pagination['count'];
        $this->perPage = $pagination['per_page'];
        $this->currentPage = $pagination['current_page'];
        $this->totalPages = $pagination['total_pages'];
        if (count($pagination['links']) > 0) {
            if (isset($pagination['links']['next'])) {
                $this->nextLink = $pagination['links']['next'];
            }
            if (isset($pagination['links']['previous'])) {
                $this->previousLink = $pagination['links']['previous'];
            }
        }
    }

    /**
     * getTotal
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * getCount
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * getPerPage
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * getCurrentPage
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * getTotalPages
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * getNextLink
     * @return string
     */
    public function getNextLink()
    {
        return $this->nextLink;
    }

    /**
     * getPreviousLink
     * @return string
     */
    public function getPreviousLink()
    {
        return $this->previousLink;
    }
}
