<?php

namespace Block\Admin\Category\Edit;

\Mage::loadFileByClassName('Block\Core\Edit\Tabs');

class Tabs extends \Block\Core\Edit\Tabs
{
    public function prepareTab()
    {
        $this->setDefaultTab('categoryForm');

        $this->addTab('categoryForm', ['class' => 'btn btn-info', 'label' => 'Category Form', 'block' => 'Block\Admin\Category\Edit\Tabs\Form']);
        $this->addTab('categoryTree', ['class' => 'btn btn-info', 'label' => 'Category Attribute', 'block' => 'Block\Admin\Category\Edit\Tabs\Attribute']);
        $this->addTab('categoryMedia', ['class' => 'btn btn-info', 'label' => 'Category Media', 'block' => 'Block\Admin\Category\Edit\Tabs\Media']);

        return $this;
    }

}
