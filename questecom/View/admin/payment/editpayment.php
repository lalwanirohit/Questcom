<div class="container" style="padding-left: 100px; padding-right: 100px;">

    <?php if ($id = $this->getRequest()->getGet('id')): ?>
        <h1>Update Payment</h1>
    <?php else: ?>
        <h1>Insert Payment</h1>
    <?php endif;?>

    <?php $payment = $this->getTableRow();?>

    <hr><br>
    <form method="post" id="paymentForm" action="<?php echo $this->getFormUrl(); ?>">

        <div class="form-row">

            <div class="form-group col-md-4">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name" name="payment[name]" required value="<?php echo $payment->name; ?>">
            </div>

            <div class="form-group col-md-4">
                <label>Code</label>
                <input type="text" class="form-control" placeholder="Payment Code" name="payment[code]" required value="<?php echo $payment->code; ?>">
            </div>

            <div class="form-group col-md-4">
                <label>Status</label>
                <select class="custom-select" name="payment[status]" required>

                    <?php foreach ($payment->getStatusOptions() as $key => $value): ?>
                        <option value="<?php echo $key ?>" <?php if ($payment->status == $key) {?> selected <?php }?>><?php echo $value; ?></option>
                    <?php endforeach;?>

                </select>
            </div>

        </div>

        <div class="form-row">

            <div class="form-group col-md-12">
                <label>Description</label>
                <textarea class="form-control" rows="5" placeholder="Payment Description" name="payment[description]" required><?php echo $payment->description ?></textarea>
            </div>

        </div>

        <br>
        <button class="btn btn-warning" type="button" href="javascript:void(0)" onclick="object.resetParams().setForm('#paymentForm').load();">Save Payment</button>
    </form>
</div>