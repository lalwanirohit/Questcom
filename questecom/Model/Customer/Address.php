<?php

namespace Model\Customer;

\Mage::loadFileByClassName('Model\Core\Table');

/**
 * 
 */
class Address extends \Model\Core\Table
{
 	const STATUS_ENABLE = 1;
    const STATUS_DESABLED = 0;	
	public function __construct(){
		$this->setPrimaryKey('addressId');
		$this->setTableName('customer_address');
	}
	public function getStatusOptions()
    {
        return [
            self::STATUS_DESABLED=>"Disable", //or use self::
            self::STATUS_ENABLE=>"Enable"
        ];
    }
}

?>