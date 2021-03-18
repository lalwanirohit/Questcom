<?php 

namespace Controller\Admin;

\Mage::loadFileByClassName('Controller\Core\Admin');
\Mage::loadFileByClassName('Block\Core\Layout');

class Dashboard extends \Controller\Core\Admin
{
    public function showAction()
    {
        try {
            $layout = $this->getLayout();

            $contentGrid = \Mage::getBlock('Block\Admin\Dashboard\Grid');

            $content = $layout->getContent();
            $content->addChild($contentGrid, 'grid');
            $this->renderLayout();

        }
        catch(\Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
			$this->redirect('show',null,null,true);
        }
    }
}

?>