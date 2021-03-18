<?php $attributes = $this->getAttribute();?>
<?php $options = $this->getOptions();?>
<?php $product = $this->getTableRow();?>
<?php //$type = explode(',', $product->type);
//print_r($type);?>
<?php //echo "<pre>";
// print_r($product);die; ?>
<?php
/*foreach ($options->getData() as $key => $value) {
$one = $value->getData();
echo $one['name'];
}*/
?>
<h1>Product Attributes</h1>
<hr><br>

<?php if (!$attributes): ?>
    <center> Attributes are not Available. </center>
<?php else: ?>
    <?php foreach ($attributes->getData() as $key => $attribute): ?>
        <?php $name = $attribute->name;?>
        <div class="form-row">
            <div class="form-group col-md-12">

                <label> <?php echo $attribute->name; ?> </label> <br>
                <?php if ($attribute->inputType == 'select'): ?>
                    <select class="custom-select" name="product[<?php echo $attribute->name; ?>]">
                        <option value=""> Select <?php echo $attribute->name; ?> </option>
                        <?php foreach ($options->getData() as $key => $value): ?>
                        <?php $one = $value->getData();?>
                        <?php if ($attribute->attributeId == $one['attributeId']): ?>
                        <option value="<?php echo $one['name']; ?>" <?php if ($product->$name == $one['name']): ?> selected <?php endif;?>><?php echo $one['name']; ?></option>
                        <?php endif;?>
                        <?php endforeach;?>
                    </select>
                <?php endif;?>

                <?php if ($attribute->inputType == 'multi-select'): ?>
                    <select class="custom-select" name="product[<?php echo $attribute->name; ?>][]" multiple>
                        <option value=""> Select <?php echo $attribute->name; ?> </option>
                        <?php foreach ($options->getData() as $key => $value): ?>
                        <?php $one = $value->getData();?>
                        <?php if ($attribute->attributeId == $one['attributeId']): ?>
                        <?php $arr = explode(',', $product->$name);?>
                        <option value="<?php echo $one['name']; ?>" <?php foreach ($arr as $key => $value): ?> <?php if ($value == $one['name']): ?> selected <?php endif;endforeach;?>><?php echo $one['name']; ?></option>
                        <?php endif;?>
                        <?php endforeach;?>
                    </select>
                <?php endif;?>

                <?php if ($attribute->inputType == 'checkbox'): ?>
                    <?php foreach ($options->getData() as $key => $value): ?>
                        <?php $one = $value->getData();?>
                        <?php if ($attribute->attributeId == $one['attributeId']): ?>
                        <?php $arr = explode(',', $product->$name);?>
                        <input type="checkbox" value="<?php echo $one['name']; ?>" id="" name="product[<?php echo $attribute->name; ?>][]"  <?php foreach ($arr as $key => $value): ?> <?php if ($value == $one['name']): ?> checked <?php endif;endforeach;?>>
                        <label><?php echo $one['name']; ?> </label>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>

                <?php if ($attribute->inputType == 'radio'): ?>
                    <?php foreach ($options->getData() as $key => $value): ?>
                        <?php $one = $value->getData();?>
                        <?php if ($attribute->attributeId == $one['attributeId']): ?>
                        <input type="radio" value="<?php echo $one['name']; ?>" name="product[<?php echo $attribute->name; ?>]" <?php if ($product->$name == $one['name']): ?> checked <?php endif;?>>
                        <label><?php echo $one['name']; ?> </label>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>

                <?php if ($attribute->inputType == 'text'): ?>
                    <input class="form-control" type="text" name="product[<?php echo $attribute->name; ?>]">
                <?php endif;?>

                <?php if ($attribute->inputType == 'email'): ?>
                    <input class="form-control" type="text" name="product[<?php echo $attribute->name; ?>]">
                <?php endif;?>


            </div>
        </div>
    <?php endforeach;?>

    <button onclick="updateData(this)" class="btn btn-warning" name="update">Update</button>
<?php endif;?>


<script>
    function updateData(button) {
        var form = $(button).closest('form');
        form.attr('action','<?php echo $this->getUrl()->getUrl('save', 'admin_product_attribute'); ?>');
        form.submit();
    }
</script>
