<?php

namespace Controller\Admin\Attribute;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Option extends \Controller\Core\Admin
{
    public function saveAction()
    {
        $attributeOption = \Mage::getModel('Model\Attribute\Option');
        $attributeId = $this->getRequest()->getGet('id');
        $existData = $this->getRequest()->getPost('exist');
        if ($existData) {
            $deleteId = [];
            foreach ($existData as $key => $value) {
                $deleteId[] = $key;
            }
            $deleteId = implode(",", $deleteId);
            $query = "DELETE FROM `{$attributeOption->getTableName()}` WHERE  `{$attributeOption->getPrimaryKey()}` NOT IN ({$deleteId}) AND `attributeId`=$attributeId";
            $attributeOption->getAdapter()->delete($query);
        }

        foreach ($existData as $optionId => $option) {
            $attributeOption = \Mage::getModel('Model\Attribute\Option');
            $query = "SELECT * FROM `{$attributeOption->getTableName()}` WHERE `attributeId` = '{$attributeId}' AND `{$attributeOption->getPrimaryKey()}` = '{$optionId}';";
            $attributeOption->load(null, $query);
            $attributeOption->name = $option['name'];
            $attributeOption->sortOrder = $option['sortOrder'];
            $attributeOption = $attributeOption->Save();
            if ($attributeOption) {
                $this->getMessage()->setSuccess("Options Update Successfully..");
            }
        }

        if ($newData = $this->getRequest()->getPost('new')) {
            if ($id = $this->getRequest()->getGet('id')) {
                for ($i = 0; $i < count($newData); $i = $i + 2) {
                    $attributeOption = \Mage::getModel('Model\Attribute\Option');
                    $nextAddr = $i + 1;
                    $query = "INSERT INTO `{$attributeOption->getTableName()}` (`name`,`attributeId`,`sortOrder`) VALUES ('$newData[$i]','$id','$newData[$nextAddr]')";
                    $attributeOption->getAdapter()->insert($query);
                }
            }
        }
        $this->redirect('form', 'admin_attribute', ["tab" => "attributeOption"], false);
    }
}
