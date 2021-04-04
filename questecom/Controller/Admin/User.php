<?php

namespace COntroller\Admin;

class User extends \Controller\Core\Admin
{
    public function indexAction()
    {
        $model = \Mage::getModel('Model\Product');
        $query = "SELECT * FROM {$model->getTableName()}";
        $product = $model->all($query);

        echo "<pre>";
        print_r($product);

    }
}
