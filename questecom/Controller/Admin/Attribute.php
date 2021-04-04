<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
date_default_timezone_set('Asia/Calcutta');

class Attribute extends \Controller\Core\Admin
{
    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Attribute\Grid')->toHtml();
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
            $attribute = \Mage::getModel('Model\Attribute');
            if ($id) {
                $row = $attribute->load($id);
                if (!$row) {
                    throw new \Exception("No attribute is available at given id", 1);
                }
            }

            $contentBlock = \Mage::getBlock('Block\Admin\Attribute\Edit');
            $contentBlock->setTableRow($attribute);
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

            $attribute = \Mage::getModel('Model\Attribute');

            if ($id = $this->getRequest()->getGet('id')) {
                $attribute->attributeId = $id;
            }

            $data = $this->getRequest()->getPost('attribute');
            $query = "ALTER TABLE {$data['entityTypeId']} ADD {$data['name']} {$data['backendType']}";
            $attribute->getAdapter()->query($query);
            $attribute->setData($data);
            if ($attribute->save()) {
                $this->getMessage()->setSuccess('<b>attribute Inserted / Updated Successfully.</b>');
            } else {
                $this->getMessage()->setFailure('<b>Unable to Insert / Update the attribute.</b>');
            }
            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
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

            $attribute = \Mage::getModel('Model\Attribute');
            if ($id) {
                $row = $attribute->load($id);
                if (!$row) {
                    throw new \Exception("No attribute is available at given id", 1);
                }
            }

            $query = "ALTER TABLE {$row->entityTypeId} DROP COLUMN {$row->name}";
            $attribute->getAdapter()->query($query);

            if ($attribute->delete($id)) {
                $this->getMessage()->setSuccess('<b>Attribute Deleted Successfully.</b>');
            } else {
                $this->getMessage()->setFailure('<b>Unable to delete the Attribute.</b>');
            }
            $this->redirect('show', null, null, true);
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function removeAction()
    {
        $attribute = \Mage::getModel('Model\Attribute');

        $data = $this->getRequest()->getPost('remove');
        $data2 = implode(', ', $data);
        foreach ($data as $key => $value) {
            $row = $attribute->load($value);
            $query = "ALTER TABLE {$row->entityTypeId} DROP COLUMN {$row->name}";
            $attribute->getAdapter()->query($query);
        }
        $query = "DELETE FROM attribute where attributeId in ({$data2})";
        $attribute->delete($data2, $query);
        $this->redirect('show', null, null, true);
    }

}
