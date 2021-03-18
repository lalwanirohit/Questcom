<?php

namespace Block\Admin\Attribute\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class Form extends \Block\Core\Edit
{
    protected $attribute;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/attribute/edit/tabs/form.php');
    }

}
