<?php

namespace Block\Customer;

\Mage::loadFileByClassName('Block\Core\Template');

class Layout extends \Block\Core\Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/customer/layout/onecolumn.php');
        $this->prepareChildren();
    }

    public function prepareChildren()
    {
        $this->addChild(\Mage::getBlock('Block\Customer\Layout\Content'), 'content');
        $this->addChild(\Mage::getBlock('Block\Customer\Layout\Header'), 'header');
        $this->addChild(\Mage::getBlock('Block\Customer\Layout\Footer'), 'footer');
        $this->addChild(\Mage::getBlock('Block\Customer\Layout\Left'), 'left');
        $this->addChild(\Mage::getBlock('Block\Customer\Layout\Message'), 'message');
    }

    public function getContent()
    {
        return $this->getChild('content');
    }

    public function getLeft()
    {
        return $this->getChild('left');
    }

}
