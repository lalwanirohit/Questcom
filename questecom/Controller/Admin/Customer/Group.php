<?php

namespace Controller\Admin\Customer;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Group extends \Controller\core\Admin
{

    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Customer\Group\Grid')->toHtml();
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
            $customerGroup = \Mage::getModel('Model\Customer\Group');
            if ($id) {
                $row = $customerGroup->load($id);
                if (!$row) {
                    throw new \Exception("No customer is available at given id", 1);
                }
            }
            $contentBlock = \Mage::getBlock('Block\Admin\Customer\Group\Edit');
            $contentBlock->setTableRow($customerGroup);
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
                throw new \Exception();
                $message = \Mage::getModel('Model\Admin\Message');
                $message->setSuccess('Your request is not of POST');
                $this->redirect('form');
            }
            $group = \Mage::getModel('Model\Customer\Group');
            if ($id = $this->getRequest()->getGet('id')) {
                $group->groupId = $id;
            } else {
                $group->createdAt = date('Y-m-d | h:i:s A');
            }
            $data = $this->getRequest()->getPost('group');
            $group->setData($data);
            if ($group->save()) {
                $this->getMessage()->setSuccess('<b>Customer Group Inserted / Updated Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to Insert / Update the Customer Group.</b>');
                $this->redirect('show', null, null, true);
            }
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function statusAction()
    {
        $group = \Mage::getModel('Model\Customer\Group');
        if ($id = $this->getRequest()->getGet('id')) {

            $record = $group->load($id);
            if ($record->status == 1) {
                $record->status = 0;
            } else {
                $record->status = 1;
            }
        }
        $group->save();
        $this->redirect('show', null, null, true);
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->getRequest()->getGet('id');
            if (!$id) {
                throw new \Exception("You Have Given An <b>Invalid Customer Group Id.</b> Please Give A Valid Category Id.");
            }
            $group = \Mage::getModel('Model\Customer\Group');
            if ($group->delete($id)) {
                $this->getMessage()->setSuccess('<b>Customer Group Deleted Successfully.</b>');
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Customer Group.</b>');
            }
            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function removeAction()
    {
        $group = \Mage::getModel('Model\Customer\Group');

        $data = $this->getRequest()->getPost('remove');
        $data2 = implode(', ', $data);
        $query = "DELETE FROM customer_group where groupId in ({$data2})";
        $group->delete($data2, $query);
        // $this->redirect('show', 'admin_admin');
        $this->redirect('show', null, null, true);
    }
}
