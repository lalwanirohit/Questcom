<?php

namespace Block\Admin\Product\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class Form extends \Block\Core\Edit
{
    protected $brands;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/product/edit/tabs/form.php');
    }

    protected function setBrands($brands = null)
    {
        if ($this->brands) {
            $this->brands = $brands;
        }
        if (!$brands) {
            $group = \Mage::getModel('Model\Brand');
            $collection = $group->all();
            $this->brands = $collection;
        }
        return $this;
    }

    public function getBrands()
    {
        if (!$this->brands) {
            $this->setBrands();
        }
        return $this->brands;
    }
}
