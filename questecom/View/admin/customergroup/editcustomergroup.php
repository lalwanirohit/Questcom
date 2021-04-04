<div class="container" style="padding-left: 100px; padding-right: 100px;">

    <?php if ($id = $this->getRequest()->getGet('id')): ?>
        <h1>Update Customer Group</h1>
    <?php else: ?>
        <h1>Insert Customer Group</h1>
    <?php endif;?>

    <?php $group = $this->getTableRow();?>

    <hr><br>
    <form method="post" id="groupForm" action="<?php echo $this->getFormUrl(); ?>">

        <div class="form-row">

            <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name" name="group[name]" required value="<?php echo $group->name; ?>">
            </div>

            <div class="form-group col-md-6">
                <label>Status</label>
                <select class="custom-select" name="group[status]" required>

                    <?php foreach ($group->getStatusOptions() as $key => $value): ?>
                        <option value="<?php echo $key ?>" <?php if ($group->status == $key): ?> selected <?php endif;?>><?php echo $value; ?></option>
                    <?php endforeach;?>

                </select>
            </div>

        </div>

        <br>
        <button type="button" href="javascript:void(0)" onclick="object.resetParams().setForm('#groupForm').load();" class="btn btn-warning">Save Customer Group</button>
    </form>
</div>