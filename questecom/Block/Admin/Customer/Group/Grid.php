<?php

namespace Block\Admin\Customer\Group;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends \Block\Core\Template
{
	protected $customerGroups;
	protected $template;

	public function __construct(){
		$this->template = 'View/admin/customergroup/gridcustomergroup.php';
	}
	
	protected function setCustomerGroups($customerGroups = NULL){
		if ($this->customerGroups) {
			$this->customerGroups = $customerGroups;
		}
		if (!$customerGroups) {
			$group = \Mage::getModel('Model\Customer\Group');
			$collection = $group->all();
			$this->customerGroups = $collection;
		}
		return $this;
	}
	
	public function getCustomerGroups(){
		if (!$this->customerGroups) {
			$this->setCustomerGroups();
		}
		return $this->customerGroups;
	}
}

?>