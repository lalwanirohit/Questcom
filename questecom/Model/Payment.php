<?php

namespace Model;

\Mage::loadFileByClassName('Model\Core\Table');

class Payment extends Core\Table
{
 	const STATUS_ENABLE = 1;
    const STATUS_DESABLED = 0;	
	public function __construct(){
		$this->setPrimaryKey('methodId');
		$this->setTableName('payment');
	}
	public function getStatusOptions()
    {
        return [
            self::STATUS_DESABLED=>"Disable",
            self::STATUS_ENABLE=>"Enable"
        ];
    }
}

?>