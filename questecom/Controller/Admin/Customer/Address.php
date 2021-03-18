<?php

namespace Controller\Admin\Customer;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Address extends \Controller\Core\Admin{

	public function saveAction() {
		try{
			if (!$this->getRequest()->isPost()) {
				throw new \Exception("Invalid Request..");
			}

			$saddress = \Mage::getModel('Model\Customer\Address');
			$id = $this->getRequest()->getGet('id');
			$sdata = $this->getRequest()->getPost('saddress');
			$saddress->customerId = $id;
			$saddress->addressType = 'shipping';
			$saddress->setData($sdata);

			$baddress = \Mage::getModel('Model\Customer\Address');
			$bdata = $this->getRequest()->getPost('baddress');
			$baddress->customerId = $id;
			$baddress->addressType = 'billing';
			$baddress->setData($bdata);

			if($baddress->save() && $saddress->save()) {
				$this->getMessage()->setSuccess('<b>Address Inserted / Updated Successfully.</b>');
				$this->redirect('show','admin_customer');
			}
			else {
				$this->getMessage()->setFailure('<b>Unable to Insert / Update the Address.</b>');
				$this->redirect('show','admin_customer');
			}
		}			
		catch (\Exception $e){
			$this->getMessage()->setFailure($e->getMessage());
			$this->redirect('show',null,null,true);
		}
	}
}

?>
    