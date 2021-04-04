<?php
namespace Controller\Admin;

\Mage::loadFileByClassName('Model\Core\Adapter');
\Mage::loadFileByClassName('Controller\Core\Admin');

date_default_timezone_set('Asia/Calcutta');

class Filter extends \Controller\Core\Admin
{
    public function filterAction()
    {
        // \session_start();
        // \session_reset();
        // \session_destroy();
        $filters = $this->getRequest()->getPost('filter');
        $filter = \Mage::getModel('Model\Admin\Filter');
        $filter->setFilters($filters);
        $controllerName = 'admin_';
        foreach ($filters as $key => $value) {
            $controllerName .= $key;
        }
        $this->redirect('show', $controllerName);
    }
}
