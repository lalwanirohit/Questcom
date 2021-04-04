<?php

namespace Block\Customer\Home;

\Mage::loadFileByClassName('Block\Core\Template');

class Index extends \Block\Core\Template
{
    protected $admins;

    public function __construct()
    {
        $this->setTemplate('View/customer/home/indexhome.php');
    }

    protected function setadmins($admins = null)
    {
        if ($this->admins) {
            $this->admins = $admins;
        }
        if (!$admins) {
            $admin = \Mage::getModel('Model\Admin');
            $collection = $admin->all();
            $this->admins = $collection;
        }
        return $this;
    }

    public function getadmins()
    {
        if (!$this->admins) {
            $this->setadmins();
        }
        return $this->admins;
    }
}
