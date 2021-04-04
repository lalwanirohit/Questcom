<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
date_default_timezone_set('Asia/Calcutta');

class Category extends \Controller\Core\Admin
{
    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Category\Grid')->toHtml();
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
            $category = \Mage::getModel('Model\Category');
            if ($id) {
                $row = $category->load($id);
                if (!$row) {
                    throw new \Exception("No category is available at given id", 1);
                }
            }
            $contentBlock = \Mage::getBlock('Block\Admin\Category\Edit');
            $contentBlock->setTableRow($category);
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

            $record = $category->load($id);
            if ($record->status == 1) {
                $record->status = 0;
            } else {
                $record->status = 1;
            }
        }
        $category->save();
        $this->redirect('show', null, null, true);
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

    public function removeAction()
    {
        $category = \Mage::getModel('Model\Category');

        $data = $this->getRequest()->getPost('remove');
        foreach ($data as $key => $value) {
            $category = $category->load($value);
            $path = $category->path;
            $parentId = $category->parentId;
            $category->updateChildPath($path, $parentId);
            $category->delete($value);
        }
        $data2 = implode(', ', $data);
        $query = "DELETE FROM category where categoryId in ({$data2})";
        $category->delete($data2, $query);
        $this->redirect('show', null, null, true);
    }
}
