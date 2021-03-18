<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Payment extends \Controller\Core\Admin
{

    public function showAction()
    {
        try {
            $layout = $this->getLayout();

            $contentGrid = \Mage::getBlock('Block\Admin\Payment\Grid');

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

            $payment = \Mage::getModel('Model\Payment');
            if ($id) {
                $row = $payment->load($id);
                if (!$row) {
                    throw new \Exception("No payment is available at given id", 1);
                }
            }

            $content = $layout->getContent();
            $contentBlock = \Mage::getBlock('Block\Admin\Payment\Edit');
            $contentBlock->setTableRow($payment);
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
            $payment = \Mage::getModel('Model\Payment');
            if ($id = $this->getRequest()->getGet('id')) {
                $payment->methodId = $id;
            } else {
                $payment->createdAt = date('Y-m-d | h:i:s A');
            }
            $data = $this->getRequest()->getPost('payment');
            $payment->setData($data);

            if ($payment->save()) {
                $this->getMessage()->setSuccess('<b>Payment Inserted / Updated Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to Insert / Update the Payment.</b>');
                $this->redirect('show', null, null, true);
            }
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function statusAction()
    {
        $payment = \Mage::getModel('Model\Payment');
        if ($id = $this->getRequest()->getGet('id')) {
            $payment->methodId = $id;
            $status = $this->getRequest()->getGet('status');
            if ($status == 1) {
                $payment->status = 0;
            } else {
                $payment->status = 1;
            }
        }
        if ($payment->save()) {
            $this->getMessage()->setSuccess('<b>Payment Status Changed Successfully.</b>');
            $this->redirect('show', null, null, true);
        } else {
            $this->getMessage()->setFailure('<b>Unable To Change The Payment Status.</b>');
            $this->redirect('show', null, null, true);
        }
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->getRequest()->getGet('id');
            if (!$id) {
                throw new \Exception("You Have Given An <b>Invalid Payment Id.</b> Please Give A Valid Payment Id.");
            }
            $payment = \Mage::getModel('Model\Payment');
            if ($payment->delete($id)) {
                $this->getMessage()->setSuccess('<b>Payment Deleted Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Payment.</b>');
                $this->redirect('show', null, null, true);
            }

            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }
}
