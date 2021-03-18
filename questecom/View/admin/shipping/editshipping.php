<div class="container" style="padding-left: 100px; padding-right: 100px;">

    <?php if ($id = $this->getRequest()->getGet('id')): ?>
        <h1>Update Shipping</h1>
    <?php else: ?>
        <h1>Insert Shipping</h1>
    <?php endif;?>

    <?php $shipping = $this->getTableRow();?>

    <hr><br>

    <form method="post" action="<?php echo $this->getFormUrl(); ?>">

        <div class="form-row">

            <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name" name="shipping[name]" required value="<?php echo $shipping->name; ?>">
            </div>

            <div class="form-group col-md-6">
                <label>Shipping Code</label>
                <input type="text" class="form-control" placeholder="Shipping Code" name="shipping[code]" required value="<?php echo $shipping->code ?>">
            </div>

        </div>

        <div class="form-row">

            <div class="form-group col-md-6">
                <label>Amount</label>
                <input type="text" class="form-control" placeholder="Amount" name="shipping[amount]" required value="<?php echo $shipping->amount ?>">
            </div>

            <div class="form-group col-md-6">
                <label>Status</label>
                <select class="custom-select" name="shipping[status]" required>
                    <?php foreach ($shipping->getStatusOptions() as $key => $value) {?>
                        <option value="<?php echo $key ?>" <?php if ($shipping->status == $key) {?> selected <?php }?>><?php echo $value; ?></option>
                    <?php }?>
                </select>
            </div>

        </div>

        <div class="form-row">

            <div class="form-group col-md-12">
                <label>Description</label>
                <textarea class="form-control" rows="5" placeholder="Description" name="shipping[description]" required><?php echo $shipping->description; ?></textarea>
            </div>

        </div>

        <br>
        <?php if ($id): ?>
            <button class="btn btn-warning">Update Shipping</button>
        <?php else: ?>
            <button class="btn btn-warning">Insert Shipping</button>
        <?php endif;?>

    </form>
</div>