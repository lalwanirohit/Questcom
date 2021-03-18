<?php

namespace Block\Admin\Payment;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends \Block\Core\Template
{
	protected $payments;

	public function __construct(){
		$this->setTemplate('View/admin/payment/gridpayment.php');
	}

	protected function setPayments($payments = NULL){
		if ($this->payments) {
			$this->payments = $payments;
		}
		if (!$payments) {
			$payment = \Mage::getModel('Model\Payment');
			$collection = $payment->all();
			$this->payments= $collection;
		}
		return $this;
	}

	public function getPayments(){
		if (!$this->payments) {
			$this->setPayments();
		}
		return $this->payments;
	}
}

?>