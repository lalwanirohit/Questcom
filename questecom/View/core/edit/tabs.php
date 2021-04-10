<?php
$tabs = $this->getTabs();
foreach ($tabs as $key => $tab) {?>
    <a class="<?php echo $tab['class']; ?>" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl(null, null, ['tab' => $key]); ?>').resetParams().load()"> <?php echo $tab['label']; ?> </a> <br><br><?php
}

?>