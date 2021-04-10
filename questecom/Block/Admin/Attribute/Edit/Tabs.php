<?php

namespace Block\Admin\Attribute\Edit;

\Mage::loadFileByClassName('Block\Core\Edit\Tabs');

class Tabs extends \Block\Core\Edit\Tabs
{
    public function prepareTab()
    {
        $this->setDefaultTab('attribute');

        $this->addTab('attribute', ['key' => 'attribute', 'class' => 'btn btn-info', 'label' => 'Attribute Form', 'block' => 'Block\Admin\Attribute\Edit\Tabs\Form']);
        $this->addTab('attributeOption', ['key' => 'attributeOption', 'class' => 'btn btn-info', 'label' => 'Attribute Option', 'block' => 'Block\Admin\Attribute\Edit\Tabs\AttributeOption']);

        return $this;
    }

}
