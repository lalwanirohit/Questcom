<?php

namespace Block\Admin\Category;

\Mage::loadFileByClassName('Block\Core\Template');

class Grid extends \Block\Core\Template
{
	protected $categories = [];
	protected $categoryOptions = [];

	public function __construct(){
		$this->setTemplate('view/admin/category/gridcategory.php');
	}

	protected function setcategories($categories = NULL){
		if ($this->categories) {
			$this->categories = $categories;
		}
		if (!$categories) {
			$category = \Mage::getModel('Model\Category');
			$query = "SELECT * FROM `category` ORDER BY `path` ASC";
			$collection = $category->all($query);
			$this->categories= $collection;
		}
		return $this;
	}

	public function getcategories(){
		if (!$this->categories) {
			$this->setcategories();
		}
		return $this->categories;
	}

	public function getName($category)
	{
		$categoryModel =\Mage::getModel('Model\Category');
		if(!$this->categoryOptions) {
			$query = "SELECT `categoryId`, `name` FROM `{$categoryModel->getTableName()}`;";
			$this->categoryOptions = $categoryModel->getAdapter()->fetchPairs($query);
		}

		$paths = explode("=",$category->path);

		foreach ($paths as $key => &$id) {
			if(array_key_exists($id, $this->categoryOptions)) {
				$id = $this->categoryOptions[$id];
			}
		}
		$name = implode('/',$paths);
		return $name;
	}
}

?>