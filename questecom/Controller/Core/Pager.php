<?php

namespace Controller\Core;

class Pager
{
    protected $totalRecords = null;
    protected $noOfPages = null;
    protected $recordsPerPage = null;
    protected $currentPage = null;
    protected $start = 1;
    protected $next = null;
    protected $previous = null;
    protected $end = null;

    public function setTotalRecords($totalRecords)
    {
        $this->totalRecords = $totalRecords;
        return $this;
    }

    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    public function setNoOfPages($noOfPages)
    {
        $this->noOfPages = $noOfPages;
        return $this;
    }

    public function getNoOfPages()
    {
        return $this->noOfPages;
    }

    public function setRecordsPerPage($recordsPerPage)
    {
        $this->recordsPerPage = $recordsPerPage;
        return $this;
    }

    public function getRecordsPerPage()
    {
        return $this->recordsPerPage;
    }

    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setNext($next)
    {
        $this->next = $next;
        return $this;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function setPrevious($previous)
    {
        $this->previous = $previous;
        return $this;
    }

    public function getPrevious()
    {
        return $this->previous;
    }

    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function calculate()
    {
        $this->setNoOfPages(@ceil($this->getTotalRecords() / $this->getRecordsPerPage()));

        if ($this->getTotalRecords() <= $this->getRecordsPerPage()) {
            $this->setStart(1);
            $this->setEnd(null);
            $this->setNext(null);
            $this->setPrevious(null);
            // $this->setCurrentPage($this->getStart());
            return $this;
        }

        if ($this->getCurrentPage() < $this->getStart()) {
            $this->setCurrentPage($this->getStart());
            $this->setEnd($this->getNoOfPages());
            $this->setNext($this->getCurrentPage() + 1);
            $this->setPrevious(null);
            return $this;
        }

        if ($this->getCurrentPage() > $this->getNoOfPages()) {
            $this->setEnd($this->getNoOfPages());
            $this->setCurrentPage($this->getEnd());
            $this->setPrevious($this->getCurrentPage() - 1);
            $this->setNext(null);
            return $this;
        }

        if ($this->getCurrentPage() == $this->getNoOfPages()) {
            $this->setEnd($this->getNoOfPages());
            $this->setNext(null);
            $this->setPrevious($this->getCurrentPage() - 1);
            $this->setStart($this->getStart());
            return $this;
        }

        if ($this->getCurrentPage() == $this->getStart()) {
            $this->setEnd($this->getNoOfPages());
            $this->setNext($this->getCurrentPage() + 1);
            $this->setPrevious(null);
            return $this;
        }

        if ($this->getCurrentPage() != $this->getNoOfPages() && $this->getCurrentPage() != $this->getStart()) {
            $this->setNext($this->getCurrentPage() + 1);
            $this->setPrevious($this->getCurrentPage() - 1);
            $this->setEnd($this->getNoOfPages());
            return $this;
        }
    }
}
