<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
date_default_timezone_set('Asia/Calcutta');

class Admin extends \Controller\Core\Admin
{
    //function for show a data
    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Admin\Grid')->toHtml();
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

    //function for form
    public function formAction()
    {
        try {
            $id = $this->getRequest()->getGet('id');
            $admin = \Mage::getModel('Model\Admin');
            if ($id) {
                $row = $admin->load($id);
                if (!$row) {
                    throw new \Exception("No Admin is available at given id", 1);
                }
            }
            $contentBlock = \Mage::getBlock('Block\Admin\Admin\Edit');
            $contentBlock->setTableRow($admin);
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
            } else {
                $this->getMessage()->setFailure('<b>Unable to Insert / Update the Admin.</b>');
            }
            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);

        }
    }

    public function statusAction()
    {
        $admin = \Mage::getModel('Model\Admin');
        if ($id = $this->getRequest()->getGet('id')) {

            $record = $admin->load($id);
            if ($record->status == 1) {
                $record->status = 0;
            } else {
                $record->status = 1;
            }
        }
        $admin->save();
        $this->redirect('show', null, null, true);
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
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Admin.</b>');
            }
            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function removeAction()
    {
        $admin = \Mage::getModel('Model\Admin');

        $data = $this->getRequest()->getPost('remove');
        $data2 = implode(', ', $data);
        $query = "DELETE FROM admin where adminId in ({$data2})";
        $admin->delete($data2, $query);
        // $this->redirect('show', 'admin_admin');
        $this->redirect('show', null, null, true);
    }
}
