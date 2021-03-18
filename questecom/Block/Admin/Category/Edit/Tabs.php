<?php

namespace Block\Admin\Category\Edit;

\Mage::loadFileByClassName('Block\Core\Edit\Tabs');

class Tabs extends \Block\Core\Edit\Tabs
{
    public function prepareTab()
    {
        $this->setDefaultTab('categoryForm');

        $this->addTab('categoryForm', ['label' => 'Category Form', 'block' => 'Block\Admin\Category\Edit\Tabs\Form']);
        $this->addTab('categoryTree', ['label' => 'Category Attribute', 'block' => 'Block\Admin\Category\Edit\Tabs\Attribute']);
        $this->addTab('categoryMedia', ['label' => 'Category Media', 'block' => 'Block\Admin\Category\Edit\Tabs\Media']);

        return $this;
    }

}
