<?php

namespace Controller\Admin\Product;

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

            $image = \Mage::getModel('Model\Product\Media');

            if ($id = $this->getRequest()->getGet('id')) {
                $image->productId = $id;
            }

            if (isset($_FILES['image'])) {
                $photo = $_FILES['image']['name'];
                $tempname = $_FILES['image']['tmp_name'];
                $location = 'skin/admin/images/product/' . $photo;

                $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
                $file_size = $_FILES['image']['size'];

                $extensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $extensions) === false) {
                    throw new \Exception("extension not allowed, please choose a JPEG or PNG file.");
                }

                if ($file_size > 2097152) {
                    throw new \Exception('Image size shuold be less than 2 MB');
                }

                if (move_uploaded_file($tempname, $location)) {
                    $image->name = $location;
                    $image->thumb = 1;
                    $image->small = 1;
                    $image->base = 1;
                    $image->gallery = 1;
                }

                if ($image->save()) {
                    $this->getMessage()->setSuccess('<b>Image Inserted / Updated Successfully.</b>');
                    $this->redirect('form', 'admin_product');
                } else {
                    $this->getMessage()->setFailure('<b>Unable to Insert / Update the Image.</b>');
                    $this->redirect('form', 'admin_product');
                }
            }
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('form', 'admin_product');
        }
    }

    public function updateAction()
    {
        try {
            if (!$this->getRequest()->isPost()) {
                throw new \Exception("Invalid Request..");
            }

            $image = \Mage::getModel('Model\Product\Media');

            $data = $this->getRequest()->getPost();

            echo "<pre>";
            print_r($data['label']);
            $data2 = implode(', ', $data['gallery']);

            $id = $this->getRequest()->getGet('id');
            $query1 = "update product_media set gallery=0, small=0, thumb=0, base=0 where productId={$id}";
            $image->updateImage($query1);

            $query2 = "UPDATE product_media SET `small`= 1 where `imageId`= {$data['small']}";
            $image->updateImage($query2);

            $query3 = "UPDATE product_media SET `thumb`= 1 where `imageId`= {$data['thumb']}";
            $image->updateImage($query3);

            $query4 = "UPDATE product_media SET `base`= 1 where `imageId`= {$data['base']}";
            $image->updateImage($query4);

            $query5 = "UPDATE product_media SET `gallery`= 1 where `imageId` in ({$data2})";
            $image->updateImage($query5);

            foreach ($data['label'] as $key => $value) {
                $image = \Mage::getModel('Model\Product\Media');
                $query6 = "UPDATE product_media SET `label`= '{$value}' where `imageId`= {$key}";
                $image->updateImage($query6);
            }

            $this->redirect('form', 'admin_product');
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('form', 'admin_product');
        }
    }

    public function removeAction()
    {
        $image = \Mage::getModel('Model\Product\Media');

        $data = $this->getRequest()->getPost('remove');
        $data2 = implode(', ', $data);
        $unlinkquery = "select name from product_media where imageId in ({$data2})";
        $imageNames = $image->all($unlinkquery);
        foreach ($imageNames->data as $key => $value) {
            foreach ($value->data as $name) {
                unlink($name);
            }
        }
        $query = "DELETE FROM product_media where imageId in ({$data2})";
        $image->delete($data2, $query);
        $this->redirect('form', 'admin_product');
    }
}
