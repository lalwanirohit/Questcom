<div class="container" style="padding-left: 100px; padding-right: 100px;">

    <?php if ($id = $this->getRequest()->getGet('id')): ?>
        <h1>Update Brand</h1>
    <?php else: ?>
        <h1>Insert Brand</h1>
    <?php endif;?>

    <?php $brand = $this->getTableRow();?>

    <hr><br>

    <form method="post" id="brandForm" enctype="multipart/form-data">

        <div class="form-row">

            <div class="form-group col-md-6">
                <label>Brand Name</label>
                <input type="text" class="form-control" id="brandName" placeholder="name" name="brandName" required value="<?php echo $brand->brandName; ?>">
            </div>

            <div class="form-group col-md-6">
                <label>Status</label>
                <select class="custom-select" id="status" name="status" required>
                    <?php foreach ($brand->getStatusOptions() as $key => $value): ?>
                        <option value="<?php echo $key ?>" <?php if ($brand->status == $key): ?> selected <?php endif;?>><?php echo $value; ?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-row">

            <div class="form-group col-md-4">
                <label>Brand Image</label>
                <input type="file" name="file" id="file">
            </div>
        </div>

        <br>
        <button style="color:white;" class="btn btn-warning" href="javascript:void(0)" type="button" id="brandUpload">Save Brand</button>

<script>
$(document).ready(function(){

$("#brandUpload").click(function(){
    object.setUrl('<?php echo $this->getUrl()->getUrl("save", "admin_brand"); ?>');
    var fd = new FormData();
    var files = $('#file')[0].files;
    var brand = document.getElementById('brandName').value;
    var status = document.getElementById('status').value;

    if(files.length > 0 ){
    fd.append('file',files[0]);
    fd.append('brand',brand);
    fd.append('status',status);

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