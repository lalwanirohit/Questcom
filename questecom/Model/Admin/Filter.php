<?php
namespace Model\Admin;

\Mage::loadFileByClassName('Model\Admin\Session');

class Filter extends Session
{
    public function setFilters($filters)
    {
        $this->start();
        $this->setNameSpace('filter');
        foreach ($filters as $key => $filter) {
            $_SESSION[$key] = $filter;
        }
    }
    public function getFilter($key)
    {
        if (!array_key_exists($key, $_SESSION)) {
            return null;
        }
        return $_SESSION[$key];
    }
}
