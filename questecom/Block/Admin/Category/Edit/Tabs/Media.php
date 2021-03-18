<?php

namespace Block\Admin\Category\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class Media extends \Block\Core\Edit
{

    public function __construct()
    {
        $this->setTemplate('View/admin/category/edit/tabs/media.php');
    }

}
