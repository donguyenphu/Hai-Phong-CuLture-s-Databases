<?php
class Pagination
{
    private $totalItems;
    private $totalItemsPerPage;
    private $pageRange;
    private $totalPages;
    private $currentPage;
    public function __construct($totalItems, $totalItemsPerPage, $pageRange, $currentPage)
    {
        $this->currentPage = $currentPage;
        $this->totalItems = $totalItems;
        $this->totalItemsPerPage = $totalItemsPerPage;
        $this->pageRange = $pageRange;
        $this->totalPages = floor( $totalItems / $totalItemsPerPage) + ($totalItems % $totalItemsPerPage !== 0);
    }
    public function showPagination()
    {
        $paginaionHTML = '';
        $start     = '<li>Start</li>';
        $prev     = '<li>Previous</li>';
        if ($this->currentPage > 1) {
            $start     = '<li><a href="?page=1">Start</a></li>';
            $prev     = '<li><a href="?page=' . ($this->currentPage - 1) . '">Previous</a></li>';
        }

        $next     = '<li>Next</li>';
        $end     = '<li>End</li>';
        if ($this->currentPage < $this->totalPages) {
            $next     = '<li><a href="?page=' . ($this->currentPage + 1) . '">Next</a></li>';
            $end     = '<li><a href="?page=' . $this->totalPages . '">End</a></li>';
        }

        if ($this->pageRange < $this->totalPages) {
            if ($this->currentPage == 1) {
                $startPage     = 1;
                $endPage     = $this->pageRange;
            } else if ($this->currentPage == $this->totalPages) {
                $startPage        = $this->totalPages - $this->pageRange + 1;
                $endPage        = $this->totalPages;
            } else {
                $startPage        = $this->currentPage - ($this->pageRange - 1) / 2;
                $endPage        = $this->currentPage + ($this->pageRange - 1) / 2;

                if ($startPage < 1) {
                    $endPage    = $endPage + 1;
                    $startPage = 1;
                }

                if ($endPage > $this->totalPages) {
                    $endPage    = $this->totalPages;
                    $startPage     = $endPage - $this->pageRange + 1;
                }
            }
        } else {
            $startPage        = 1;
            $endPage        = $this->totalPages;
        }
        $listPages = '';
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $this->currentPage) {
                $listPages .= '<li class="active">' . $i . '</a>';
            } else {
                $listPages .= '<li><a href="?page=' . $i . '">' . $i . '</a>';
            }
        }
        $paginationHTML = '<ul class="pagination">' . $start . $prev . $listPages . $next . $end . '</ul>';
        return $paginaionHTML;
    }
    public function totalItems() {
        return $this -> totalItems;
    }
    public function totalItemsPerPage() {
        return $this -> totalItemsPerPage();
    }
    public function pageRange() {
        return $this -> pageRange();
    }
    public function totalPages() {
        return $this -> totalPages();
    }
    public function currentPage() {
        return $this -> currentPage();
    }
}
