<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
date_default_timezone_set('Asia/Calcutta');

class Payment extends \Controller\Core\Admin
{

    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Payment\Grid')->toHtml();
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
            $payment = \Mage::getModel('Model\Payment');
            if ($id) {
                $row = $payment->load($id);
                if (!$row) {
                    throw new \Exception("No payment is available at given id", 1);
                }
            }

            $contentBlock = \Mage::getBlock('Block\Admin\Payment\Edit');
            $contentBlock->setTableRow($payment);
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

            $record = $payment->load($id);
            if ($record->status == 1) {
                $record->status = 0;
            } else {
                $record->status = 1;
            }
        }
        $payment->save();
        $this->redirect('show', null, null, true);
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
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Payment.</b>');
            }
            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function removeAction()
    {
        $payment = \Mage::getModel('Model\Payment');

        $data = $this->getRequest()->getPost('remove');
        $data2 = implode(', ', $data);
        $query = "DELETE FROM payment where methodId in ({$data2})";
        $payment->delete($data2, $query);
        // $this->redirect('show', 'admin_admin');
        $this->redirect('show', null, null, true);
    }
}
