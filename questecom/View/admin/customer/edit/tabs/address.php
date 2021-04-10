<?php if ($address = $this->getAddress()): ?>
    <?php $shippingAddress = $address->saddress;?>
    <?php $billingAddress = $address->baddress;?>
<?php endif;?>

<h3>Shipping Address</h3>

    <input type="hidden" value="<?php echo $shippingAddress->addressId; ?>" name = "saddress[addressId]">
    <input type="hidden" value="<?php echo $billingAddress->addressId; ?>" name = "baddress[addressId]">

    <hr>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Address</label>
            <textarea class="form-control" rows="4" placeholder="Address" name="saddress[address]" required><?php echo $shippingAddress->address; ?></textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label>City</label>
            <input type="text" class="form-control" placeholder="City" name="saddress[city]" required value="<?php echo $shippingAddress->city; ?>">
        </div>

        <div class="form-group col-md-3">
            <label>State</label>
            <input type="text" class="form-control" placeholder="State" name="saddress[state]" required value="<?php echo $shippingAddress->state; ?>">
        </div>

        <div class="form-group col-md-3">
            <label>Zip Code</label>
            <input type="text" class="form-control" placeholder="Zip Code" name="saddress[zipcode]" required value="<?php echo $shippingAddress->zipcode; ?>">
        </div>

        <div class="form-group col-md-3">
            <label>Country</label>
            <input type="text" class="form-control" placeholder="Country" name="saddress[country]" required value="<?php echo $shippingAddress->country; ?>">
        </div>
    </div>
    <br>

    <br>
    <h3>Billing Address</h3>
    <hr>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Address</label>
            <textarea class="form-control" rows="4" placeholder="Address" name="baddress[address]" required><?php echo $billingAddress->address; ?></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label>City</label>
            <input type="text" class="form-control" placeholder="City" name="baddress[city]" required value="<?php echo $billingAddress->city; ?>">
        </div>

        <div class="form-group col-md-3">
            <label>State</label>
            <input type="text" class="form-control" placeholder="State" name="baddress[state]" required value="<?php echo $billingAddress->state; ?>">
        </div>

        <div class="form-group col-md-3">
            <label>Zip Code</label>
            <input type="text" class="form-control" placeholder="Zip Code" name="baddress[zipcode]" required value="<?php echo $billingAddress->zipcode; ?>">
        </div>

        <div class="form-group col-md-3">
            <label>Country</label>
            <input type="text" class="form-control" placeholder="Country" name="baddress[country]" required value="<?php echo $billingAddress->country; ?>">
        </div>
    </div>
    <br>

    <button style="color:white;" type="button" href="javascript:void(0)" onclick="submitForm(this); object.resetParams().setForm('#form').load();" class="btn btn-warning" name="billing">Add Billing Address</button>

    <script>
        function submitForm(button) {
            var form = $(button).closest('form');
            form.attr('action','<?php echo $this->getUrl()->getUrl('save', 'admin_customer_address'); ?>');
        }
    </script>