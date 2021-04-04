<?php

namespace Model\Cart;

\Mage::loadFileByClassName('Model\Core\Table');

class Address extends \Model\Core\Table
{
    const ADDRESS_TYPE_BILLING = 'billing';
    const ADDRESS_TYPE_SHIPPING = 'shipping';

    protected $cart = null;
    protected $customerBillingAddress = null;

    public function __construct()
    {
        $this->setTableName('cart_address');
        $this->setPrimaryKey('cartAddressId');
    }

    public function setCart(\Model\Cart $cart)
    {
        $this->cart = $cart;
        return $this;
    }
    public function getCart()
    {
        if (!$this->cartId) {
            return false;
        }
        $cart = \Mage::getModel('Model\Cart')->load($this->cartId);
        $this->setCart($cart);
        return $this->cart;
    }

    public function setCustomerBillingAddress(\Model\Customer\Address $address)
    {
        $this->customerBillingAddress = $address;
        return $this;
    }

    public function getCustomerBillingAddress()
    {
        if (!$this->addressId) {
            return false;
        }
        $address = \Mage::getModel('Model\Customer\Address')->load($this->addressId);
        $this->setCustomerBillingAddress($address);
        return $this->customerBillingAddress;
    }
}
