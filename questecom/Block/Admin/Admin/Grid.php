<?php

namespace Block\Admin\Admin;

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
        $attributes = \Mage::getModel('Model\Admin');
        $filter = \Mage::getModel('Model\Admin\Filter');
        if ($filterValue = $filter->getFilter('admins')) {
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
            $query = "SELECT * FROM `{$attributes->getTableName()}` $projection";
            $rows = $attributes->all($query);
            $this->setCollection($rows);
        } else {
            $rows = $attributes->all();
            $this->setCollection($rows);
        }
    }

    public function setTitle()
    {
        return "Admins";
    }

    public function keepController()
    {
        return "admin_admin";
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
        $values = $filter->getFilter('admins');

        $this->addfilter('method', [
            'name' => 'filter[admin][adminId]',
            'style' => 'width:50px',
            'value' => $values['adminId'],
            'placeholder' => 'Id',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('userName', [
            'name' => 'filter[admin][userName]',
            'style' => 'width:170px',
            'value' => $values['userName'],
            'placeholder' => 'User Name',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('status', [
            'name' => 'filter[admin][status]',
            'style' => 'width:170px',
            'value' => $values['status'],
            'placeholder' => 'status',
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
        $this->addButton('newAdmin', [
            'label' => 'Add New Admin',
            'method' => 'getNewUrl',
            'class' => 'btn btn-info',
        ]);

        $this->addButton('remove', [
            'label' => 'Remove Selected',
            'method' => 'removeAdmins',
            'class' => 'btn btn-danger',
        ]);
    }

    public function preparePrimaryColumn()
    {
        $this->addPrimaryColumn('primaryColumn', [
            'field' => 'adminId',
            'label' => 'Admin Id',
            'type' => 'int',
        ]);
    }

    public function prepareColumns()
    {
        $this->addColumn('adminId', [
            'field' => 'adminId',
            'label' => 'Admin Id',
            'type' => 'int',
        ]);

        $this->addColumn('userName', [
            'field' => 'userName',
            'label' => 'Admin Name',
            'type' => 'varchar',
        ]);

        $this->addColumn('status', [
            'field' => 'status',
            'label' => 'Admin Status',
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
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_admin')}').resetParams().load()";
    }

    public function removeAdmins()
    {
        return "removeData(this); object.resetParams().setForm('#gridForm').load();";
    }

    public function getStatusUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('status', 'admin_admin', ['id' => $row->adminId])}').resetParams().load()";
    }

    public function getFormUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_admin', ['id' => $row->adminId])}').resetParams().load()";
    }

    public function getDeleteUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('delete', 'admin_admin', ['id' => $row->adminId])}').resetParams().load()";
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
