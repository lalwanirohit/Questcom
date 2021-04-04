<?php

namespace Controller\Admin\Product\Group;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');

class Price extends \Controller\Core\Admin
{
    public function saveAction()
    {
        try {

            if (!$this->getRequest()->isPost()) {
                throw new \Exception("Invalid Request..");
            }

            $data = $this->getRequest()->getPost('groupPriceData');
            $ProductGroupPrice = \Mage::getModel('Model\Product\Group\Price');
            foreach ($data as $key => $value) {

                $ProductGroupPrice->entityId = $value['entityId'];
                $ProductGroupPrice->price = $value['price'];
                $ProductGroupPrice->customerGroupId = $value['customerGroupId'];
                $ProductGroupPrice->productId = $value['productId'];

                $ProductGroupPrice->save();
            }
            $this->redirect('form', 'admin_product');
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', 'admin_product');
        }
    }
}
