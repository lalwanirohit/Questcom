<?php

namespace Block\Admin\Customer\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class Form extends \Block\Core\Edit
{

    protected $customer;
    protected $customerGroups;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/customer/edit/tabs/form.php');
    }

    protected function setCustomerGroups($customerGroups = null)
    {
        if ($this->customerGroups) {
            $this->customerGroups = $customerGroups;
        }
        if (!$customerGroups) {
            $group = \Mage::getModel('Model\Customer\Group');
            $collection = $group->all();
            $this->customerGroups = $collection;
        }
        return $this;
    }

    public function getCustomerGroups()
    {
        if (!$this->customerGroups) {
            $this->setCustomerGroups();
        }
        return $this->customerGroups;
    }

}
