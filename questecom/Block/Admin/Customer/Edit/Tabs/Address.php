<?php

namespace Block\Admin\Customer\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class Address extends \Block\Core\Edit
{

    protected $saddress;
    protected $baddress;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/customer/edit/tabs/address.php');
    }

    protected function setAddress($saddress = null, $baddress = null)
    {
        if ($this->saddress) {
            $this->saddress = $saddress;
        }

        if ($this->baddress) {
            $this->baddress = $baddress;
        }

        $saddress = \Mage::getModel('Model\Customer\Address');
        $baddress = \Mage::getModel('Model\Customer\Address');

        $id = $this->getTableRow()->customerId;

        $row = $saddress->loadAddress($id, 'shipping');
        $this->saddress = $row;

        $row2 = $baddress->loadAddress($id, 'billing');
        $this->baddress = $row2;

        $this->saddress = $saddress;
        $this->baddress = $baddress;

        return $this;
    }

    public function getAddress()
    {
        if (!$this->saddress) {
            $this->setAddress();
        }

        if (!$this->saddress) {
            $this->setAddress();
        }
        return $this;
    }
}
