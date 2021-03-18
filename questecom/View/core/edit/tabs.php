<?php
$tabs = $this->getTabs();
foreach ($tabs as $key => $tab) { ?>
    <a class="" href='<?php echo $this->getUrl()->getUrl(null, null, ['tab' => $key]); ?>'> <?php echo $tab['label']; ?> </a> <br><br><?php
}

?>