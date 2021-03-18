<?php

namespace Block\Admin\Category\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class Form extends \Block\Core\Edit
{

    protected $category;
    protected $categoryOptions;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/category/edit/tabs/form.php');
    }

    protected function setCategory($category = null)
    {
        if ($this->category) {
            $this->category = $category;
        }

        $category = \Mage::getModel('Model\Category');
        if ($id = $this->getTableRow()->categoryId) {
            $row = $category->load($id);
            if (!$row) {
                throw new \Exception("Invalid Id");
            }
            $this->category = $row;
        }

        $this->category = $category;
        return $this;
    }

    public function getCategory()
    {
        if (!$this->category) {
            $this->setCategory();
        }
        return $this->category;
    }

    public function getCategoryOptions()
    {
        if (!$this->categoryOptions) {
            $query = "SELECT `categoryId`,`name` FROM `{$this->getCategory()->getTableName()}`;";
            $options = $this->getCategory()->getAdapter()->fetchPairs($query);

            if (!$this->getTableRow()->categoryId) {
                $query = "SELECT `categoryId`,`path` FROM `{$this->getTableRow()->getTableName()}` ORDER BY `path` ASC";
            } else {
                $query = "SELECT `categoryId`,`path` FROM `{$this->getTableRow()->getTableName()}` where `path` NOT LIKE '{$this->getTableRow()->path}%' ORDER BY path ASC;";
            }

            // $query = "SELECT `categoryId`,`path` FROM `{$this->getCategory()->getTableName()}` ORDER BY `path` ASC;";
            $this->categoryOptions = $this->getCategory()->getAdapter()->fetchPairs($query);

            if ($this->categoryOptions) {
                foreach ($this->categoryOptions as $categoryId => &$path) {
                    $paths = explode("=", $path);

                    foreach ($paths as $key => &$id) {
                        if (array_key_exists($id, $options)) {
                            $id = $options[$id];
                        }
                    }
                    $path = implode('/', $paths);
                }
            }

            $this->categoryOptions = ["0" => "Root Category"] + $this->categoryOptions;
        }
        return $this->categoryOptions;
    }

}
