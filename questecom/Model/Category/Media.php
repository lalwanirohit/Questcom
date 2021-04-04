<?php

namespace Model\Category;

\Mage::loadFileByClassName('Model\Core\Table');
/**
 *
 */
class Media extends \Model\Core\Table
{
    public function __construct()
    {
        $this->setPrimaryKey('mediaId');
        $this->setTableName('category_media');
    }

}
