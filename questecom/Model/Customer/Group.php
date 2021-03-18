<?php

namespace Model\Customer;

\Mage::loadFileByClassName('Model\Core\Table');

/**
 * 
 */
class Group extends \Model\Core\Table
{
 	const STATUS_ENABLE = 1;
    const STATUS_DESABLED = 0;	
	public function __construct(){
		$this->setPrimaryKey('groupId');
		$this->setTableName('customer_group');
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