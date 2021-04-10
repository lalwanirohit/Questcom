<?php

namespace Block\Admin\Brand;

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
        $brand = \Mage::getModel('Model\Brand');
        $filter = \Mage::getModel('Model\Admin\Filter');
        if ($filterValue = $filter->getFilter('brand')) {
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
            $query = "SELECT * FROM `{$brand->getTableName()}` $projection";
            $rows = $brand->all($query);
            $this->setCollection($rows);
        } else {
            $rows = $brand->all();
            $this->setCollection($rows);
        }
    }

    public function setTitle()
    {
        return "Brands";
    }

    public function keepController()
    {
        return "admin_brand";
    }

    public function prepareFilterButton()
    {
        $this->addFilterButton('0', [
            'label' => 'Apply Filter',
            'method' => 'applyFilter',
            'style' => 'text-align: right;',
            'class' => 'btn btn-info',
        ]);

        $this->addFilterButton('1', [
            'label' => 'Reset Filter',
            'method' => 'resetFilter',
            'style' => 'text-align: left;',
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
        $values = $filter->getFilter('brand');

        $this->addfilter('method', [
            'name' => 'filter[brand][brandId]',
            'style' => 'width:50px',
            'value' => $values['brandId'],
            'placeholder' => 'Id',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('userName', [
            'name' => 'filter[brand][brandName]',
            'style' => 'width:170px',
            'value' => $values['brandName'],
            'placeholder' => 'Brand Name',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('status', [
            'name' => 'filter[brand][status]',
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
        $this->addButton('newBrand', [
            'label' => 'Add New Brand',
            'method' => 'getNewUrl',
            'class' => 'btn btn-info',
        ]);

        $this->addButton('remove', [
            'label' => 'Remove Selected',
            'method' => 'removeBrands',
            'class' => 'btn btn-danger',
        ]);
    }

    public function preparePrimaryColumn()
    {
        $this->addPrimaryColumn('primaryColumn', [
            'field' => 'brandId',
            'label' => 'Brand Id',
            'type' => 'int',
        ]);
    }

    public function prepareColumns()
    {
        $this->addColumn('brandId', [
            'field' => 'brandId',
            'label' => 'Brand Id',
            'type' => 'int',
        ]);

        $this->addColumn('brandName', [
            'field' => 'brandName',
            'label' => 'Brand Name',
            'type' => 'varchar',
        ]);

        $this->addColumn('status', [
            'field' => 'status',
            'label' => 'Brand Status',
            'type' => 'int',
        ]);

        $this->addColumn('brandImage', [
            'field' => 'brandImage',
            'label' => 'Brand Image',
            'type' => 'varchar',
        ]);

        $this->addColumn('createdAt', [
            'field' => 'createdAt',
            'label' => 'Created At',
            'type' => 'varchar',
        ]);
    }
    public function prepareActions()
    {
        $this->addAction('edit', [
            'label' => 'Edit',
            'method' => 'getFormUrl',
            'style' => 'color: white',
            'class' => 'btn btn-info',
        ]);

        $this->addAction('delete', [
            'label' => 'Delete',
            'method' => 'getDeleteUrl',
            'style' => 'color: white;',
            'class' => 'btn btn-danger',
        ]);

    }

    public function getNewUrl()
    {
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_brand')}').resetParams().load()";
    }

    public function removeBrands()
    {
        return "removeData(this); object.resetParams().setForm('#gridForm').load();";
    }

    public function getStatusUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('status', 'admin_brand', ['id' => $row->brandId])}').resetParams().load()";

    }

    public function getFormUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_brand', ['id' => $row->brandId])}').resetParams().load()";
    }

    public function getDeleteUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('delete', 'admin_brand', ['id' => $row->brandId])}').resetParams().load()";
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
