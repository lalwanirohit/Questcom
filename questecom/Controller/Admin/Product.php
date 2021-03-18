<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Product extends \Controller\Core\Admin
{
    public function showAction()
    {
        try {
            $layout = $this->getLayout();
            $content = $layout->getContent();

            $contentGrid = \Mage::getController('Block\Admin\Product\Grid');
            $content->addChild($contentGrid, 'grid');
            $this->renderLayout();
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function formAction()
    {
        try {
            $layout = $this->getLayout();

            $id = $this->getRequest()->getGet('id');

            $product = \Mage::getModel('Model\Product');
            if ($id) {
                $row = $product->load($id);
                if (!$row) {
                    throw new \Exception("No Product is available at given id", 1);
                }
            }

            $content = $layout->getContent();
            $contentBlock = \Mage::getBlock('Block\Admin\Product\Edit');
            $contentBlock->setTableRow($product);
            $content->addChild($contentBlock, 'form');
            $this->renderLayout();

        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function saveAction()
    {
        try {
            if (!$this->getRequest()->isPost()) {
                throw new \Exception("Invalid Request..");
            }
            $product = \Mage::getModel('Model\Product');
            if ($id = $this->getRequest()->getGet('id')) {
                $product->updatedAt = date('Y-m-d | h:i:s A');
                $product->productId = $id;
            } else {
                $product->createdAt = date('Y-m-d | h:i:s A');
                $product->sku = bin2hex(random_bytes(7));
            }
            $data = $this->getRequest()->getPost('product');
            $product->setData($data);
            if ($product->save()) {
                $this->getMessage()->setSuccess('<b>Product Inserted / Updated Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to Insert / Update the Product.</b>');
                $this->redirect('show', null, null, true);
            }
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function statusAction()
    {
        $product = \Mage::getModel('Model\Product');
        if ($id = $this->getRequest()->getGet('id')) {
            $product->updatedAt = date('Y-m-d | h:i:s A');
            $product->productId = $id;
            $status = $this->getRequest()->getGet('status');
            if ($status == 1) {
                $product->status = 0;
            } else {
                $product->status = 1;
            }
        }
        if ($product->save()) {
            $this->getMessage()->setSuccess('<b>Product Status Changed Successfully.</b>');
            $this->redirect('show', null, null, true);
        } else {
            $this->getMessage()->setFailure('<b>Unable To Change The Product Status.</b>');
            $this->redirect('show', null, null, true);
        }
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->getRequest()->getGet('id');
            if (!$id) {
                throw new \Exception("You Have Given An <b>Invalid Product Id.</b> Please Give A Valid Product Id.");
            }
            $product = \Mage::getModel('Model\Product');
            if ($product->delete($id)) {
                $this->getMessage()->setSuccess('<b>Product Deleted Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Product.</b>');
                $this->redirect('show', null, null, true);
            }

            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }
}
