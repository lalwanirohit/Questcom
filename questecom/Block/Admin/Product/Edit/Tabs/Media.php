<?php

namespace Block\Admin\Product\Edit\Tabs;

\Mage::loadFileByClassName('Block\Core\Edit');

class Media extends \Block\Core\Edit
{
    protected $images;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('View/admin/product/edit/tabs/media.php');
    }

    public function setImages($images = null)
    {
        if (!$images) {
            $productId = $this->getTableRow()->productId;
        }

        $image = \Mage::getModel('Model\Product\Media');

        $query = "SELECT * FROM `product_media` WHERE `productId` = {$productId}";
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
