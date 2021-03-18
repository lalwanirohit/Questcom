<?php

namespace Block\Admin\Customer;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends \Block\Core\Template
{
	protected $controller;
	protected $customers;

	protected $template;

	public function __construct(){
		$this->template = 'View/admin/customer/gridcustomer.php';
	}
	
	protected function setcustomers($customers = NULL){
		if ($this->customers) {
			$this->customers = $customers;
		}
		if (!$customers) {
			$customer = \Mage::getModel('Model\Customer');
			$collection = $customer->all();
			$this->customers= $collection;
		}
		return $this;
	}

	public function getcustomers(){
		if (!$this->customers) {
			$this->setcustomers();
		}
		return $this->customers;
	}

	public function getGroupName($id) {
		$customerGroup = \Mage::getModel('Model\Customer\Group');
		if($customerData = $customerGroup->load($id)){
			return $customerData->name;
		}
	}

	public function getZip($id) {
		$customerAddress = \Mage::getModel('Model\Customer\Address');
		if($customerData = $customerAddress->load($id)){
			return $customerData->zipcode;
		}
	}
	
}

?>