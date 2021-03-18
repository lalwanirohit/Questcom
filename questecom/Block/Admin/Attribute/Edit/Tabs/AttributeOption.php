<?php

namespace Block\Admin\Attribute\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class AttributeOption extends \Block\Core\Edit
{
    protected $attribute;
    protected $attributeOptions;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/attribute/edit/tabs/attributeoption.php');
    }

    public function setAttribute($attribute = null)
    {

        if (!$attribute) {
            $attributeId = $this->getTableRow()->attributeId;
        }

        $model = \Mage::getModel('Model\Attribute\Option');
        $query = "SELECT * FROM `{$model->getTableName()}` WHERE `attributeId` = '$attributeId' ORDER BY `sortOrder` ASC";
        // $query = "SELECT * FROM `attribute_option` WHERE `attributeId` = $attributeId";
        $collection = $model->all($query);
        $this->attribute = $collection;
        return $this;
    }

    public function getAttribute()
    {
        if (!$this->attribute) {
            $this->setAttribute();
        }
        return $this->attribute;
    }
}
