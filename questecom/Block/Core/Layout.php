<?php

namespace Block\Core;

\Mage::loadFileByClassName('Block\Core\Template');
\Mage::loadFileByClassName('Block\Core\Layout\Content');
\Mage::loadFileByClassName('Block\Core\Layout\Header');
\Mage::loadFileByClassName('Block\Core\Layout\Footer');
\Mage::loadFileByClassName('Block\Core\Layout\Left');

class Layout extends Template {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('View/core/layout/onecolumn.php');
        $this->prepareChildren();
    }

    public function prepareChildren() {
        $this->addChild(new Layout\Content(), 'content');
        $this->addChild(new Layout\Header(), 'header');
        $this->addChild(new Layout\Footer(), 'footer');
        $this->addChild(new Layout\Left(), 'left');
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

?>