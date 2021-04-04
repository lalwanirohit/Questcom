<?php

namespace Block\Admin\Shipping;

\Mage::loadFileByClassName('Block\Core\Grid');

class Grid extends \Block\Core\Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->prepareStatus();
    }

    public function prepareCollection()
    {
        $shipping = \Mage::getModel('Model\Shipping');
        $filter = \Mage::getModel('Model\Admin\Filter');
        if ($filterValue = $filter->getFilter('shipping')) {
            $filedName = array_keys($filterValue);
            $values = array_values($filterValue);
            $projection = 'WHERE';
            foreach ($filedName as $key => $value) {
                if ($values[$key]) {
                    $projection .= "`$filedName[$key]` like '%{$values[$key]}%' AND ";
                }
            }
            if ($projection == 'WHERE') {
                $projection = '';

            } else {

                $words = explode(" ", $projection);
                array_splice($words, -2);
                $projection = implode(" ", $words);
            }
            $query = "SELECT * FROM `{$shipping->getTableName()}` $projection";
            $rows = $shipping->all($query);
            $this->setCollection($rows);
        } else {
            $rows = $shipping->all();
            $this->setCollection($rows);
        }
    }

    public function setTitle()
    {
        return "Shipping";
    }

    public function keepController()
    {
        return "admin_shipping";
    }

    public function prepareFilterButton()
    {
        $this->addFilterButton('0', [
            'label' => 'Apply Filter',
            'method' => 'applyFilter',
            'style' => 'text-align: right',
            'class' => 'btn btn-primary',
        ]);

        $this->addFilterButton('1', [
            'label' => 'Reset Filter',
            'method' => 'resetFilter',
            'style' => 'text-align: left',
            'class' => 'btn btn-danger',
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
        $filter = \Mage::getModel('Model\Admin\Filter');
        $values = $filter->getFilter('shipping');

        $this->addfilter('method', [
            'name' => 'filter[shipping][methodId]',
            'style' => 'width:50px',
            'value' => $values['methodId'],
            'placeholder' => 'Id',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('name', [
            'name' => 'filter[shipping][name]',
            'style' => 'width:200px',
            'value' => $values['name'],
            'placeholder' => 'Name',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('code', [
            'name' => 'filter[shipping][code]',
            'style' => 'width:70px',
            'value' => $values['code'],
            'placeholder' => 'Code',
            'class' => 'clear form-control',
        ]);

        $this->addfilter('amount', [
            'name' => 'filter[shipping][amount]',
            'style' => 'width:90px',
            'value' => $values['amount'],
            'placeholder' => 'Amount',
            'class' => 'clear form-control',
        ]);

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

    public function prepareButtons()
    {
        $this->addButton('newShipping', [
            'label' => 'Add New Shipping',
            'method' => 'getNewUrl',
            'class' => 'btn btn-info',
        ]);

        $this->addButton('remove', [
            'label' => 'Remove Selected',
            'method' => 'removeShippings',
            'class' => 'btn btn-danger',
        ]);
    }

    public function preparePrimaryColumn()
    {
        $this->addPrimaryColumn('primaryColumn', [
            'field' => 'methodId',
            'label' => 'Method Id',
            'type' => 'int',
        ]);
    }

    public function prepareColumns()
    {
        $this->addColumn('methodId', [
            'field' => 'methodId',
            'label' => 'Method Id',
            'type' => 'int',
        ]);

        $this->addColumn('name', [
            'field' => 'name',
            'label' => 'Name',
            'type' => 'varchar',
        ]);

        $this->addColumn('code', [
            'field' => 'code',
            'label' => 'Code',
            'type' => 'varchar',
        ]);

        $this->addColumn('amount', [
            'field' => 'amount',
            'label' => 'Amount',
            'type' => 'decimal',
        ]);

        $this->addColumn('status', [
            'field' => 'status',
            'label' => 'Status',
            'type' => 'int',
        ]);
    }

    public function prepareActions()
    {
        $this->addAction('edit', [
            'label' => 'Edit',
            'method' => 'getFormUrl',
            'class' => 'btn btn-info',
        ]);

        $this->addAction('delete', [
            'label' => 'Delete',
            'method' => 'getDeleteUrl',
            'class' => 'btn btn-danger',
        ]);

    }

    public function getNewUrl()
    {
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_shipping')}').resetParams().load()";
    }

    public function removeShippings()
    {
        return "removeData(this); object.resetParams().setForm('#gridForm').load();";
    }

    public function getStatusUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('status', 'admin_shipping', ['id' => $row->methodId])}').resetParams().load()";

    }

    public function getFormUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_shipping', ['id' => $row->methodId])}').resetParams().load()";
    }

    public function getDeleteUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('delete', 'admin_shipping', ['id' => $row->methodId])}').resetParams().load()";
    }

    public function applyFilter()
    {
        return "applyData(this); object.resetParams().setForm('#gridForm').load();";
    }

    public function resetFilter()
    {
        return "resetData(this); object.resetParams().setForm('#gridForm').load();";
    }

}
