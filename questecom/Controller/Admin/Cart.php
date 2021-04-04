<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');

class Cart extends \Controller\Core\Admin
{

    public function gridAction()
    {
        $grid = \Mage::getBlock('Block\Admin\Cart\Grid')->setCart($this->getCart())->toHtml();
        $response = [
            'element' => [
                'selector' => '#contentHtml',
                'html' => $grid,
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        // $this->makeResponse($grid);
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

        if ($cart) {
            return $cart;
        }

        $cart = \Mage::getModel('Model\Cart');
        $cart->customerId = $session->customerId;
        $cart->createdAt = date("Y-m-d H:i:s");
        $cart->save();
        return $cart;
    }

    public function saveCustomerAction()
    {
        $customerId = $this->getRequest()->getPost('customer');
        $this->getMessage()->setSuccess('Customer Selected');
        $grid = \Mage::getBlock('Block\Admin\Cart\Grid')->setCart($this->getCart($customerId['customerId']))->toHtml();
        $response = [
            'element' => [
                'selector' => '#contentHtml',
                'html' => $grid,
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        // $this->makeResponse($grid);
    }

    public function addToCartAction()
    {
        $productId = $this->getRequest()->getGet('id');
        $product = \Mage::getModel('Model\Product')->load($productId);
        $this->getCart()->addItemToCart($product);
        $this->getMessage()->setSuccess('Item successfully add to cart.');
        $grid = \Mage::getBlock('Block\Admin\Cart\Grid')->setCart($this->getCart())->toHtml();
        $response = [
            'element' => [
                'selector' => '#contentHtml',
                'html' => $grid,
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        // $this->makeResponse($grid);
    }

    public function updateCartAction()
    {
        $itemData = $this->getRequest()->getPost('item');
        foreach ($itemData as $cartItemId => $quantity) {
            if ($quantity != 0) {
                $item = \Mage::getModel('Model\Cart\Item')->load($cartItemId);
                $item->quantity = $quantity;
                $item->save();
            }
            if ($quantity == 0) {
                $this->deleteAction($cartItemId);
            }
        }
        $this->getMessage()->setSuccess('Cart update Successfully.');
        $grid = \Mage::getBlock('Block\Admin\Cart\Grid')->setCart($this->getCart())->toHtml();
        $response = [
            'element' => [
                'selector' => '#contentHtml',
                'html' => $grid,
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        // $this->makeResponse($grid);
    }

    public function deleteAction($itemId = null)
    {
        $cartItem = \Mage::getModel('Model\Cart\Item');
        $cartItemId = $this->getRequest()->getGet('id');
        if ($itemId) {
            $cartItemId = $itemId;
        }
        $cartItem = $cartItem->load($cartItemId);
        if ($cartItem) {
            $cartItem->delete($cartItemId);
        }
        if ($itemId) {
            return true;
        } else {
            $this->getMessage()->setSuccess('Item deleted.');
            $grid = \Mage::getBlock('Block\Admin\Cart\Grid')->setCart($this->getCart())->toHtml();
            $response = [
                'element' => [
                    'selector' => '#contentHtml',
                    'html' => $grid,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            // $this->makeResponse($grid);
            // $this->redirect('show', null, null, true);

        }
    }
}
