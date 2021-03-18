<?php

namespace Block\Admin\Product\Edit;

\Mage::loadFileByClassName('Block\Core\Edit\Tabs');

class Tabs extends \Block\Core\Edit\Tabs
{
    public function prepareTab()
    {
        $this->setDefaultTab('product');

        $this->addTab('product', ['key' => 'product', 'label' => 'Product Form', 'block' => 'Block\Admin\Product\Edit\Tabs\Form']);
        $this->addTab('media', ['key' => 'media', 'label' => 'Product Media', 'block' => 'Block\Admin\Product\Edit\Tabs\Media']);
        $this->addTab('categorytree', ['key' => 'categorytree', 'label' => 'Product Attributes', 'block' => 'Block\Admin\Product\Edit\Tabs\Attribute']);
        $this->addTab('groupPrice', ['key' => 'groupPrice', 'label' => 'Product Group Price', 'block' => 'Block\Admin\Product\Edit\Tabs\GroupPrice']);

        return $this;
    }
}
