<div class="container">

	<?php $cmss = $this->getCmss(); ?>

	<h1>Cms</h1>
	<hr>

	<a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form'); ?>">Add New Admin</a>
	
	<br><br>
	<table class="table table-borderless">

		<thead>

			<tr>
				<th scope="col">Page Id</th>
				<th>Title</th>
				<th>Identifier</th>
				<th>Content</th>
				<th>Status</th>
				<th>Created At</th>
				<th colspan="2"></th>
			</tr>

		</thead>

		<tbody>

			<?php if ($cmss == true) : ?>
				<?php foreach ($cmss->data as $result) : ?>
					
					<tr>
					
						<td> <?php echo $result->pageId; ?> </td>
						<td> <?php echo $result->title; ?> </td>
						<td> <?php echo $result->identifier; ?> </td>
						<td> <?php echo $result->content; ?> </td>
						<td> <?php echo $result->status; ?> </td>
						<td> <?php echo $result->createdAt; ?> </td>

						<?php if ($result->status == 1) : ?>
							<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('status', null, ['id' => $result->pageId, 'status' => $result->status]); ?>"><?php echo 'Disable'; ?></a></td>
						<?php else : ?>
							<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('status', null, ['id' => $result->pageId, 'status' => $result->status]); ?>"><?php echo 'Enable'; ?></a></td>
						<?php endif; ?>

						<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form', null, ['id' => $result->pageId]); ?>">Edit</a></td>
						<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('delete', null, ['id' => $result->pageId]); ?>">Delete</a></td>
					
					</tr>
					
				<?php endforeach; ?>
			<?php else : ?>
				No Records At The Moment. Have A Nice Day.
			<?php endif; ?>

		</tbody>
	</table>
</div>