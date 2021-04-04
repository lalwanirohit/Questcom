<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
date_default_timezone_set('Asia/Calcutta');

class Product extends \Controller\Core\Admin
{
    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Product\Grid')->toHtml();
            $response = [
                'element' => [
                    [
                        'selector' => '#contentHtml',
                        'html' => $gridHtml,
                    ],
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function formAction()
    {
        try {
            $id = $this->getRequest()->getGet('id');
            $product = \Mage::getModel('Model\Product');
            if ($id) {
                $row = $product->load($id);
                if (!$row) {
                    throw new \Exception("No Product is available at given id", 1);
                }
            }
            $contentBlock = \Mage::getBlock('Block\Admin\Product\Edit');
            $contentBlock->setTableRow($product);
            $response = [
                'element' => [
                    [
                        'selector' => '#contentHtml',
                        'html' => $contentBlock->toHtml(),
                    ],
                ],
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
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

            $record = $product->load($id);

            if ($record->status == 1) {
                $record->status = 0;
            } else {
                $record->status = 1;
            }
        }
        $product->save();
        $this->redirect('show', null, null, true);
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->getRequest()->getGet('id');
            if (!$id) {
                throw new \Exception("You Have Given An <b>Invalid Product Id.</b> Please Give A Valid Product Id.");
            }
            $product_media = \Mage::getModel('Model\Product\Media');
            $unlinkQuery = "select name from product_media where productId = {$id}";
            $imageNames = $product_media->all($unlinkQuery);
            foreach ($imageNames->data as $key => $value) {
                foreach ($value->data as $name) {
                    unlink('media/products/' . $name);
                }
            }
            $product = \Mage::getModel('Model\Product');
            if ($product->delete($id)) {
                $this->getMessage()->setSuccess('<b>Product Deleted Successfully.</b>');
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Product.</b>');
            }
            $this->redirect('show');
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show');
        }
    }

    public function removeAction()
    {
        $product = \Mage::getModel('Model\Product');

        $data = $this->getRequest()->getPost('remove');
        $product_media = \Mage::getModel('Model\Product\Media');
        foreach ($data as $key => $value) {
            $unlinkQuery = "select name from product_media where productId = {$value}";
            $imageNames = $product_media->all($unlinkQuery);
            foreach ($imageNames->data as $key => $value) {
                foreach ($value->data as $name) {
                    unlink('media/products/' . $name);
                }
            }
        }

        $data2 = implode(', ', $data);
        $query = "DELETE FROM product where productId in ({$data2})";
        $product->delete($data2, $query);
        $this->redirect('show');
    }
}
