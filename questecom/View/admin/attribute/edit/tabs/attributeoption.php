    <div class="float-right mb-2 mr-2">
    <button type="button" href="javascript:void(0)" onclick="submitForm(this); object.resetParams().setForm('#form').load();" class="btn btn-success text-left mt-3 mb-2">Update</button>
    <!-- <button onclick="updateData(this)" class="btn btn-warning" id="update" name="update">Update</button> -->

    </div><br>
    <!-- <div class="h2 text-center mb-2" > -->
        <h1>Attribute Options</h1><br>
    <!-- </div> -->
    <?php $attribute = $this->getAttribute();?>
    <?php if (!empty($attribute)): ?>
    <table id="existingOption" class="table table-borderless">
        <?php foreach ($attribute->getData() as $key => $option): ?>
            <tr>
                <div class="form-row">
                    <div class="col-lg-4">
                        <td><input type="text" name="exist[<?php echo $option->optionId; ?>][name]" class="form-control" value="<?php echo $option->name; ?>"></td>
                    </div>
                    <div class="col-lg-4 ">
                        <td><input type="text" name="exist[<?php echo $option->optionId; ?>][sortOrder]" class="form-control" value="<?php echo $option->sortOrder; ?>"></td>
                    </div>
                    <div class="col-lg-4">
                        <td><button type="submit" class="btn btn-danger text-left" onclick="removeOption(this)">Remove Option</button></td>
                    </div>
                </div>
            </tr>
        <?php endforeach;?>
    </table>
    <?php else: ?>
        <table id="existingOption" class="table table-borderless">
        <tr>
            <div class="form-row">
                <div class="col-lg-4">
                    <td><input type="text" name="new[]" class="form-control" require></td>
                </div>
                <div class="col-lg-4 ">
                    <td><input type="text" name="new[]" class="form-control" require></td>
                </div>
                <div class="col-lg-4">
                    <td><button type="submit" class="btn btn-danger text-left" onclick="removeOption(this)">Remove Option</button></td>
                </div>
            </div>
        </tr>
    </table>
    <?php endif;?>
</form>
<div style="display:none;">
    <table id="newOption" class="table table-borderless">
        <tr>
            <div class="form-row">
                <div class="col-lg-4">
                    <td><input type="text" name="new[]" class="form-control" require></td>
                </div>
                <div class="col-lg-4 ">
                    <td><input type="text" name="new[]" class="form-control" require></td>
                </div>
                <div class="col-lg-4">
                    <td><button type="submit" class="btn btn-danger text-left" onclick="removeOption(this)">Remove Option</button></td>
                </div>
            </div>
        </tr>
    </table>
</div>
<div class="float-right mb-2 mr-2">
    <button type="button" class="btn btn-success text-left mt-3 mb-2" onclick="addRow()">Add Options</button>
</div>
<script>
    function removeOption(button){
        var objectTr = $(button).closest('tr');
        objectTr.remove();
    }

    // function updateData(button) {
    // var form = $(button).closest('form');
    // form.attr('action','<?php echo $this->getUrl()->getUrl('save', 'admin_attribute_option'); ?>');
    // // form.submit();
    // }

    function submitForm(button){
        var form = $(button).closest('form');
        form.attr('action', "<?php echo $this->getUrl()->getUrl('save', 'admin_attribute_option'); ?>");
    }

    function addRow(){
        var newOptionTable = document.getElementById('newOption');
        var existingOptionTable = document.getElementById('existingOption').children[0];
        existingOptionTable.appendChild(newOptionTable.children[0].children[0].cloneNode(true));
    }
</script>









































