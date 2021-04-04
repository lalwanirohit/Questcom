<?php

namespace Block\Admin;

\Mage::loadFileByClassName('Block\Core\Template');

class Layout extends \Block\Core\Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/layout/onecolumn.php');
        $this->prepareChildren();
    }

    public function prepareChildren()
    {
        $this->addChild(\Mage::getBlock('Block\Admin\Layout\Content'), 'content');
        $this->addChild(\Mage::getBlock('Block\Admin\Layout\Header'), 'header');
        $this->addChild(\Mage::getBlock('Block\Admin\Layout\Footer'), 'footer');
        $this->addChild(\Mage::getBlock('Block\Admin\Layout\Left'), 'left');
        $this->addChild(\Mage::getBlock('Block\Admin\Layout\Message'), 'message');
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
