<?php

namespace Block\Admin\Customer\Group;

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
        $group = \Mage::getModel('Model\Customer\Group');
        $filter = \Mage::getModel('Model\Admin\Filter');
        if ($filterValue = $filter->getFilter('customer_group')) {
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
            $query = "SELECT * FROM `{$group->getTableName()}` $projection";
            $rows = $group->all($query);
            $this->setCollection($rows);
        } else {
            $rows = $group->all();
            $this->setCollection($rows);
        }
    }

    public function setTitle()
    {
        return "Customer Groups";
    }

    public function keepController()
    {
        return "admin_customer_group";
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
        $values = $filter->getFilter('customer_group');

        $this->addfilter('groupId', [
            'name' => 'filter[customer_group][groupId]',
            'style' => 'width:50px',
            'value' => $values['groupId'],
            'placeholder' => 'Id',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('name', [
            'name' => 'filter[customer_group][name]',
            'style' => 'width:170px',
            'value' => $values['name'],
            'placeholder' => 'Name',
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
        $this->addButton('newCustomerGroup', [
            'label' => 'Add New Customer Group',
            'method' => 'getNewUrl',
            'ajax' => true,
            'class' => 'btn btn-info',
        ]);

        $this->addButton('remove', [
            'label' => 'Remove Selected',
            'method' => 'removeCustomerGroups',
            'ajax' => true,
            'class' => 'btn btn-danger',
        ]);
    }

    public function preparePrimaryColumn()
    {
        $this->addPrimaryColumn('primaryColumn', [
            'field' => 'groupId',
            'label' => 'Group Id',
            'type' => 'int',
        ]);
    }

    public function prepareColumns()
    {
        $this->addColumn('groupId', [
            'field' => 'groupId',
            'label' => 'Group Id',
            'type' => 'int',
        ]);

        $this->addColumn('name', [
            'field' => 'name',
            'label' => 'Name',
            'type' => 'varchar',
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
            'ajax' => true,
            'class' => 'btn btn-info',
        ]);

        $this->addAction('delete', [
            'label' => 'Delete',
            'method' => 'getDeleteUrl',
            'ajax' => true,
            'class' => 'btn btn-danger',
        ]);

    }

    public function getNewUrl($ajax)
    {
        if (!$ajax) {
            return "{$this->getUrl()->getUrl('form', 'admin_customer_group')}";
        }
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_customer_group')}').resetParams().load()";
    }

    public function removeCustomerGroups($ajax)
    {
        if (!$ajax) {
            return "{$this->getUrl()->getUrl('remove', 'admin_customer_group')}";
        }
        return "removeData(this); object.resetParams().setForm('#gridForm').load();";
    }

    public function getStatusUrl($row, $ajax)
    {
        if (!$ajax) {
            return "{$this->getUrl()->getUrl('status', 'admin_customer_group', ['id' => $row->groupId])}";
        }
        return "object.setUrl('{$this->getUrl()->getUrl('status', 'admin_customer_group', ['id' => $row->groupId])}').resetParams().load()";

    }

    public function getFormUrl($row, $ajax)
    {
        if (!$ajax) {
            return "{$this->getUrl()->getUrl('form', 'admin_customer_group', ['id' => $row->groupId])}";
        }
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_customer_group', ['id' => $row->groupId])}').resetParams().load()";
    }

    public function getDeleteUrl($row, $ajax)
    {
        if (!$ajax) {
            return "{$this->getUrl()->getUrl('delete', 'admin_customer_group', ['id' => $row->groupId])}";
        }
        return "object.setUrl('{$this->getUrl()->getUrl('delete', 'admin_customer_group', ['id' => $row->groupId])}').resetParams().load()";
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
