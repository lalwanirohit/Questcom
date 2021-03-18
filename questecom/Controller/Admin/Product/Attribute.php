<?php

namespace Controller\Admin\Product;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');

class Attribute extends \Controller\Core\Admin
{
    public function saveAction()
    {
        try {
            if (!$this->getRequest()->isPost()) {
                throw new \Exception("Invalid Request..");
            }

            $attribute = \Mage::getModel('Model\Product');

            if ($id = $this->getRequest()->getGet('id')) {
                $attribute->productId = $id;

                $data = $this->getRequest()->getPost('product');
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $value = implode(',', $value);
                    }
                    $attribute->$key = $value;
                }
                $attribute->save();
                $this->redirect('form', 'admin_product');
            }
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }
    }
}
