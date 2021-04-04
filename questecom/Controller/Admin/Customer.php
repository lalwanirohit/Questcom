<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
date_default_timezone_set('Asia/Calcutta');

class Customer extends \Controller\Core\Admin
{

    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Customer\Grid')->toHtml();
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
            $layout = $this->getLayout();
            $id = $this->getRequest()->getGet('id');
            $customer = \Mage::getModel('Model\Customer');
            if ($id) {
                $row = $customer->load($id);
                if (!$row) {
                    throw new \Exception("No customer is available at given id", 1);
                }
            }

            $contentBlock = \Mage::getBlock('Block\Admin\Customer\Edit');
            $contentBlock->setTableRow($customer);
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
            $customer = \Mage::getModel('Model\Customer');
            if ($id = $this->getRequest()->getGet('id')) {
                $customer->updatedAt = date('Y-m-d | h:i:s A');
                $customer->customerId = $id;
            } else {
                $customer->createdAt = date('Y-m-d | h:i:s A');
                $char = 'abcdefghijklmnopqrstuvwxyz';
                $num = '1234567890';
                $customer->password = md5(str_shuffle(substr(str_shuffle($char), 0, 4) . substr(str_shuffle($num), 0, 4)));
            }

            $data = $this->getRequest()->getPost('customer');
            $customer->setData($data);
            if ($customer->save()) {
                $this->getMessage()->setSuccess('<b>Customer Inserted / Updated Successfully.</b>');
            } else {
                $this->getMessage()->setFailure('<b>Unable to Insert / Update the Customer.</b>');
            }
            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function statusAction()
    {
        $customer = \Mage::getModel('Model\Customer');
        if ($id = $this->getRequest()->getGet('id')) {

            $record = $customer->load($id);
            if ($record->status == 1) {
                $record->status = 0;
            } else {
                $record->status = 1;
            }
        }
        $customer->save();
        $this->redirect('show', null, null, true);
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->getRequest()->getGet('id');
            if (!$id) {
                throw new \Exception("You Have Given An <b>Invalid Customer Id.</b> Please Give A Valid Customer Id.");
            }
            $customer = \Mage::getModel('Model\Customer');
            $address = \Mage::getModel('Model\Customer\Address');

            $query = "DELETE from `customer_address` where `customerId` = {$id}";

            if ($address->delete($id, $query) && $customer->delete($id)) {
                $this->getMessage()->setSuccess('<b>Customer Deleted Successfully.</b>');
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Customer.</b>');
            }

            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function removeAction()
    {
        $customer = \Mage::getModel('Model\Customer');

        $data = $this->getRequest()->getPost('remove');
        $data2 = implode(', ', $data);
        $query = "DELETE FROM customer where customerId in ({$data2})";
        $customer->delete($data2, $query);
        // $this->redirect('show', 'admin_admin');
        $this->redirect('show', null, null, true);
    }
}
