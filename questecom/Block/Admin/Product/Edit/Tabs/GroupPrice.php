<?php

namespace Block\Admin\Product\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class GroupPrice extends \Block\Core\Edit
{
    protected $customerGroups = null;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/product/edit/tabs/groupprice.php');
    }

    public function getCustomerGroup()
    {
        $productId = $this->getTableRow()->productId;
        $query = "SELECT `cg`.*,`pgp`.`price`,`p`.`productId`, `p`.`price` AS `productPrice`, `p`.`name` AS `productName`,`p`.`sku`,`pgp`.`entityId`
				FROM customer_group cg
				LEFT JOIN product_group_price as `pgp`
			    ON `pgp`.`customerGroupId` = `cg`.`groupId` AND `pgp`.`productId` = '{$productId}'
				LEFT JOIN  product as `p`
				ON `p`.`productId` = '{$productId}'";

        $customerGroup = \Mage::getModel('Model\Product\Group\Price');
        $this->customerGroups = $customerGroup->all($query);

        return $this->customerGroups;
    }
}
