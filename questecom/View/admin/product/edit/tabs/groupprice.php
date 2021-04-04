<div class="container">
<?php $customerGroups = $this->getCustomerGroup();?>
    <h1>Customer Group Prices</h1>

	<hr>
    <br>
    <button type="button" href="javascript:void(0)" onclick="submitForm(this); object.resetParams().setForm('#form').load();" class="btn btn-info" name="set">Set Price</button>
    <br><br><br>
<table class="table table-borderless">

    <thead>
        <tr>
            <td scope="col">Group Id</td>
            <td>Group Name</td>
            <td>Product SKU</td>
            <td>Product Price</td>
            <td>Product Price For Particular Group</td>
        </tr>
    </thead>

    <?php if ($customerGroups): ?>

        <?php foreach ($customerGroups->getData() as $key => $customerGroup): ?>
        <tbody>
            <tr>
                <td> <?php echo $customerGroup->groupId; ?> </td>
                <td> <?php echo $customerGroup->name; ?> </td>
                <td> <?php echo $customerGroup->sku; ?> </td>
                <td> <?php echo $customerGroup->productPrice; ?> </td>
                <td> <input type="text" name="groupPriceData[<?php echo $key; ?>][price]" value="<?php echo $customerGroup->price; ?>">
                     <input type="hidden" name="groupPriceData[<?php echo $key; ?>][entityId]" value="<?php echo $customerGroup->entityId; ?>">
                     <input type="hidden" name="groupPriceData[<?php echo $key; ?>][customerGroupId]" value="<?php echo $customerGroup->groupId; ?>">
                     <input type="hidden" name="groupPriceData[<?php echo $key; ?>][productId]" value="<?php echo $customerGroup->productId; ?>"></td>
                     </td>
            </tr>
        </tbody>

        <?php endforeach;?>
    <?php endif;?>



</table>
</div>

<script>
    function submitForm(button) {
        var form = $(button).closest('form');
        form.attr('action','<?php echo $this->getUrl()->getUrl('save', 'admin_product_group_price'); ?>');
    }
</script>