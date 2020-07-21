<?php


class Paginate
{

    public $currentPage;
    public $itemsPerPAge;
    public $itemTotalCount;

    public function __construct($page = 1, $itemsPerPAge = 4, $itemTotalCount = 0)
    {
        $this->currentPage = (int)$page;
        $this->itemsPerPAge = (int)$itemsPerPAge;
        $this->itemTotalCount = (int)$itemTotalCount;
    }


    public function next()
    {
        return $this->currentPage+1;
    }

    public function previous()
    {
        return $this->currentPage-1;
    }

    public function pageTotal()
    {
        return ceil($this->itemTotalCount / $this->itemsPerPAge);
    }


    public function hasPrevious()
    {
        return $this->previous() >= 1 ? true : false;
    }

    public function hasNext()
    {
        return $this->next() <= $this->pageTotal() ? true : false;
    }


    public function offset()
    {
        return ($this->currentPage-1) * $this->itemsPerPAge;
    }

}