<?php

namespace Model;

\Mage::loadFileByClassName('Model\Core\Table');

class Brand extends Core\Table
{
    const STATUS_ENABLE = 1;
    const STATUS_DESABLED = 0;
    public function __construct()
    {
        $this->setPrimaryKey('brandId');
        $this->setTableName('product_brand');
    }
    public function getStatusOptions()
    {
        return [
            self::STATUS_DESABLED => "Disable",
            self::STATUS_ENABLE => "Enable",
        ];
    }
}
