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

    public function __construct(array $pagination)
    {
        $this->total = $pagination['total'];
        $this->count = $pagination['count'];
        $this->perPage = $pagination['per_page'];
        $this->currentPage = $pagination['current_page'];
        $this->totalPages = $pagination['total_pages'];
        $this->nextLink = count($pagination['links']) > 0 ? $pagination['links']['next'] : null;
        $this->previousLink = count($pagination['links']) > 0 ? $pagination['links']['previous'] : null;
    }

    /**
     * getTotal
     * @return int
     */
    public function getTotal() :int
    {
        return $this->total;
    }

    /**
     * getCount
     * @return int
     */
    public function getCount() :int
    {
        return $this->count;
    }

    /**
     * getPerPage
     * @return int
     */
    public function getPerPage() :int
    {
        return $this->perPage;
    }

    /**
     * getCurrentPage
     * @return int
     */
    public function getCurrentPage() :int
    {
        return $this->currentPage;
    }

    /**
     * getTotalPages
     * @return int
     */
    public function getTotalPages() :int
    {
        return $this->totalPages;
    }

    /**
     * getNextLink
     * @return string
     */
    public function getNextLink() :string
    {
        return $this->nextLink;
    }

    /**
     * getPreviousLink
     * @return string
     */
    public function getPreviousLink() :string
    {
        return $this->previousLink;
    }
}
