<?php

namespace Block\Admin\Cart;

\Mage::loadFileByClassName('Block\Core\Grid');

class Checkout extends \Block\Core\Grid
{
    protected $paymentMethods = null;
    protected $shippingMethods = null;
    protected $billingAddress = null;
    protected $shippingAddress = null;
    protected $cart = null;

    public function __construct()
    {
        $this->setTemplate('./View/admin/cart/checkout.php');
        $this->setPaymentMethods();
        $this->setShippingMethods();
    }

    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function setPaymentMethods()
    {
        $paymentMethod = \Mage::getModel('Model\Payment');
        $this->paymentMethods = $paymentMethod->all();
        return $this;
    }

    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }

    public function setShippingMethods()
    {
        $shippingMethod = \Mage::getModel('Model\shipping');
        $this->shippingMethods = $shippingMethod->all();
        return $this;
    }

    public function getShippingMethods()
    {
        return $this->shippingMethods;
    }

    public function setBillingAddress($billingAddress = null)
    {
        $address = $this->getCart()->getBillingAddress();
        if ($address) {
            $this->billingAddress = $address;
            return $this;
        }

        $billingAddress = $this->getCart()->getCustomer()->getBillingAddress();
        if ($billingAddress) {
            $cartAddress = \Mage::getModel('Model\Cart\Address');
            $cartAddress->address = $billingAddress->address;
            $cartAddress->city = $billingAddress->city;
            $cartAddress->state = $billingAddress->state;
            $cartAddress->zipCode = $billingAddress->zipcode;
            $cartAddress->country = $billingAddress->country;
            $cartAddress->addressType = $billingAddress->addressType;
            $cartAddress->cartId = $this->getCart()->cartId;
            $cartAddress->firstName = $this->getCart()->getCustomer()->firstName;
            $cartAddress->lastName = $this->getCart()->getCustomer()->lastName;
            $cartAddress->save();
            $address = $cartAddress;
        }
        if ($address) {
            $this->billingAddress = $address;
            return $this;
        }
        $address = \Mage::getModel('Model\Cart\Address');
        $this->billingAddress = $address;
        return $this;
    }

    public function getBillingAddress()
    {
        if (!$this->billingAddress) {
            $this->setBillingAddress();
        }
        return $this->billingAddress;
    }

    public function setShippingAddress($shippingAddress = null)
    {
        $address = $this->getCart()->getShippingAddress();
        if ($address) {
            $this->shippingAddress = $address;
            return $this;
        }
        $shippingAddress = $this->getCart()->getCustomer()->getShippingAddress();
        if ($shippingAddress) {
            $cartAddress = \Mage::getModel('Model\Cart\Address');
            $cartAddress->address = $shippingAddress->address;
            $cartAddress->city = $shippingAddress->city;
            $cartAddress->state = $shippingAddress->state;
            $cartAddress->zipCode = $shippingAddress->zipcode;
            $cartAddress->country = $shippingAddress->country;
            $cartAddress->addressType = $shippingAddress->addressType;
            $cartAddress->cartId = $this->getCart()->cartId;
            $cartAddress->firstName = $this->getCart()->getCustomer()->firstName;
            $cartAddress->lastName = $this->getCart()->getCustomer()->lastName;
            $cartAddress->save();
            $address = $cartAddress;
        }
        if ($address) {
            $this->shippingAddress = $address;
            return $this;
        }
        $address = \Mage::getModel('Model\Cart\Address');
        $this->shippingAddress = $address;
        return $this;
    }

    public function getShippingAddress()
    {
        if (!$this->shippingAddress) {
            $this->setShippingAddress();
        }
        return $this->shippingAddress;
    }

    public function getBaseTotal()
    {
        $cartItems = $this->getCart()->getItems();
        $baseTotal = 0;
        if ($cartItems) {
            foreach ($cartItems->getData() as $item) {
                $baseTotal += ($item->quantity * $item->basePrice);
            }
        }
        $cart = $this->getCart();
        $cart->discount = ($item->quantity * $item->discount);
        $cart->total = $baseTotal;
        $cart->save();
        return [$cart->total, $cart->discount];
    }

    public function getShippingCharges()
    {
        $shippingMethod = $this->getCart()->getShippingMethod();
        if ($shippingMethod) {
            $cart = $this->getCart();
            $cart->shippingAmount = $shippingMethod->amount;
            $cart->save();
            return $cart->shippingAmount;
        }
        return 0;
    }

    public function getGrandTotal()
    {
        $grandTotal = ($this->getBaseTotal()[0] - $this->getBaseTotal()[1]) + $this->getShippingCharges();
        $cart = $this->getCart();
        $cart->grandTotal = $grandTotal;
        $cart->save();
        return $cart->grandTotal;
    }
}
