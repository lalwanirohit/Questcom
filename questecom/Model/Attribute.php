<?php

namespace Model;

\Mage::loadFileByClassName('Model\Core\Table');

class Attribute extends Core\Table
{
    public function __construct()
    {
        $this->setPrimaryKey('attributeId');
        $this->setTableName('attribute');
    }

    public function getEntityTypeOptions()
    {
        return [
            'product' => 'product',
            'category' => 'category',
        ];
    }

    public function getInputTypeOptions()
    {
        return [
            'email' => 'email',
            'search' => 'search',
            'tel' => 'tel',
            'url' => 'url',
            'number' => 'number',
            'range' => 'range',
            'text' => 'text',
            'radio' => 'radio',
            'checkbox' => 'checkbox',
            'select' => 'select',
            'multi-select' => 'multi-select',
            'password' => 'password',
        ];
    }

    public function getBackendTypeOptions()
    {
        return [
            'int(7)' => 'int',
            'varchar(50)' => 'varchar',
        ];
    }
}
