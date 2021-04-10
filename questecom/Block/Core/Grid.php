<?php

namespace Block\Core;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends Template
{
    protected $products = [];
    protected $collection = null;
    protected $columns = [];
    protected $actions = [];
    protected $status = [];
    protected $buttons = [];
    protected $title = null;
    protected $primaryColumn = [];
    protected $controller = null;
    protected $pager = null;
    protected $filters = [];
    protected $filterButton = [];

    public function __construct()
    {
        $this->setTemplate('View/core/grid.php');
        $this->prepareCollection();
        $this->prepareButtons();
        $this->prepareColumns();
        $this->prepareActions();
        $this->preparePrimaryColumn();
        $this->prepareFilter();
        $this->prepareFilterButton();
    }

    public function getCollection()
    {
        if (!$this->collection) {
            $this->prepareCollection();
        }
        return $this->collection;
    }

    public function setCollection($collection)
    {
        $this->collection = $collection;
        return $this;
    }

    public function prepareCollection()
    {
        return $this;
    }

    public function setTitle()
    {
        return "Manage Module";
    }

    public function keepController()
    {
        return "anything";
    }

    public function getButtons()
    {
        return $this->buttons;
    }

    public function addButton($key, $value)
    {
        $this->buttons[$key] = $value;
        return $this;
    }

    public function prepareButtons()
    {
        return $this;
    }

    public function getPrimaryColumn()
    {
        return $this->primaryColumn;
    }

    public function addPrimaryColumn($key, $value)
    {
        $this->primaryColumn[$key] = $value;
        return $this;
    }

    public function preparePrimaryColumn()
    {
        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function addColumn($key, $value)
    {
        $this->columns[$key] = $value;
        return $this;
    }

    public function prepareColumns()
    {
        return $this;
    }

    public function getFieldValue($row, $field)
    {
        return $row->$field;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function addAction($key, $value)
    {
        $this->actions[$key] = $value;
        return $this;
    }

    public function prepareActions()
    {
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function addStatus($key, $value)
    {
        $this->status[$key] = $value;
        return $this;
    }

    public function getMethodUrl($row, $methodName, $ajax = true)
    {
        return $this->$methodName($row, $ajax);
    }

    public function getButtonUrl($methodName, $ajax = true)
    {
        return $this->$methodName($ajax);
    }

    public function prepareStatus()
    {
        $this->addStatus('0', [
            'label' => 'Disable',
            'method' => 'getStatusUrl',
            'style' => 'color: white;',
            'class' => 'btn btn-danger',
        ]);

        $this->addStatus('1', [
            'label' => 'Enable',
            'method' => 'getStatusUrl',
            'style' => 'color: white;',
            'class' => 'btn btn-info',
        ]);

    }

    public function addFilterButton($key, $value)
    {
        $this->filterButton[$key] = $value;
    }
    public function getFilterButtons()
    {
        return $this->filterButton;
    }
    public function prepareFilter()
    {
        return $this;
    }
    public function getFilters()
    {
        return $this->filters;
    }
    public function addFilter($key, $value)
    {
        $this->filters[$key] = $value;
        return $this;
    }
    public function prepareFilterButton()
    {
        return $this;
    }

    public function getPager()
    {
        if (!$this->pager) {
            return \Mage::getController('controller\Core\Pager');
        }
        return $this->pager;
    }
    public function setPager(\controller\Core\Pager $pager)
    {
        $this->pager = $pager;
    }
}
