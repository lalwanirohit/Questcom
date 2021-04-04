<?php $images = $this->getImages();?>
<h1>Category Media</h1>
<hr><br>

<button type="button" href="javascript:void(0)" onclick="updateData(this); object.resetParams().setForm('#form').load();" class="btn btn-warning" name="update">Update</button>
<button type="button" href="javascript:void(0)" onclick="removeData(this); object.resetParams().setForm('#form').load();" class="btn btn-warning" name="remove">Remove</button>

<br><br><br>

<table class="table table-borderless">
		<thead>
			<tr>
				<th scope="col">Image Id</th>
				<th>Image</th>
                <th>Label</th>
				<th>Icon</th>
				<th>Base</th>
				<th>Banner</th>
				<th>Remove</th>
			</tr>
		</thead>
        <tbody>
            <?php if ($images): ?>
            <?php foreach ($images->data as $result): ?>
                <tr>
                    <th scope="row"> <?php echo $result->mediaId; ?></th>
                    <td><img src="media/categories/<?php echo $result->name; ?>" height="100px" width="80px"></td>
                    <td><input type="text" name="label[<?php echo $result->mediaId; ?>]" placeholder="enter Label for image" value="<?php echo $result->label; ?>"></td>
                    <td><input type="radio" name="icon" value="<?php echo $result->mediaId; ?>" <?php if ($result->icon == '1'): echo "checked";endif;?>></td>
                    <td><input type="radio" name="base" value="<?php echo $result->mediaId; ?>" <?php if ($result->base == '1'): echo "checked";endif;?>></td>
                    <td><input type="checkbox" name="banner[]" value="<?php echo $result->mediaId; ?>" <?php if ($result->banner == '1'): echo "checked";endif;?>></td>
                    <td><input type="checkbox" name="remove[]" value="<?php echo $result->mediaId; ?>"></td>
                </tr>
            <?php endforeach;?>
            <?php endif;?>
        </tbody>
</table>
<br><br><br>
<div class='form-row'>
    <div class="form-group col-md-4">
        <input class="" type="file" id="file" name="file">
    </div>
    <button type="button" href="javascript:void(0)" id="imageUpload" class="form-group col-md-2 btn btn-info">Upload Image</button>
</div>

<script>

    function updateData(button) {
        var form = $(button).closest('form');
        form.attr('action','<?php echo $this->getUrl()->getUrl('update', 'admin_category_media'); ?>');
    }

    function removeData(button) {
        var form = $(button).closest('form');
        form.attr('action','<?php echo $this->getUrl()->getUrl('remove', 'admin_category_media'); ?>');
    }

    $(document).ready(function(){

    $("#imageUpload").click(function(){
        object.setUrl('<?php echo $this->getUrl()->getUrl("save", "admin_category_media"); ?>');
        var fd = new FormData();
        var files = $('#file')[0].files;

        if(files.length > 0 ){
        fd.append('file',files[0]);

        $.ajax({
            url: object.getUrl(),
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                $.each(response.element, function (i, element) {
                    $(element.selector).html(element.html);
                });
            },

        });
    }else{
        alert("Please select a file.");
        }
    });
    });
</script>