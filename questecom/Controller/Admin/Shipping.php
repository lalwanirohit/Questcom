<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
date_default_timezone_set('Asia/Calcutta');

class Shipping extends \Controller\Core\Admin
{
    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Shipping\Grid')->toHtml();
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
            $shipping = \Mage::getModel('Model\Shipping');
            if ($id) {
                $row = $shipping->load($id);
                if (!$row) {
                    throw new \Exception("No shipping is available at given id", 1);
                }
            }
            $contentBlock = \Mage::getBlock('Block\Admin\Shipping\Edit');
            $contentBlock->setTableRow($shipping);
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

            $record = $shipping->load($id);
            if ($record->status == 1) {
                $record->status = 0;
            } else {
                $record->status = 1;
            }
        }
        $shipping->save();
        $this->redirect('show', null, null, true);
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
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Shipment.</b>');
            }
            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function removeAction()
    {
        $shipping = \Mage::getModel('Model\Shipping');

        $data = $this->getRequest()->getPost('remove');
        $data2 = implode(', ', $data);
        $query = "DELETE FROM shipping where methodId in ({$data2})";
        $shipping->delete($data2, $query);
        // $this->redirect('show', 'admin_admin');
        $this->redirect('show', null, null, true);
    }
}
