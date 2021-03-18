<?php

namespace Block\Core;

\Mage::loadFileByClassName('Block\Core\Template');

class Edit extends Template
{
    protected $tab = null;
    protected $tableRow = null;
    // protected $template;
    protected $tabClass = null;

    public function __construct()
    {
        $this->setTemplate('View/core/edit.php');
    }

    public function getTabContent()
    {
        $tabBlock = $this->getTab();
        $tabs = $tabBlock->getTabs();

        $tab = $this->getRequest()->getGet('tab', $tabBlock->getDefaultTab());

        if (!array_key_exists($tab, $tabs)) {
            return null;
        }

        $blockClassName = $tabs[$tab]['block'];
        $block = \Mage::getBlock($blockClassName);
        $block->setTableRow($this->getTableRow());
        echo $block->toHtml();
    }

    public function getTabHtml()
    {
        return $this->getTab()->toHtml();
    }

    public function setTab($tab = null)
    {
        if (!$tab) {
            $tab = $this->getTabClass();
        }
        $tab->setTableRow($this->getTableRow());
        $this->tab = $tab;
        return $this;
    }

    public function getTab()
    {
        if (!$this->tab) {
            $this->setTab();
        }
        return $this->tab;
    }

    public function setTableRow(\Model\Core\Table $tableRow)
    {
        $this->tableRow = $tableRow;
        return $this;
    }

    public function getTableRow()
    {
        return $this->tableRow;
    }

    public function getFormUrl()
    {
        return $this->getUrl()->getUrl('save');
    }

    public function setTabClass($tabClass = null)
    {
        $this->tabClass = $tabClass;
        return $this;
    }

    public function getTabClass()
    {
        return $this->tabClass;
    }
}
