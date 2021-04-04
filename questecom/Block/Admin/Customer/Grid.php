<?php

namespace Block\Admin\Customer;

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

        $customer = \Mage::getModel('Model\Customer');
        $filter = \Mage::getModel('Model\Admin\Filter');
        if ($filterValue = $filter->getFilter('customer')) {
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
            $query = "SELECT * FROM `{$customer->getTableName()}` $projection";
            $rows = $customer->all($query);
            $this->setCollection($rows);
        } else {
            $rows = $customer->all();
            $this->setCollection($rows);
        }
    }

    public function setTitle()
    {
        return "Customers";
    }

    public function keepController()
    {
        return "admin_customer";
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
        $values = $filter->getFilter('customer');

        $this->addfilter('customerId', [
            'name' => 'filter[customer][customerId]',
            'style' => 'width:50px',
            'value' => $values['customerId'],
            'placeholder' => 'Id',
            'class' => 'clear form-control',
        ]);

        $this->addfilter('groupId', [
            'name' => 'filter[customer][groupId]',
            'style' => 'width:50px',
            'value' => $values['groupId'],
            'placeholder' => 'Group Id',
            'class' => 'clear form-control',
        ]);

        $this->addfilter('firstName', [
            'name' => 'filter[customer][firstName]',
            'style' => 'width:70px',
            'value' => $values['firstName'],
            'placeholder' => 'first name',
            'class' => 'clear form-control',
        ]);

        $this->addfilter('lastName', [
            'name' => 'filter[customer][lastName]',
            'style' => 'width:70px',
            'value' => $values['lastName'],
            'placeholder' => 'lastname',
            'class' => 'clear form-control',
        ]);

        $this->addfilter('email', [
            'name' => 'filter[customer][email]',
            'style' => 'width:150px',
            'value' => $values['email'],
            'placeholder' => 'email',
            'class' => 'clear form-control',
        ]);

        $this->addfilter('mobile', [
            'name' => 'filter[customer][mobile]',
            'style' => 'width:100px',
            'value' => $values['mobile'],
            'placeholder' => 'mobile',
            'class' => 'clear form-control',
        ]);

        $this->addfilter('status', [
            'name' => 'filter[customer][status]',
            'style' => 'width:70px',
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
        $this->addButton('newCustomer', [
            'label' => 'Add New Customer',
            'method' => 'getNewUrl',
            'class' => 'btn btn-info',
        ]);

        $this->addButton('remove', [
            'label' => 'Remove Selected',
            'method' => 'removeCustomers',
            'class' => 'btn btn-danger',
        ]);
    }

    public function preparePrimaryColumn()
    {
        $this->addPrimaryColumn('primaryColumn', [
            'field' => 'customerId',
            'label' => 'Customer Id',
            'type' => 'int',
        ]);
    }

    public function prepareColumns()
    {
        $this->addColumn('customerId', [
            'field' => 'customerId',
            'label' => 'Customer Id',
            'type' => 'int',
        ]);

        $this->addColumn('groupid', [
            'field' => 'groupId',
            'label' => 'Group id',
            'type' => 'varchar',
        ]);

        $this->addColumn('firstName', [
            'field' => 'firstName',
            'label' => 'First Name',
            'type' => 'varchar',
        ]);

        $this->addColumn('lastName', [
            'field' => 'lastName',
            'label' => 'Last Name',
            'type' => 'varchar',
        ]);

        $this->addColumn('email', [
            'field' => 'email',
            'label' => 'Email',
            'type' => 'varchar',
        ]);

        $this->addColumn('mobile', [
            'field' => 'mobile',
            'label' => 'Mobile',
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
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_customer')}').resetParams().load()";
    }

    public function removeCustomers()
    {
        return "removeData(this); object.resetParams().setForm('#gridForm').load();";
    }

    public function getStatusUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('status', 'admin_customer', ['id' => $row->customerId])}').resetParams().load()";

    }

    public function getFormUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_customer', ['id' => $row->customerId])}').resetParams().load()";
    }

    public function getDeleteUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('delete', 'admin_customer', ['id' => $row->customerId])}').resetParams().load()";
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
