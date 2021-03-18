<div class="container">

    <?php if ($id = $this->getRequest()->getGet('id')): ?>
        <h1>Update Admin</h1>
    <?php else: ?>
        <h1>Insert Admin</h1>
    <?php endif;?>

    <?php $admin = $this->getTableRow();?>
    <hr><br>

            <div class="form-row">

                <div class="form-group col-md-4">
                    <label>Admin Name</label>
                    <input type="text" class="form-control" placeholder="Admin Name" name="admin[userName]" required value="<?php echo $admin->userName; ?>">
                </div>

                <div class="form-group col-md-4">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="admin[password]" required value="<?php echo $admin->password ?>">
                </div>

                <div class="form-group col-md-4">
                    <label>Status</label>
                    <select class="custom-select" name="admin[status]" required>

                        <?php foreach ($admin->getStatusOptions() as $key => $value): ?>
                            <option value="<?php echo $key ?>" <?php if ($admin->status == $key): ?> selected <?php endif;?>><?php echo $value; ?></option>
                        <?php endforeach;?>

                    </select>
                </div>

            </div>

            <br>
            <?php if ($id): ?>
                <button class="btn btn-warning">Update Admin</button>
            <?php else: ?>
                <button class="btn btn-warning">Insert Admin</button>
            <?php endif;?>

</div>