<?php
namespace Block\Admin\Admin;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends \Block\Core\Template
{
	protected $admins;

	public function __construct(){
		$this->setTemplate('View/admin/admin/gridadmin.php');
	}

	protected function setadmins($admins = NULL){
		if ($this->admins) {
			$this->admins = $admins;
		}
		if (!$admins) {
			$admin = \Mage::getModel('Model\Admin');
			$collection = $admin->all();
			$this->admins= $collection;
		}
		return $this;
	}
	
	public function getadmins(){
		if (!$this->admins) {
			$this->setadmins();
		}
		return $this->admins;
	}
}

?>