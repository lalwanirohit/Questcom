<?php if ($id = $this->getRequest()->getGet('id')): ?>
    <h1>Update Product</h1>
<?php else: ?>
    <h1>Insert Product</h1>
<?php endif;?>

<?php $product = $this->getTableRow();?>
<?php $brands = $this->getBrands();?>

<hr><br>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Product Name</label>
            <input type="text" class="form-control" placeholder="Product Name" name="product[name]" required value="<?php echo $product->name; ?>">
        </div>

        <div class="form-group col-md-4">
            <label>Product Brand</label>
            <select class="custom-select" name="product[brandId]" required>
                <option value="">Select Brand</option>
                <?php foreach ($brands->data as $key): ?>
                    <option value="<?php echo $key->brandId ?>" <?php if ($product->brandId == $key->brandId): ?> selected <?php endif;?>><?php echo $key->brandName; ?></option>
                <?php endforeach;?>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label>Status</label>
            <select class="custom-select" name="product[status]" required>
                <?php foreach ($product->getStatusOptions() as $key => $value): ?>
                    <option value="<?php echo $key ?>" <?php if ($product->status == $key): ?> selected <?php endif;?>><?php echo $value; ?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Product Price</label>
            <input type="text" class="form-control"  placeholder="Product Price" name="product[price]" required value="<?php echo $product->price ?>">
        </div>

        <div class="form-group col-md-4">
            <label>Discount</label>
            <input type="text" class="form-control" placeholder="Discount" name="product[discount]" required value="<?php echo $product->discount ?>">
        </div>

        <div class="form-group col-md-4">
            <label>Quantity</label>
            <input type="text" class="form-control"  placeholder="Quantity" name="product[quantity]" required value="<?php echo $product->quantity ?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Description</label>
            <textarea class="form-control" placeholder="Description" name="product[description]" rows="5" required><?php echo $product->description ?></textarea>
        </div>
    </div>

    <br>
    <button style="color:white;" type="button" href="javascript:void(0)" onclick="submitForm(this); object.resetParams().setForm('#form').load();" class="btn btn-warning">Save Product</button>

    <script>
        function submitForm(button) {
            var form = $(button).closest('form');
            form.attr('action',"<?php echo $this->getUrl()->getUrl('save', 'admin_product'); ?>");
        }
    </script>