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
            $layout = $this->getLayout();

            $contentGrid = \Mage::getBlock('Block\Admin\Customer\Group\Grid');

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

            $customerGroup = \Mage::getModel('Model\Customer\Group');
            if ($id) {
                $row = $customerGroup->load($id);
                if (!$row) {
                    throw new \Exception("No customer is available at given id", 1);
                }
            }

            $content = $layout->getContent();
            $contentBlock = \Mage::getBlock('Block\Admin\Customer\Group\Edit');
            $contentBlock->setTableRow($customerGroup);
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
            $group->groupId = $id;
            $status = $this->getRequest()->getGet('status');
            if ($status == 1) {
                $group->status = 0;
            } else {
                $group->status = 1;
            }
        }
        if ($group->save()) {
            $this->getMessage()->setSuccess('<b>Customer Group Status Changed Successfully.</b>');
            $this->redirect('show', null, null, true);
        } else {
            $this->getMessage()->setFailure('<b>Unable To Change The Customer Group Status.</b>');
            $this->redirect('show', null, null, true);
        }
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
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Customer Group.</b>');
                $this->redirect('show', null, null, true);
            }

            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }
}
