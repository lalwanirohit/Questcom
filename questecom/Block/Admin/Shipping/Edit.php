<?php

namespace Block\Admin\Shipping;

\Mage::loadFileByClassName('Block\Core\Edit');

class Edit extends \Block\Core\Edit
{
    protected $shipping;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/shipping/editshipping.php');
    }

}
