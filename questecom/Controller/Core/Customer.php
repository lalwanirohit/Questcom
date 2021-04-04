<?php

namespace Controller\Core;

use Exception;

\Mage::loadFileByClassName('Controller\Core\Abstracts');
\Mage::loadFileByClassName('Block\Core\Layout');

class Customer extends Abstracts
{
    public function setLayout(\Block\Core\Layout $layout = null)
    {
        if (!$layout) {
            $layout = \Mage::getBlock('Block\Customer\Layout');
        }

        if (!$layout instanceof \Block\Customer\Layout) {
            throw new \Exception("Must be instance of \Block\Customer\Layout");
        }

        $this->layout = $layout;
        return $this;
    }

    public function setMessage()
    {
        if (!$this->message) {
            $this->message = \Mage::getModel('Model\Customer\Message');
        }
        return $this;
    }
}
