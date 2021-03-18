<?php

namespace Model\Product;

\Mage::loadFileByClassName('Model\Core\Table');
/**
 * 
 */
class Media extends \Model\Core\Table
{
	public function __construct(){
		$this->setPrimaryKey('imageId');
		$this->setTableName('product_media');
	}   

}

?>