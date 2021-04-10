<?php

namespace Block\Admin\Product;

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
        $pager = \Mage::getController('Controller\Core\Pager');
        $product = \Mage::getModel('Model\Product');
        $rows = $product->all();
        $total = $rows->count();

        $pager->setTotalRecords($total);
        $pager->setRecordsPerPage(4);
        $pager->setCurrentPage($this->getRequest()->getGet('page', 1));
        $startFrom = ($pager->getCurrentPage() - 1) * $pager->getRecordsPerPage();
        $pager->calculate();
        $this->setPager($pager);

        $filter = \Mage::getModel('Model\Admin\Filter');

        if ($filterValue = $filter->getFilter('product')) {
            $filedName = array_keys($filterValue);
            $values = array_values($filterValue);
            $projection = 'WHERE ';
            foreach ($filedName as $key => $value) {
                if ($values[$key]) {
                    $projection .= "`$filedName[$key]` like '%{$values[$key]}%' AND ";
                }
            }
            if ($projection) {
                $projection = rtrim($projection, ',');
                $words = explode(" ", $projection);
                array_splice($words, -2);
                $projection = implode(" ", $words);
            }
            if ($projection) {
                $query = "select p.*,b.brandName from product p join product_brand b on p.brandId=b.brandId $projection";
            } else {
                $projection = '';
                $query = "select p.*,b.brandName from product p join product_brand b on p.brandId=b.brandId $projection";
            }

            $rows = $product->all($query);
            $count = $rows->count();
            $pager->setTotalRecords($count);
            $startFrom = ($pager->getCurrentPage() - 1) * $pager->getRecordsPerPage();
            $pager->calculate();
            $query = "select p.*,b.brandName from product p join product_brand b on p.brandId=b.brandId $projection LIMIT $startFrom,{$pager->getRecordsPerPage()}";
            $row = $product->all($query);
            $this->setCollection($row);
        } else {
            $query = "select p.*,b.brandName from product p join product_brand b on p.brandId=b.brandId LIMIT $startFrom,{$pager->getRecordsPerPage()}";
            $rows = $product->all($query);
            $this->setCollection($rows);
        }
    }

    public function setTitle()
    {
        return "Products";
    }

    public function keepController()
    {
        return "admin_product";
    }

    public function prepareFilterButton()
    {
        $this->addFilterButton('0', [
            'label' => 'Apply Filter',
            'method' => 'applyFilter',
            'style' => 'text-align: right',
            'class' => 'btn btn-info',
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
        $values = $filter->getFilter('product');

        $this->addfilter('method', [
            'name' => 'filter[product][productId]',
            'style' => 'width:50px',
            'value' => $values['productId'],
            'placeholder' => 'Id',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('brandName', [
            'name' => 'filter[product][brandName]',
            'style' => 'width:170px',
            'value' => $values['brandName'],
            'placeholder' => 'Brand',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('name', [
            'name' => 'filter[product][name]',
            'style' => 'width:170px',
            'value' => $values['name'],
            'placeholder' => 'Name',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('price', [
            'name' => 'filter[product][price]',
            'style' => 'width:70px',
            'value' => $values['price'],
            'placeholder' => 'Price',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('discount', [
            'name' => 'filter[product][discount]',
            'style' => 'width:100px',
            'value' => $values['discount'],
            'placeholder' => 'Discount',
            'class' => 'clear form-control',
        ]);
        $this->addfilter('Quantity', [
            'name' => 'filter[product][quantity]',
            'style' => 'width:100px',
            'value' => $values['quantity'],
            'placeholder' => 'Quantity',
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
        $this->addButton('newProduct', [
            'label' => 'Add New Product',
            'method' => 'getNewUrl',
            'class' => 'btn btn-info',
        ]);

        $this->addButton('remove', [
            'label' => 'Remove Selected',
            'method' => 'removeProducts',
            'class' => 'btn btn-danger',
        ]);
    }

    public function preparePrimaryColumn()
    {
        $this->addPrimaryColumn('primaryColumn', [
            'field' => 'productId',
            'label' => 'Product Id',
            'type' => 'int',
        ]);
    }

    public function prepareColumns()
    {
        $this->addColumn('productId', [
            'field' => 'productId',
            'label' => 'Product Id',
            'type' => 'int',
        ]);

        $this->addColumn('brandName', [
            'field' => 'brandName',
            'label' => 'Brand Name',
            'type' => 'varchar',
        ]);

        $this->addColumn('name', [
            'field' => 'name',
            'label' => 'Product Name',
            'type' => 'varchar',
        ]);

        $this->addColumn('price', [
            'field' => 'price',
            'label' => 'Product Price',
            'type' => 'decimal',
        ]);

        $this->addColumn('discount', [
            'field' => 'discount',
            'label' => 'Discount',
            'type' => 'decimal',
        ]);

        $this->addColumn('quantity', [
            'field' => 'quantity',
            'label' => 'Quantity',
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

        $this->addAction('addToCart', [
            'label' => 'Add To Cart',
            'method' => 'getAddToCartUrl',
            'class' => 'btn btn-info',
        ]);
    }

    public function getNewUrl()
    {
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_product')}').resetParams().load()";
    }

    public function removeProducts()
    {
        return "removeData(this); object.resetParams().setForm('#gridForm').load();";
    }

    public function getStatusUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('status', 'admin_product', ['id' => $row->productId])}').resetParams().load()";
    }

    public function getFormUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('form', 'admin_product', ['id' => $row->productId])}').resetParams().load()";
    }

    public function getDeleteUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('delete', 'admin_product', ['id' => $row->productId])}').resetParams().load()";
    }

    public function getAddToCartUrl($row)
    {
        return "object.setUrl('{$this->getUrl()->getUrl('addToCart', 'admin_cart', ['id' => $row->productId])}').resetParams().load()";
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
