<?php

namespace Block\Admin\Shipping;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends \Block\Core\Template
{
    protected $shippings;

    public function __construct()
    {
        $this->setTemplate('View/admin/shipping/gridshipping.php');
    }

    protected function setShippings($shippings = null)
    {
        if ($this->shippings) {
            $this->shippings = $shippings;
        }
        if (!$shippings) {
            $shipping = \Mage::getModel('Model\Shipping');
            $collection = $shipping->all();
            $this->shippings = $collection;
        }
        return $this;
    }

    public function getShippings()
    {
        if (!$this->shippings) {
            $this->setShippings();
        }
        return $this->shippings;
    }
}
