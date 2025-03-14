<?php
class Pagination
{
    private $totalItems;
    private $totalItemsPerPage;
    private $pageRange;
    private $totalPages;
    private $currentPage;
    private $serverQuery;


    public function __construct($totalItems, $totalItemsPerPage, $pageRange, $currentPage, $totalPages, $serverQuery = '')
    {
        $this->currentPage = $currentPage;
        $this->totalItems = $totalItems;
        $this->totalItemsPerPage = $totalItemsPerPage;
        $this->pageRange = $pageRange;
        $this->totalPages = $totalPages;
        $this->serverQuery = $serverQuery;
    }
    public function showPagination()
    {
        $pasteQuery = '';
        if (!is_null($this->serverQuery)) {
            $pasteQuery = $this->serverQuery;
        }
        $temporary = $pasteQuery;
        $temporary = explode('&', $temporary);
        foreach ($temporary as $key => $value) {
            /// value
            if (str_contains($value, 'page')) {
                $temporary = array_values(array_diff($temporary, [$value]));
                break;
            }
        }
        $temporary = '&' . implode('&', $temporary);
        $paginaionHTML = '';
        $start     = '<li class="page-item"><a class="page-link" href="#">Start</a></li>';
        $prev     = '<li class="page-item"><a class="page-link" href="#">«</a></li>';
        if ($this->currentPage > 1) {
            $start     = '<li class="page-item"><a  class="page-link" href="index.php?page=1' . $temporary . '">Start</a></li>';
            $prev     = '<li class="page-item"><a  class="page-link" href="?page=' . ($this->currentPage - 1) . $temporary . '">«</a></li>';
        }
        $next     = '<li class="page-item"><a class="page-link" href="#">»</a></li>';
        $end     = '<li class="page-item"><a class="page-link" href="#">End</a></li>';
        if ($this->currentPage < $this->totalPages) {
            $next     = '<li class="page-item"><a class="page-link" href="index.php?page=' . ($this->currentPage + 1) . $temporary . '">»</a></li>';
            $end     = '<li class="page-item"><a class="page-link" href="index.php?page=' . $this->totalPages . $temporary . '">End</a></li>';
        }

        $startRender = $this->currentPage - floor(($this->pageRange - 1) / 2);

        $endRender = $this->currentPage + $this->pageRange - ($this->currentPage - $startRender + 1);

        if ($this->totalPages <= $this->pageRange) {
            $startRender = 1;
            $endRender = $this->totalPages;
        } else {
            // the first half
            if ($this->currentPage - floor(($this->pageRange - 1) / 2) <= 1) {
                $startRender = 1;
                $endRender = $this->currentPage + $this->pageRange - ($this->currentPage - $startRender + 1);
            }
            // minus the first half
            if ($this->currentPage + $this->pageRange - ($this->currentPage - $startRender + 1) >= $this->totalPages) {
                $endRender = $this->totalPages;
                $startRender = $this->totalPages - $this->pageRange + 1;
            }
        }

        $listPages = '';

        for ($i = $startRender; $i <= $endRender; $i++) {
            if ($i == $this->currentPage) {
                $listPages .= '<li class="page-item active"><a class="page-link" href="index.php?page=' . $i . $temporary . '">' . $i . '</a></li>';
            } else {
                $listPages .= '<li class="page-item"><a class="page-link" href="index.php?page=' . $i . $temporary . '">' . $i . '</a></li>';
            }
        }

        $paginationHTML = '<ul class="pagination pagination-sm m-0 float-end">' . $start . $prev . $listPages . $next . $end . '</ul>';

        return $paginationHTML;
    }
    public function totalItems()
    {
        return $this->totalItems;
    }
    public function totalItemsPerPage()
    {
        return $this->totalItemsPerPage();
    }
    public function pageRange()
    {
        return $this->pageRange();
    }
    public function totalPages()
    {
        return $this->totalPages();
    }
    public function currentPage()
    {
        return $this->currentPage();
    }
}
