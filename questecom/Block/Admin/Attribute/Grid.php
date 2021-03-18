<?php

namespace Block\Admin\Attribute;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends \BLock\Core\Template
{
    protected $attributes;

    public function __construct()
    {
        $this->setTemplate('View/admin/attribute/gridattribute.php');
    }

    protected function setAttributes($attributes = null)
    {
        if ($this->attributes) {
            $this->attributes = $attributes;
        }
        if (!$attributes) {
            $attributes = \Mage::getModel('Model\Attribute');
            $collection = $attributes->all();
            $this->attributes = $collection;
        }
        return $this;
    }

    public function getAttributes()
    {
        if (!$this->attributes) {
            $this->setAttributes();
        }
        return $this->attributes;
    }
}
