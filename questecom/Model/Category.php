<?php

namespace Model;

\Mage::loadFileByClassName('Model\Core\Table');

class Category extends Core\Table
{
    const STATUS_ENABLE = 1;
    const STATUS_DESABLED = 0;
    public function __construct()
    {
        $this->setPrimaryKey('categoryId');
        $this->setTableName('category');
    }
    public function getStatusOptions()
    {
        return [
            self::STATUS_DESABLED => "Disable",
            self::STATUS_ENABLE => "Enable",
        ];
    }

    public function updatePath()
    {
        if (!$this->parentId) {
            $path = $this->categoryId;
        } else {
            $parent = \Mage::getModel('model\category')->load($this->parentId);
            if (!$parent) {
                throw new \Exception("Unable to load parent");
            }
            $path = $parent->path . "=" . $this->categoryId;
        }
        $this->path = $path;
        $this->Save();
    }

    public function updateChildPath($categoryPath, $parentId = null)
    {
        $categoryPath = $categoryPath . "=";
        $query = "SELECT * FROM `{$this->getTableName()}` WHERE `path` LIKE '{$categoryPath}%' ORDER BY `path` ASC";
        $categories = $this->getAdapter()->fetchAll($query);
        if ($categories) {
            foreach ($categories as $key => $row) {
                $row = $this->load($row['categoryId']);
                if ($parentId != null) {
                    $row->parentId = $parentId;
                }
                $row->updatePath();
            }
        }
    }
    // public function updatePath()
    // {
    //     if(!$this->parentId) {
    //         $path = $this->categoryId;
    //     }
    //     else {
    //         $parent = \Mage::getModel('Model\Category')->load($this->parentId);
    //         if(!$parent) {
    //             throw new \Exception ('Enable to load parent',1);
    //         }
    //         $path = $parent->path."=".$this->categoryId;
    //     }
    //     $this->path = $path;
    //     return $this->save();

    // }

    // public function updateChildPath($categoryPath, $parent=null)
    // {
    //     $categoryPath = $categoryPath."=";
    //     $query = "SELECT * FROM `category` where `path` LIKE '{$categoryPath}%' ORDER BY path ASC";

    //     $categories = $this->getAdapter()->fetchAll($query);
    //     if($categories) {
    //         foreach ($categories as $key => $row) {
    //             $row = \Mage::getModel('Model\Category')->load($row['categoryId']);
    //             if($parent != null) {
    //                 $row->parent = $parent;
    //             }
    //             $row->updatePath();
    //         }
    //     }
    // }
}
