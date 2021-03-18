<?php $images = $this->getImages();?>
<h1>Product Media</h1>
<hr><br>

<button onclick="updateData(this)" class="btn btn-warning" name="update">Update</button>
<button onclick="removeData(this)" class="btn btn-warning" name="remove">Remove</button>

<br><br><br>

<table class="table table-borderless">
		<thead>
			<tr>

				<th scope="col">ImageId</th>
				<th>Image</th>
                <th>Label</th>
				<th>Small</th>
				<th>Thumb</th>
				<th>Base</th>
				<th>Gallery</th>
				<th>Remove</th>
			</tr>
		</thead>
        <tbody>
            <?php if ($images): ?>
            <?php foreach ($images->data as $result): ?>
                <tr>
                    <th scope="row"> <?php echo $result->imageId; ?></th>
                    <td><img src="<?php echo $result->name; ?>" height="100px" width="80px"></td>
                    <td><input type="text" name="label[<?php echo $result->imageId; ?>]" value="<?php echo $result->label; ?>"></td>
                    <td><input type="radio" name="small" value="<?php echo $result->imageId; ?>" <?php if ($result->small == '1'): echo "checked";endif;?>></td>
                    <td><input type="radio" name="thumb" value="<?php echo $result->imageId; ?>" <?php if ($result->thumb == '1'): echo "checked";endif;?>></td>
                    <td><input type="radio" name="base" value="<?php echo $result->imageId; ?>" <?php if ($result->base == '1'): echo "checked";endif;?>></td>
                    <td><input type="checkbox" name="gallery[]" value="<?php echo $result->imageId; ?>" <?php if ($result->gallery == '1'): echo 'checked';endif;?>></td>
                    <td><input type="checkbox" name="remove[]" value="<?php echo $result->imageId; ?>"></td>
                </tr>
            <?php endforeach;?>
            <?php endif;?>
        </tbody>
</table>
<br><br><br>
<div class='form-row'>
    <div class="form-group col-md-4">
        <input class="" type="file" name="image">
    </div>
    <button type="button" onclick="uploadImage(this)" class="form-group col-md-2 btn btn-info">Upload Image</button>
</div>

<script>
    function uploadImage(button) {
        var form = $(button).closest('form');
        form.attr('action','<?php echo $this->getUrl()->getUrl('save', 'admin_product_media'); ?>');
        form.submit();
    }

    function updateData(button) {
        var form = $(button).closest('form');
        form.attr('action','<?php echo $this->getUrl()->getUrl('update', 'admin_product_media'); ?>');
        form.submit();
    }

    function removeData(button) {
        var form = $(button).closest('form');
        form.attr('action','<?php echo $this->getUrl()->getUrl('remove', 'admin_product_media'); ?>');
        form.submit();
    }
</script>
</form>