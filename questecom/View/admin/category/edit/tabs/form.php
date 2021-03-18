<?php if ($id = $this->getRequest()->getGet('id')) : ?>
    <h1>Update Category</h1>
<?php else : ?>
    <h1>Insert Category</h1>
<?php endif; ?>

<?php $options = $this->getCategoryOptions();?>
<?php $category = $this->getTableRow(); ?>

<hr><br>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Category Name</label>
            <input type="text" class="form-control" placeholder="Category Name" name="category[name]" required value="<?php echo $category->name;  ?>">
        </div>
    
        <div class="form-group col-md-4">
            <label>Parent Category</label>
            <select class="custom-select" name="category[parentId]" required>
                <?php if($options): ?>
                    <?php foreach($options as $categoryId => $name): ?>
                        <option value="<?php echo $categoryId; ?>" <?php if($categoryId == $category->parentId): ?> selected <?php endif; ?>> <?php echo $name; ?> </option>
                    <?php endforeach; ?>
                <?php endif; ?>  
            </select>
        </div>
    
        <div class="form-group col-md-4">
            <label>Status</label>
            <select class="custom-select" name="category[status]" required>
                <?php foreach ($category->getStatusOptions() as $key => $value) : ?>
                    <option value="<?php echo $key ?>" <?php if ($category->status == $key) { ?> selected <?php } ?>><?php echo $value; ?></option>
                <?php endforeach; ?>
 	        </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Description</label>
            <textarea name="category[description]" class="form-control" placeholder="Description About The Category" rows="5" required><?php echo $category->description;?></textarea>
        </div>
    </div>
  
    <br>
    <?php if ($id) : ?>
        <button class="btn btn-warning">Update category</button>
    <?php else : ?>
        <button class="btn btn-warning">Insert category</button>
    <?php endif; ?>
</form>
</div>