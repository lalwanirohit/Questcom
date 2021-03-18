<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Shipping extends \Controller\Core\Admin
{
    public function showAction()
    {
        try {
            $layout = $this->getLayout();

            $contentGrid = \Mage::getBlock('Block\Admin\Shipping\Grid');

            $content = $layout->getContent();
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

            $shipping = \Mage::getModel('Model\Shipping');
            if ($id) {
                $row = $shipping->load($id);
                if (!$row) {
                    throw new \Exception("No shipping is available at given id", 1);
                }
            }

            $content = $layout->getContent();
            $contentBlock = \Mage::getBlock('Block\Admin\Shipping\Edit');
            $contentBlock->setTableRow($shipping);
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
            $shipping = \Mage::getModel('Model\Shipping');
            if ($id = $this->getRequest()->getGet('id')) {
                $shipping->methodId = $id;
            } else {
                $shipping->createdAt = date('Y-m-d | h:i:s A');
            }
            $data = $this->getRequest()->getPost('shipping');
            $shipping->setData($data);
            if ($shipping->save()) {
                $this->getMessage()->setSuccess('<b>Shipment Inserted / Updated Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to Insert / Update the Shipment.</b>');
                $this->redirect('show', null, null, true);
            }
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function statusAction()
    {
        $shipping = \Mage::getModel('Model\Shipping');
        if ($id = $this->getRequest()->getGet('id')) {
            $shipping->methodId = $id;
            $status = $this->getRequest()->getGet('status');
            if ($status == 1) {
                $shipping->status = 0;
            } else {
                $shipping->status = 1;
            }
        }
        if ($shipping->save()) {
            $this->getMessage()->setSuccess('<b>Shipment Status Changed Successfully.</b>');
            $this->redirect('show', null, null, true);
        } else {
            $this->getMessage()->setFailure('<b>Unable To Change The Shipment Status.</b>');
            $this->redirect('show', null, null, true);
        }
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->getRequest()->getGet('id');
            if (!$id) {
                throw new \Exception("You Have Given An <b>Invalid Shipment Id.</b> Please Give A Valid Shipment Id.");
            }
            $shipping = \Mage::getModel('Model\Shipping');
            if ($shipping->delete($id)) {
                $this->getMessage()->setSuccess('<b>Shipment Deleted Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Shipment.</b>');
                $this->redirect('show', null, null, true);
            }

            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }
}
