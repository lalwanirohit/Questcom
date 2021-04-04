<?php

namespace Model\Cart;

\Mage::loadFileByClassName('Model\Core\Table');
class Item extends \Model\Core\Table
{
    protected $cart = null;
    protected $product = null;
    public function __construct()
    {
        $this->setTableName('cart_item');
        $this->setPrimaryKey('cartItemId');
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
    public function setProduct(\Model\Product $product)
    {
        if (!$this->productId) {
            return false;
        }
        $product = \Mage::getModel('Model\Product')->load($this->productId);
        $this->setProduct($product);
        return $this->product;
    }
}
