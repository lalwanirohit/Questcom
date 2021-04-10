<?php

namespace Block\Admin\Admin\Edit;

\Mage::loadFileByClassName('Block\Core\Edit\Tabs');

class Tabs extends \Block\Core\Edit\Tabs
{
    public function prepareTab()
    {
        $this->setDefaultTab('information');

        $this->addTab('information', ['key' => 'information', 'class' => 'btn btn-info', 'label' => 'Admin Information', 'block' => 'Block\Admin\Admin\Edit\Tabs\Information']);

        return $this;
    }
}
