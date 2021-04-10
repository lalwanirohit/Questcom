<div class="container-fluid" style="padding-left:100px; padding-right:100px">
<form id="categoryForm" method="post">
	<?php $categories = $this->getCategories();?>

	<h1>Categories</h1>
	<hr>
	<br>
	<a class="btn btn-info" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('form', 'admin_category'); ?>').resetParams().load()">Add New Category</a>
	<a class="btn btn-danger" href="javascript:void(0)" onclick="removeData(this); object.resetParams().setForm('#categoryForm').load();">Remove Selected</a>
	<br><br>
	<table class="table table-borderless">

		<thead>

			<tr>
				<th scope="col">Name</th>
				<th>Parent Id</th>
				<th>Path</th>
				<th>Discription</th>
				<th>Status</th>
			</tr>

		</thead>

		<tbody>

			<?php if ($categories): ?>
				<?php foreach ($categories->data as $result): ?>

					<tr>
						<td> <?php echo $this->getName($result) ?></td>
						<td> <?php echo $result->parentId ?></td>
						<td> <?php echo $result->path ?></td>
						<td> <?php echo $result->description ?></td>

						<?php if ($result->status == 1): ?>
							<td><a class="btn btn-danger" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('status', 'admin_category', ['id' => $result->categoryId, 'status' => $result->status]); ?>').resetParams().load()"><?php echo 'Disable'; ?></a></td>
						<?php else: ?>
							<td><a class="btn btn-info" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('status', 'admin_category', ['id' => $result->categoryId, 'status' => $result->status]); ?>').resetParams().load()"><?php echo 'Enable'; ?></a></td>
						<?php endif;?>

						<td><a class="btn btn-info" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('form', 'admin_category', ['id' => $result->categoryId]); ?>').resetParams().load()">Edit</a></td>
						<td><a class="btn btn-danger" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('delete', 'admin_category', ['id' => $result->categoryId]); ?>').resetParams().load()">Delete</a></td>
						<td><input type="checkbox" name="remove[]" value="<?php echo $result->categoryId ?>"></td>
					</tr>

				<?php endforeach;?>
			<?php else: ?>
				<tr>
					<td colspan='5'> No Records At The Moment. Have A Nice Day. </td>
				</tr>
			<?php endif;?>
		</tbody>

	</table>
	</form>
</div>

<script>
function removeData(button) {
	var form = $(button).closest('form');
	form.attr('action','<?php echo $this->getUrl()->getUrl('remove', 'admin_category'); ?>');
}
</script>