<div class="container" style="padding-left: 100px; padding-right: 100px;">

    <?php if ($id = $this->getRequest()->getGet('id')): ?>
        <h1>Update Cms</h1>
    <?php else: ?>
        <h1>Insert Cms</h1>
    <?php endif;?>

    <?php $cms = $this->getTableRow();?>

    <hr><br>

    <form method="post" id="cmsForm" action="<?php echo $this->getFormUrl(); ?>">

        <div class="form-row">

            <div class="form-group col-md-4">
                <label>Title</label>
                <input type="text" class="form-control" placeholder="Title" name="cms[title]" required value="<?php echo $cms->title; ?>">
            </div>

            <div class="form-group col-md-4">
                <label>Identifier</label>
                <input type="text" class="form-control" placeholder="Identifier" name="cms[identifier]" required value="<?php echo $cms->identifier ?>">
            </div>

            <div class="form-group col-md-4">
                <label>Status</label>
                <select class="custom-select" name="cms[status]" required>
                    <?php foreach ($cms->getStatusOptions() as $key => $value): ?>
                        <option value="<?php echo $key ?>" <?php if ($cms->status == $key): ?> selected <?php endif;?>><?php echo $value; ?></option>
                    <?php endforeach;?>
                </select>
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="adjoined-bottom">
		        <div class="grid-container">
			        <div class="grid-width-100">
				        <div id="editor">

				        </div>
			        </div>
		        </div>
	        </div>
        </div>
        </div>

        <br>
        <button style="color:white;" type="button" href="javascript:void(0)" onclick="getContent(); object.resetParams().setForm('#cmsForm').load()" class="btn btn-warning">Save Cms</button>

        <input type="hidden" id="myContent" name="cms[content]">
        <input type="hidden" id="setContent" value="<?php echo htmlentities($cms->content); ?>">

    </form>
</div>

<script>
	initSample();
    function getContent() {
    var data = CKEDITOR.instances.editor.getData();
    document.getElementById("myContent").value = data;
    }
    var setdata =  document.getElementById("setContent").value;
    CKEDITOR.instances['editor'].setData(setdata);
</script>

