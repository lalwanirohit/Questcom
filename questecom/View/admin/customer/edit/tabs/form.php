<?php if ($id = $this->getRequest()->getGet('id')): ?>
    <h1>Update customer</h1>
<?php else: ?>
    <h1>Insert customer</h1>
<?php endif;?>

<?php $customer = $this->getTableRow();?>
<?php $groups = $this->getCustomerGroups();?>

<hr><br>
<div class="form-row">

    <div class="form-group col-md-6">
        <label>First Name</label>
        <input type="text" class="form-control" placeholder="First Name" name="customer[firstName]" required value="<?php echo $customer->firstName; ?>">
    </div>

    <div class="form-group col-md-6">
        <label>Last Name</label>
        <input type="text" class="form-control" placeholder="Last Name" name="customer[lastName]" required value="<?php echo $customer->lastName ?>">
    </div>

</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label>Email</label>
        <input type="email" class="form-control" placeholder="Email" name="customer[email]" required value="<?php echo $customer->email ?>">
    </div>

    <div class="form-group col-md-6">
        <label>Mobile</label>
        <input type="text" class="form-control" placeholder="Mobile Number" name="customer[mobile]" required value="<?php echo $customer->mobile ?>">
    </div>

</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label>Status</label>
        <select class="custom-select" name="customer[status]" required>
            <?php foreach ($customer->getStatusOptions() as $key => $value): ?>
                <option value="<?php echo $key ?>" <?php if ($customer->status == $key) {?> selected <?php }?>><?php echo $value; ?></option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label>Customer Group</label>
        <select class="custom-select" name="customer[groupId]" required>
            <?php foreach ($groups->data as $key): ?>
                <option value="<?php echo $key->groupId ?>" <?php if ($customer->groupId == $key->groupId) {?> selected <?php }?>> <?php echo $key->name; ?></option>
            <?php endforeach;?>
        </select>
    </div>

</div>
<br>
    <button style="color:white;" class="btn btn-warning" type="button" href="javascript:void(0)" onclick="submitForm(this); object.resetParams().setForm('#form').load();" name="addorupdatecustomer">Save Customer</button>

<script>
function submitForm(button) {
    var form = $(button).closest('form');
    form.attr("action","<?php echo $this->getUrl()->getUrl('save', 'admin_customer') ?>")
}

// function submitForm(button){
// var form = $(button).closest('form');
// form.attr('action', "<?php echo $this->getUrl()->getUrl('save', 'admin_admin'); ?>");
// }
</script>