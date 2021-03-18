<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Category extends \Controller\Core\Admin
{

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($result)
    {
        $this->categories = $result;
        return $this;
    }

    public function showAction()
    {
        try {
            $layout = $this->getLayout();

            $contentGrid = \Mage::getBlock('Block\Admin\Category\Grid');

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

            $category = \Mage::getModel('Model\Category');
            if ($id) {
                $row = $category->load($id);
                if (!$row) {
                    throw new \Exception("No category is available at given id", 1);
                }
            }

            $content = $layout->getContent();
            $contentBlock = \Mage::getBlock('Block\Admin\Category\Edit');
            $contentBlock->setTableRow($category);
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
            $category = \Mage::getModel('Model\Category');

            if (!$this->getRequest()->isPost()) {
                throw new \Exception("Invalid Request");
            }

            $id = $this->getRequest()->getGet('id');
            if ($id) {
                $category = $category->load($id);
                if (!$category) {
                    throw new \Exception('Invalid Id');
                }
            }

            $categoryPath = $category->path;
            $data = $this->getRequest()->getPost('category');
            $category->setData($data);
            $category->Save();
            $category->updatePath();
            $category->updateChildPath($categoryPath, $parentId = null);
            $this->redirect('show');
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function statusAction()
    {
        $category = \Mage::getModel('Model\Category');
        if ($id = $this->getRequest()->getGet('id')) {
            $category->updatedAt = date('Y-m-d | h:i:s A');
            $category->categoryId = $id;
            $status = $this->getRequest()->getGet('status');

            if ($status == 1) {
                $category->status = 0;
            } else {
                $category->status = 1;
            }
        }
        if ($category->save()) {
            $this->getMessage()->setSuccess('<b>Category Status Changed Successfully.</b>');
            $this->redirect('show', null, null, true);
        } else {
            $this->getMessage()->setFailure('<b>Unable To Change The Category Status.</b>');
            $this->redirect('show', null, null, true);
        }
    }

    public function deleteAction()
    {
        try
        {
            $category = \Mage::getModel('Model\Category');
            if (($id = $this->getRequest()->getGet('id'))) {
                $category = $category->load($id);
                if (!$category) {
                    throw new \Exception("Invalid Data");
                }
            }
            $path = $category->path;
            $parentId = $category->parentId;
            $category->updateChildPath($path, $parentId);
            $category->delete($id);
            $this->getMessage()->setSuccess("Data Delete Successfully..");
            $this->redirect('show', null, [], true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, [], true);
        }

    }
}
