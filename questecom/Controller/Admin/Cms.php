<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
date_default_timezone_set('Asia/Calcutta');

class Cms extends \Controller\Core\Admin
{
    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Cms\Grid')->toHtml();
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
            $cms = \Mage::getModel('Model\Cms');
            if ($id) {
                $row = $cms->load($id);
                if (!$row) {
                    throw new \Exception("No cms is available at given id", 1);
                }
            }

            $contentBlock = \Mage::getBlock('Block\Admin\Cms\Edit');
            $contentBlock->setTableRow($cms);
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
            $cms = \Mage::getModel('Model\Cms');
            if ($id = $this->getRequest()->getGet('id')) {
                $cms->pageId = $id;
            } else {
                $cms->createdAt = date('Y-m-d | h:i:s A');
            }
            $data = $this->getRequest()->getPost('cms');
            $cms->setData($data);
            if ($cms->save()) {
                $this->getMessage()->setSuccess('<b>Cms Inserted / Updated Successfully.</b>');
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to Insert / Update Cms.</b>');
                $this->redirect('show', null, null, true);
            }
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function statusAction()
    {
        $cms = \Mage::getModel('Model\Cms');
        if ($id = $this->getRequest()->getGet('id')) {

            $record = $cms->load($id);
            if ($record->status == 1) {
                $record->status = 0;
            } else {
                $record->status = 1;
            }
        }
        $cms->save();
        $this->redirect('show', null, null, true);
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->getRequest()->getGet('id');
            if (!$id) {
                throw new \Exception("You Have Given An <b>Invalid Cms Id.</b> Please Give A Valid Cms Id.");
            }
            $cms = \Mage::getModel('Model\Cms');
            if ($cms->delete($id)) {
                $this->getMessage()->setSuccess('<b>Cms Deleted Successfully.</b>');
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Cms.</b>');
            }
            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function removeAction()
    {
        $cms = \Mage::getModel('Model\Cms');

        $data = $this->getRequest()->getPost('remove');
        $data2 = implode(', ', $data);
        $query = "DELETE FROM cms_page where pageId in ({$data2})";
        $cms->delete($data2, $query);
        // $this->redirect('show', 'admin_admin');
        $this->redirect('show', null, null, true);
    }
}
