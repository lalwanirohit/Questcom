<?php

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
date_default_timezone_set('Asia/Calcutta');

class Brand extends \Controller\Core\Admin
{
    //function for show a data
    public function showAction()
    {
        try {
            $gridHtml = \Mage::getBlock('Block\Admin\Brand\Grid')->toHtml();
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
            $brand = \Mage::getModel('Model\Brand');
            if ($id) {
                $row = $brand->load($id);
                if (!$row) {
                    throw new \Exception("No brand is available at given id", 1);
                }
            }
            $contentBlock = \Mage::getBlock('Block\Admin\Brand\Edit');
            $contentBlock->setTableRow($brand);
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

            $brand = \Mage::getModel('Model\Brand');

            if ($id = $this->getRequest()->getGet('id')) {
                $brand->brandId = $id;
                $brand->load($id);
                $img = $brand->brandImage;
            } else {
                $brand->createdAt = date('Y-m-d | h:i:s A');
            }

            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $photo = $_FILES['file']['name'];
                $tempname = $_FILES['file']['tmp_name'];

                $tmp = explode('.', $_FILES['file']['name']);
                $file_ext = end($tmp);
                // $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));
                // $photoName = time() . $file_ext;
                $photoName = rand(1, 99) . '-' . time() . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 4) . '.' . $file_ext;
                $location = 'media/brand/' . $photoName;
                $file_size = $_FILES['file']['size'];

                $extensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $extensions) === false) {
                    throw new \Exception("extension not allowed, please choose a JPEG or PNG file.");
                }

                if ($file_size > 2097152) {
                    throw new \Exception('file size shuold be less than 2 MB');
                }

                if (move_uploaded_file($tempname, $location)) {
                    if (isset($img)) {
                        unlink('media/brand/' . $img);
                    }

                    $brand->brandImage = $photoName;
                    $name = $this->getRequest()->getPost('brand');
                    $status = $this->getRequest()->getPost('brand');

                    $brand->brandName = $name;
                    $brand->status = $status;

                    if ($brand->save()) {
                        $this->getMessage()->setSuccess('<b>Inserted / Updated Successfully.</b>');
                    } else {
                        $this->getMessage()->setFailure('<b>Unable to Insert / Update the Admin.</b>');
                    }
                }
            }
            $this->showAction();
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }

    public function statusAction()
    {
        $brand = \Mage::getModel('Model\Brand');
        if ($id = $this->getRequest()->getGet('id')) {

            $record = $brand->load($id);
            if ($record->status == 1) {
                $record->status = 0;
            } else {
                $record->status = 1;
            }
        }
        $brand->save();
        $this->redirect('show', null, null, true);
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->getRequest()->getGet('id');
            if (!$id) {
                throw new \Exception("You Have Given An <b>Invalid Admin Id.</b> Please Give A Valid Admin Id.");
            }
            $brand = \Mage::getModel('Model\Brand');
            if ($id) {
                $row = $brand->load($id);
                if (!$row) {
                    throw new \Exception("No brand is available at given id", 1);
                }
            }
            unlink('media/brand/' . $brand->brandImage);
            if ($brand->delete($id)) {
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
        $brand = \Mage::getModel('Model\Brand');

        $data = $this->getRequest()->getPost('remove');
        foreach ($data as $key => $value) {
            $row = $brand->load($value);
            unlink('media/brand/' . $row->brandImage);
        }
        $data2 = implode(', ', $data);
        $query = "DELETE FROM product_brand where brandId in ({$data2})";
        $brand->delete($data2, $query);
        $this->redirect('show', null, null, true);
    }
}
