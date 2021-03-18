<div class="container">

	<?php $categories = $this->getCategories(); ?>

	<h1>Categories</h1>
	
	<hr>
	<a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form','admin_category'); ?>">Add New Category</a>
	
	<br><br>
	<table class="table table-borderless">
		
		<thead>

			<tr>
				<th scope="col">Name</th>
				<th>Parent Id</th>
				<th>Path</th>
				<th>Discription</th>
				<th>Status</th>
				<th colspan="2"></th>
			</tr>

		</thead>
		
		<tbody>
			
			<?php if($categories) : ?>
				<?php foreach ($categories->data as $result) : ?>
					
					<tr>
						<td> <?php echo $this->getName($result) ?></td>
						<td> <?php echo $result->parentId ?></td>
						<td> <?php echo $result->path ?></td>
						<td> <?php echo $result->description ?></td>

						<?php if ($result->status == 1) : ?>
							<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('status', 'admin_category', ['id' => $result->categoryId, 'status' => $result->status]); ?>"><?php echo 'Disable'; ?></a></td>
						<?php else : ?>
							<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('status', 'admin_category', ['id' => $result->categoryId, 'status' => $result->status]); ?>"><?php echo 'Enable'; ?></a></td>
						<?php endif; ?>
						
						<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form', 'admin_category', ['id' => $result->categoryId]); ?>">Edit</a></td>
						<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('delete', 'admin_category', ['id' => $result->categoryId]); ?>">Delete</a></td>
					</tr>

				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan='5'> No Records At The Moment. Have A Nice Day. </td>
				</tr>
			<?php endif; ?>
		</tbody>
		
	</table>
</div>