<?php
/*

<?php $attributeOptions = $this->getAttributeOptions();?>

<?php echo "<pre>"; ?>
<?php print_r($attributeOptions);?>
<h1>Attribute Options</h1>

<hr><br>
<div style="float:right;">
<button onclick="updateData(this)" class="btn btn-warning" id="update" name="update">Update</button>

<!-- <button type="button" class="btn btn-primary" name="update" onclick="setAction(this); object.resetParams().setForm('#attributeForm').load();">Update</button>&nbsp;&nbsp;&nbsp;&nbsp; -->
</div>
<br><br>
<div class="container">
<table class="table" id="exist">
<tbody>
<?php if ($attributeOptions): ?>
<?php foreach ($attributeOptions->getData() as $key => $result): ?>
<tr>
<?php if ($result->optionId): ?>
<input type="hidden" value="<?php echo $result->optionId; ?>" name="attributeOption[<?php echo $key; ?>][optionId]">
<?php endif;?>
<td><input type="text" class="form-control" placeholder="Enter Option Name " name="attributeOption[<?php echo $key; ?>][name]" required value="<?php echo $result->name; ?>"></td>
<td><input type="text" class="form-control" placeholder="Enter Option Name " name="attributeOption[<?php echo $key; ?>][sortOrder]" required value="<?php echo $result->sortOrder; ?>"></td>
<td><button type="button" class="btn btn-Danger" onclick="deleteRow(this);">Delete</button></td>
</tr>
<?php endforeach;?>
<?php endif;?>
</tbody>
</table>

<button type="button" class="btn btn-primary" style="float: right;" onclick="addRow()">Add New</button>
</div>

<script type="text/javascript">

function setAction(button){
var form = $(button).closest('form');
form.attr('action', "<?php echo $this->getUrl()->getUrl('save', 'Admin_Attribute_AttributeOption'); ?>");
}

function deleteRow(button){
$(button).closest('tr').remove();
}
function addRow() {
var existing = document.getElementById('exist').children[0];
var newrow = document.getElementById('new');
existing.appendChild(newrow.children[0].children[0].cloneNode(true));
}
</script>

 */
?>





























<?php
/*
<?php $attributes = $this->getTableRow();?>

<button onclick="updateData(this)" class="btn btn-warning" id="update" name="update">Update</button>
<br><br><br>

<table id="exist">
<tbody>
<?php if ($attributes): ?>

<?php foreach ($attributes->getData() as $key => $result): ?>
<tr>
<td><input class="form-control" type="text" name="exist[<?php echo $result->optionId; ?>][name]" value="<?php echo $result->name; ?>"></td>
<td><input class="form-control" type="text" name="exist[<?php echo $result->optionId; ?>][sortOrder]" value="<?php echo $result->sortOrder; ?>"></td>
<td><button type="button" class="btn btn-danger" onclick="deleteRow(this);">Delete</button></td>
</tr>
<?php endforeach;?>
<?php else: ?>
<table id="exist">
<tbody>
<tr>
<td><input class="form-control" type="text" placeholder="Enter Option Name " name="new[]"></td>
<td><input class="form-control" type="text" placeholder="Enter Sort Order " name="new[]"></td>
<td><button type="button" class="btn btn-danger" onclick="deleteRow(this);">Delete</button></td>
</tr>
</tbody>
</table>
<?php endif;?>

</tbody>
</table>

<button type="button" class="btn btn-info" style="float: right;" onclick="addRow()">Add New</button>

<div style="display: none;">
<table id="new">
<tbody>
<tr>
<td><input class="form-control" type="text" placeholder="Enter Option Name " name="new[]"></td>
<td><input class="form-control" type="text" placeholder="Enter Sort Order " name="new[]"></td>
<td><button type="button" class="btn btn-danger" onclick="deleteRow(this);">Delete</button></td>
</tr>
</tbody>
</table>
</div>

<script>
function updateData(button) {
var form = $(button).closest('form');
form.attr('action','<?php echo $this->getUrl()->getUrl('save', 'admin_attribute_option'); ?>');
form.submit();
}

function deleteRow(button){
$(button).closest('tr').remove();
}

function addRow() {
var existing = document.getElementById('exist').children[0];
var newrow = document.getElementById('new');
existing.appendChild(newrow.children[0].children[0].cloneNode(true));
}
</script>

 */
?>