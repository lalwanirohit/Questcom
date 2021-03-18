<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Cms extends \Controller\Core\Admin
{
    public function showAction()
    {
        try {
            $layout = $this->getLayout();

            $cmsGrid = \Mage::getBlock('Block\Admin\Cms\Grid');

            $content = $layout->getContent();
            $content->addChild($cmsGrid, 'grid');
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

            $cms = \Mage::getModel('Model\Cms');
            if ($id) {
                $row = $cms->load($id);
                if (!$row) {
                    throw new \Exception("No cms is available at given id", 1);
                }
            }

            $content = $layout->getContent();
            $contentBlock = \Mage::getBlock('Block\Admin\Cms\Edit');
            $contentBlock->setTableRow($cms);
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
            $cms->pageId = $id;
            $status = $this->getRequest()->getGet('status');
            if ($status == 1) {
                $cms->status = 0;
            } else {
                $cms->status = 1;
            }
        }
        if ($cms->save()) {
            $this->getMessage()->setSuccess('<b>Cms Status Changed Successfully.</b>');
            $this->redirect('show', null, null, true);
        } else {
            $this->getMessage()->setFailure('<b>Unable To Change The Cms Status.</b>');
            $this->redirect('show', null, null, true);
        }
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
                $this->redirect('show', null, null, true);
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Cms.</b>');
                $this->redirect('show', null, null, true);
            }

            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }
}
