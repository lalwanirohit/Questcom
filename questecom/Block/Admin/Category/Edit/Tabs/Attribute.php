<?php

namespace Block\Admin\Category\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class Attribute extends \Block\Core\Edit
{
    protected $options = null;
    protected $attribute = null;

    public function __construct()
    {
        $this->setTemplate('View/admin/category/edit/tabs/attribute.php');
    }

    public function setOptions($options = null)
    {
        if ($options) {
            $this->options = $options;
            return $this;
        }
        $options = \Mage::getModel('Model\Attribute\Option');
        $query = "SELECT * FROM `{$options->getTableName()}` ORDER BY `attributeId` ASC";
        $options = $options->all($query);
        $this->options = $options;
        return $this;
    }

    public function getOptions()
    {
        if (!$this->options) {
            $this->setOptions();
        }
        return $this->options;
    }

    public function setAttribute($attribute = null)
    {
        if ($attribute) {
            $this->attribute = $attribute;
            return $this;
        }
        $attribute = \Mage::getModel('Model\Attribute');
        $query = "SELECT * FROM `{$attribute->getTableName()}` WHERE entityTypeId='category' ORDER BY `sortOrder` ASC";
        $attribute = $attribute->all($query);
        $this->attribute = $attribute;
        return $this;
    }

    public function getAttribute()
    {
        if (!$this->attribute) {
            $this->setattribute();
        }
        return $this->attribute;
    }

}
