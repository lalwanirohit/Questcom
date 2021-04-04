<div id="tabContent">

<?php
foreach ($this->getChildren() as $key => $value) {
    echo $this->getChild($key)->toHtml();
}
?>

</div>

<script>
</script>