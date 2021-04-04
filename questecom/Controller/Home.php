<?php

namespace Controller;

use Controller\Admin\Customer;

\Mage::loadFileByClassName('Controller\Core\Customer');
\Mage::loadFileByClassName('Block\Core\Layout');
date_default_timezone_set('Asia/Calcutta');

class Home extends \Controller\Core\Customer
{
    public function indexAction()
    {
        try {
            $layout = $this->getLayout();

            $adminGrid = \Mage::getBlock('Block\Customer\Home\Index');

            $content = $layout->getContent();
            $content->addChild($adminGrid, 'grid');
            $this->renderLayout();
        } catch (\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('show', null, null, true);
        }

    }

    public function PageAction()
    {
        $pager = \Mage::getController('Controller\Core\Pager');

        $query = "SELECT * FROM `admin`";
        $admin = \Mage::getModel('Model\Admin');
        $count = $admin->getAdapter()->query($query);
        $adminCount = $count->num_rows;

        $pager->setTotalRecords($adminCount);
        $pager->setRecordsPerPage(5);
        if (isset($_GET['p'])) {
            $pager->setCurrentPage($_GET['p']);
        }
        $pager->calculate();
        $offset = (($pager->getCurrentPage() - 1) * $pager->getRecordsPerPage());
        $query = "SELECT * " .
            "FROM admin " .
            "LIMIT {$offset}, {$pager->getRecordsPerPage()};";

        $aa = $admin->getAdapter()->fetchAll($query);
        echo "<pre>";
        print_r($aa);

        echo "<Pre>";
        print_r($pager);
    }
}
