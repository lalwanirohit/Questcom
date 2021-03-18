<?php

namespace Block\Admin\Cms;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends \Block\Core\Template
{
	protected $cmss;

	public function __construct(){
		$this->setTemplate('View/admin/cms/gridcms.php');
	}

	protected function setCmss($cmss = NULL){
		if ($this->cmss) {
			$this->cmss = $cmss;
		}
		if (!$cmss) {
			$cms = \Mage::getModel('Model\Cms');
			$collection = $cms->all();
			$this->cmss= $collection;
		}
		return $this;
	}
	
	public function getCmss(){
		if (!$this->cmss) {
			$this->setCmss();
		}
		return $this->cmss;
	}
}

?>