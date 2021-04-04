<?php

namespace Block\Admin\Category\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class Media extends \Block\Core\Edit
{

    protected $images;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/category/edit/tabs/media.php');
    }

    public function setImages($images = null)
    {
        if (!$images) {
            $categoryId = $this->getTableRow()->categoryId;
        }

        $image = \Mage::getModel('Model\Category\Media');

        $query = "SELECT * FROM `category_media` WHERE `categoryId` = {$categoryId}";
        $collection = $image->all($query);
        $this->images = $collection;
        return $this;
    }

    public function getImages()
    {
        if (!$this->images) {
            $this->setImages();
        }
        return $this->images;
    }

}
