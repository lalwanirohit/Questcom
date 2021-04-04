<?php
foreach ($this->getChildren() as $key => $value) {
    echo $this->getChild($key)->toHtml();
}
?>


<!-- <div id='contentHtml'>

</div> -->

<!-- <script>
    var object = new Base();
    object.setParams({
        name : 'rohit',
        email : 'lalwanirohit111@gmail.com'
    });
    object.setUrl('http://localhost/projects/cybercom/index.php?controller=product&action=showHtml');
    object.load();
</script> -->


