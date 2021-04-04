<?php

namespace Controller\Admin\Category;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');

class Media extends \Controller\Core\Admin
{
    public function saveAction()
    {
        try {
            if (!$this->getRequest()->isPost()) {
                throw new \Exception("Invalid Request..");
            }

            $image = \Mage::getModel('Model\Category\Media');

            if ($id = $this->getRequest()->getGet('id')) {
                $image->categoryId = $id;
            }
            if (isset($_FILES['file'])) {
                $photo = $_FILES['file']['name'];
                $tempname = $_FILES['file']['tmp_name'];

                $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));
                $file_size = $_FILES['file']['size'];
                $photoName = rand(1, 99) . '-' . time() . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 4) . '.' . $file_ext;
                $location = 'media/categories/' . $photoName;

                $extensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $extensions) === false) {
                    throw new \Exception("extension not allowed, please choose a JPEG or PNG file.");
                }

                if ($file_size > 2097152) {
                    throw new \Exception('Image size shuold be less than 2 MB');
                }

                if (move_uploaded_file($tempname, $location)) {
                    $image->name = $photoName;
                }

                if ($image->save()) {
                    $this->getMessage()->setSuccess('<b>Image Inserted / Updated Successfully.</b>');
                } else {
                    $this->getMessage()->setFailure('<b>Unable to Insert / Update the Image.</b>');
                }
                $this->redirect('form', 'admin_category');
            }
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('form', 'admin_category');
        }
    }

    public function updateAction()
    {
        try {
            if (!$this->getRequest()->isPost()) {
                throw new \Exception("Invalid Request..");
            }

            $image = \Mage::getModel('Model\Category\Media');

            $data = $this->getRequest()->getPost();

            $data2 = implode(', ', $data['banner']);

            $id = $this->getRequest()->getGet('id');
            $query1 = "update category_media set banner=0, icon=0, base=0 where categoryId={$id}";
            $image->updateImage($query1);

            $query2 = "UPDATE category_media SET `icon`= 1 where `mediaId`= {$data['icon']}";
            $image->updateImage($query2);

            $query4 = "UPDATE category_media SET `base`= 1 where `mediaId`= {$data['base']}";
            $image->updateImage($query4);

            $query5 = "UPDATE category_media SET `banner`= 1 where `mediaId` in ({$data2})";
            $image->updateImage($query5);

            foreach ($data['label'] as $key => $value) {
                $image = \Mage::getModel('Model\Category\Media');
                $query6 = "UPDATE category_media SET `label`= '{$value}' where `mediaId`= {$key}";
                $image->updateImage($query6);
            }

            $this->redirect('form', 'admin_category');
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('form', 'admin_category');
        }
    }

    public function removeAction()
    {
        $image = \Mage::getModel('Model\Category\Media');

        $data = $this->getRequest()->getPost('remove');
        $data2 = implode(', ', $data);
        $unlinkquery = "select name from category_media where mediaId in ({$data2})";
        $imageNames = $image->all($unlinkquery);
        foreach ($imageNames->data as $key => $value) {
            foreach ($value->data as $name) {
                unlink('media/categories/' . $name);
            }
        }
        $query = "DELETE FROM category_media where mediaId in ({$data2})";
        $image->delete($data2, $query);
        $this->redirect('form', 'admin_category');
    }
}
