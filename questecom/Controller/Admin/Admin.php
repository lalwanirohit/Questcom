<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Admin extends \Controller\Core\Admin
{

    //function for show a data
    public function showAction()
    {
        try {
            $layout = $this->getLayout();

            $adminGrid = \Mage::getBlock('Block\Admin\Admin\Grid');

            $content = $layout->getContent();
            $content->addChild($adminGrid, 'grid');
            $this->renderLayout();
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    //function for form
    public function formAction()
    {
        try {
            $layout = $this->getLayout();

            $id = $this->getRequest()->getGet('id');

            $admin = \Mage::getModel('Model\Admin');
            if ($id) {
                $row = $admin->load($id);
                if (!$row) {
                    throw new \Exception("No Admin is available at given id", 1);
                }
            }
            $content = $layout->getContent();
            $contentBlock = \Mage::getBlock('Block\Admin\Admin\Edit');
            $contentBlock->setTableRow($admin);
            $content->addChild($contentBlock, 'form');
            $this->renderLayout();
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    //function for save data
    public function saveAction()
    {
        try {
            if (!$this->getRequest()->isPost()) {
                throw new \Exception("Invalid Request..");
            }

            $admin = \Mage::getModel('Model\Admin');

            if ($id = $this->getRequest()->getGet('id')) {
                $admin->adminId = $id;
            } else {
                $admin->createdAt = date('Y-m-d | h:i:s A');
            }

            $data = $this->getRequest()->getPost('admin');
            $admin->userName = $data['userName'];
            $admin->password = md5($data['password']);
            $admin->status = $data['status'];

            if ($admin->save()) {
                $this->getMessage()->setSuccess('<b>Admin Inserted / Updated Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to Insert / Update the Admin.</b>');
                $this->redirect('show', null, null, true);
            }
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function statusAction()
    {
        $admin = \Mage::getModel('Model\Admin');
        if ($id = $this->getRequest()->getGet('id')) {
            $admin->adminId = $id;
            $status = $this->getRequest()->getGet('status');
            if ($status == 1) {
                $admin->status = 0;
            } else {
                $admin->status = 1;
            }
        }
        if ($admin->save()) {
            $this->getMessage()->setSuccess('<b>Admin Status Changed Successfully.</b>');
            $this->redirect('show', null, null, true);
        } else {
            $this->getMessage()->setFailure('<b>Unable To Change The Admin Status.</b>');
            $this->redirect('show', null, null, true);
        }
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->getRequest()->getGet('id');
            if (!$id) {
                throw new \Exception("You Have Given An <b>Invalid Admin Id.</b> Please Give A Valid Admin Id.");
            }
            $admin = \Mage::getModel('Model\Admin');
            if ($admin->delete($id)) {
                $this->getMessage()->setSuccess('<b>Admin Deleted Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Admin.</b>');
                $this->redirect('show', null, null, true);
            }

            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }
}
