<?php

namespace Block\Admin\Attribute;

\Mage::loadFileByClassName('Block\Core\Grid');

class Grid extends \Block\Core\Grid
{

    public function prepareCollection()
    {
        $attributes = \Mage::getModel('Model\Attribute');
        $filter = \Mage::getModel('Model\Admin\Filter');
        if ($filterValue = $filter->getFilter('attribute')) {
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
        return "Attributes";
    }

    public function keepController()
    {
        return "admin_attribute";
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
        $values = $filter->getFilter('attribute');

        $this->addfilter('attributeId', [
            'name' => 'filter[attribute][attributeId]',
            'style' => 'width:50px',
            'value' => $values['attributeId'],
            'placeholder' => 'Id',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('entityTypeId', [
            'name' => 'filter[attribute][entityTypeId]',
            'style' => 'width:90px',
            'value' => $values['entityTypeId'],
            'placeholder' => 'Entity Type Id',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('name', [
            'name' => 'filter[attribute][name]',
            'style' => 'width:70px',
            'value' => $values['name'],
            'placeholder' => 'Name',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('code', [
            'name' => 'filter[attribute][code]',
            'style' => 'width:70px',
            'value' => $values['code'],
            'placeholder' => 'Code',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('inputType', [
            'name' => 'filter[attribute][inputType]',
            'style' => 'width:90px',
            'value' => $values['inputType'],
            'placeholder' => 'Input Type',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('backendType', [
            'name' => 'filter[attribute][backendType]',
            'style' => 'width:110px',
            'value' => $values['backendType'],
            'placeholder' => 'Backend Type',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('sortOrder', [
            'name' => 'filter[attribute][sortOrder]',
            'style' => 'width:80px',
            'value' => $values['sortOrder'],
            'placeholder' => 'Sort Order',
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
        $this->addButton('newAttribute', [
            'label' => 'Add New Attribute',
            'method' => 'getNewUrl',
            'class' => 'btn btn-info',
        ]);

        $this->addButton('remove', [
            'label' => 'Remove Selected',
            'method' => 'removeAttributes',
            'class' => 'btn btn-danger',
        ]);
    }

    public function preparePrimaryColumn()
    {
        $this->addPrimaryColumn('primaryColumn', [
            'field' => 'attributeId',
            'label' => 'Attribute Id',
            'type' => 'int',
        ]);
    }

    public function prepareColumns()
    {
        $this->addColumn('attributeId', [
            'field' => 'attributeId',
            'label' => 'Attribute Id',
            'type' => 'int',
        ]);

        $this->addColumn('entityTypeId', [
            'field' => 'entityTypeId',
            'label' => 'Entity Type Id',
            'type' => 'varchar',
        ]);

        $this->addColumn('name', [
            'field' => 'name',
            'label' => 'Attribute Name',
            'type' => 'varchar',
        ]);

        $this->addColumn('code', [
            'field' => 'code',
            'label' => 'Attribute Code',
            'type' => 'varchar',
        ]);

        $this->addColumn('inputType', [
            'field' => 'inputType',
            'label' => 'Input Type',
            'type' => 'varchar',
        ]);

        $this->addColumn('backendType', [
            'field' => 'backendType',
            'label' => 'Backend Type',
            'type' => 'varchar',
        ]);

        $this->addColumn('sortOrder', [
            'field' => 'sortOrder',
            'label' => 'Sort Order',
            'type' => 'int',
        ]);

        $this->addColumn('backendModel', [
            'field' => 'backendModel',
            'label' => 'Backend Model',
            'type' => 'varchar',
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
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_attribute')}').resetParams().load()";
    }

    public function removeAttributes()
    {
        return "removeData(this); object.resetParams().setForm('#gridForm').load();";
    }

    public function getFormUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_attribute', ['id' => $row->attributeId])}').resetParams().load()";
    }

    public function getDeleteUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('delete', 'admin_attribute', ['id' => $row->attributeId])}').resetParams().load()";
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
