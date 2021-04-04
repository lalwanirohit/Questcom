<?php

namespace Model;

\Mage::loadFileByClassName('Model\Core\Table');

class Customer extends Core\Table
{
    const STATUS_ENABLE = 1;
    const STATUS_DESABLED = 0;

    protected $shipping = null;
    protected $billing = null;

    public function __construct()
    {
        $this->setPrimaryKey('customerId');
        $this->setTableName('customer');
    }

    public function getStatusOptions()
    {
        return [
            self::STATUS_DESABLED => "Disable",
            self::STATUS_ENABLE => "Enable",
        ];
    }

    public function setBillingAddress()
    {
        $address = \Mage::getModel('Model\Customer\Address');
        $query = "SELECT * FROM `{$address->getTableName()}` WHERE `customerId` = '{$this->customerId}' AND `addressType` = 'billing'";
        $address = $address->loadRow($query);
        $this->billing = $address;
        return $this;
    }

    public function getBillingAddress()
    {
        if (!$this->billing) {
            $this->setBillingAddress();
        }
        return $this->billing;
    }

    public function setShippingAddress()
    {
        $address = \Mage::getModel('Model\Customer\Address');
        $query = "SELECT * FROM `{$address->getTableName()}` WHERE `customerId` = '{$this->customerId}' AND `addressType` = 'shipping'";
        $address = $address->loadRow($query);
        $this->shipping = $address;
        return $this;
    }

    public function getShippingAddress()
    {
        if (!$this->shipping) {
            $this->setShippingAddress();
        }
        return $this->shipping;
    }
}
