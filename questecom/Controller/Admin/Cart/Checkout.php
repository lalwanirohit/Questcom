<?php

namespace Controller\Admin\Cart;

\Mage::loadFileByClassName('Controller\Core\Admin');
class Checkout extends \Controller\Core\Admin
{
    public function checkOutAction()
    {
        $grid = \Mage::getBlock('Block\Admin\Cart\Checkout')->setCart($this->getCart())->toHtml();
        $response = [
            'element' => [
                'selector' => '#contentHtml',
                'html' => $grid,
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function indexAction()
    {
        $checkOut = \Mage::getBlock('Block\Admin\Cart\Checkout');
        $this->getlayout()->getContent()->addChild($checkOut);
        $this->renderLayout();
    }

    public function getCart($customerId = null)
    {
        $session = \Mage::getModel('Model\Admin\Session');
        if ($customerId) {
            $session->customerId = $customerId;
        }
        $cart = \Mage::getModel('Model\Cart');
        $query = "SELECT * FROM {$cart->getTableName()} WHERE `customerId` = '{$session->customerId}'";

        $cart = $cart->loadRow($query);

        if (!$cart) {
            return false;
        }

        return $cart;
    }

    public function saveBillingAction()
    {
        echo "<pre>";
        $billing = $this->getRequest()->getPost('billing');
        // print_r($billing);
        $billing1 = $this->getRequest()->getPost('billing1');
        // print_r($billing1);

        $cartAddress = \Mage::getModel('Model\Cart\Address');
        if ($this->getCart()->getBillingAddress()) {
            $id = $this->getCart()->getBillingAddress()->cartAddressId;
            $cartAddress->load($id);
        }
        $cartAddress->setData($billing);
        $cartAddress->setData($billing1);
        $cartAddress->addressType = 'billing';
        $cartAddress->cartId = $this->getCart()->cartId;
        $cartAddress->save();
        if ($this->getRequest()->getPost('bookAddressBilling')) {
            $customerBillingAddress = $this->getCart()->getCustomer()->getBillingAddress();
            if ($customerBillingAddress) {
                $customerBillingAddress->setData($billing);
                $customerBillingAddress->save();
            } else {
                $customerBillingAddress = \Mage::getModel('Model\Customer\Address');
                $customerBillingAddress->setData($billing);
                $customerBillingAddress->customerId = $this->getCart()->getCustomer()->customerId;
                $customerBillingAddress->addressType = 'billing';
                $customerBillingAddress->save();
            }
        }
        $this->getMessage()->setSuccess('Address Saved');
        $checkout = \Mage::getBlock('Block\Admin\Cart\Checkout')->setCart($this->getCart())->toHtml();
        $response = [
            'element' => [
                'selector' => '#contentHtml',
                'html' => $checkout,
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function saveShippingAction()
    {
        $flage = $this->getRequest()->getPost('sameAsBilling');
        if ($flage) {
            $billing = $this->getRequest()->getPost('billing');
            $billing1 = $this->getRequest()->getPost('billing1');
            $cartAddress = \Mage::getModel('Model\cart\Address');
            if ($this->getCart()->getShippingAddress()) {
                $id = $this->getCart()->getShippingAddress()->cartAddressId;
                $cartAddress->load($id);
            }
            $cartAddress->setData($billing);
            $cartAddress->setData($billing1);
            $cartAddress->addressType = 'shipping';
            $cartAddress->cartId = $this->getCart()->cartId;
            $cartAddress->save();
            if ($this->getRequest()->getPost('bookAddressShipping')) {
                $customerShippingAddress = $this->getCart()->getCustomer()->getShippingAddress();
                if ($customerShippingAddress) {
                    $customerShippingAddress->setData($billing);
                    $customerShippingAddress->save();
                } else {
                    $customerShippingAddress = \Mage::getModel('Model\Customer\Address');
                    $customerShippingAddress->setData($billing);
                    $customerShippingAddress->customerId = $this->getCart()->getCustomer()->customerId;
                    $customerShippingAddress->addressType = 'shipping';
                    $customerShippingAddress->save();
                }
            }
        } else {
            $shipping = $this->getRequest()->getPost('shipping');
            $shipping1 = $this->getRequest()->getPost('shipping1');
            $cartAddress = \Mage::getModel('Model\cart\Address');
            if ($this->getCart()->getShippingAddress()) {
                $id = $this->getCart()->getShippingAddress()->cartAddressId;
                $cartAddress->load($id);
            }
            $cartAddress->setData($shipping);
            $cartAddress->setData($shipping1);
            $cartAddress->addressType = 'shipping';
            $cartAddress->cartId = $this->getCart()->cartId;
            $cartAddress->save();

            if ($this->getRequest()->getPost('bookAddressShipping')) {
                $customerShippingAddress = $this->getCart()->getCustomer()->getShippingAddress();
                if ($customerShippingAddress) {
                    $customerShippingAddress->setData($shipping);
                    $customerShippingAddress->save();
                } else {
                    $customerShippingAddress = \Mage::getModel('Model\Customer\Address');
                    $customerShippingAddress->setData($shipping);
                    $customerShippingAddress->customerId = $this->getCart()->getCustomer()->customerId;
                    $customerShippingAddress->addressType = 'shipping';
                    $customerShippingAddress->save();
                }
            }
        }
        $this->getMessage()->setSuccess('Address Saved');
        $checkout = \Mage::getBlock('Block\Admin\Cart\Checkout')->setCart($this->getCart())->toHtml();
        $response = [
            'element' => [
                'selector' => '#contentHtml',
                'html' => $checkout,
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function savePaymentMethodAction()
    {
        $payment = $this->getRequest()->getPost('paymentMethod');
        if ($payment) {
            $cart = $this->getCart();
            $cart->paymentMethodId = $payment;
            $cart->save();
        }
        $this->getMessage()->setSuccess('Payment method saved.');
        $checkout = \Mage::getBlock('Block\Admin\Cart\CheckOut')->setCart($this->getCart())->toHtml();
        $response = [
            'element' => [
                'selector' => '#contentHtml',
                'html' => $checkout,
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function saveShippingMethodAction()
    {
        $payment = $this->getRequest()->getPost('shippingMethod');
        if ($payment) {
            $cart = $this->getCart();
            $cart->shippingMethodId = $payment;
            $cart->save();
        }
        $this->getMessage()->setSuccess('Shiping method saved.');
        $checkout = \Mage::getBlock('Block\Admin\Cart\Checkout')->setCart($this->getCart())->toHtml();
        $response = [
            'element' => [
                'selector' => '#contentHtml',
                'html' => $checkout,
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
