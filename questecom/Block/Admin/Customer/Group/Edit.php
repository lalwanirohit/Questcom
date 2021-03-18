<?php

namespace Block\Admin\Customer\Group;

\Mage::loadFileByClassName('Block\Core\Edit');

class Edit extends \Block\Core\Edit
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/customergroup/editcustomergroup.php');
    }
}
