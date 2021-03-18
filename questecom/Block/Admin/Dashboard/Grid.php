<?php

namespace Block\Admin\Dashboard;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends \Block\Core\Template
{
	public function __construct(){
		$this->setTemplate('View/admin/dashboard/griddashboard.php');
	}
}

?>