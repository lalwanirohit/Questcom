<?php

namespace Block\Admin\Customer\Edit;

\Mage::loadFileByClassName('Block\Core\Edit\Tabs');

class Tabs extends \Block\Core\Edit\Tabs
{
    public function prepareTab()
    {
        $this->setDefaultTab('customer');

        $this->addTab('customer', ['class' => 'btn btn-info', 'label' => 'Customer Information', 'block' => 'Block\Admin\Customer\Edit\Tabs\Form']);
        $this->addTab('address', ['class' => 'btn btn-info', 'label' => 'Addresses', 'block' => 'Block\Admin\Customer\Edit\Tabs\Address']);

        return $this;
    }

}
