<div class="container">

	<?php $admins = $this->getAdmins(); ?>

	<h1>Admins</h1>
	<hr>

	<a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form'); ?>">Add New Admin</a>

	<br><br>

	<table class="table table-borderless">

		<thead>
			<tr>

				<th scope="col">Name</th>
				<th>Password</th>
				<th>Created At</th>
				<th>Status</th>
				<th colspan="2"></th>

			</tr>
		</thead>

		<tbody>
			<?php if ($admins == true) : ?>
				<?php foreach ($admins->getData() as $result) : ?>
				
					<tr>
						<td> <?php echo $result->userName; ?> </td>
						<td> <?php echo $result->password; ?> </td>
						<td> <?php echo $result->createdAt; ?> </td>
						<td> <?php echo $result->status; ?> </td> 

						<?php if ($result->status == 1) : ?>
							<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('status', null, ['id' => $result->adminId, 'status' => $result->status]); ?>"><?php echo 'Disable'; ?></a></td>
						<?php else : ?>
							<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('status', null, ['id' => $result->adminId, 'status' => $result->status]); ?>"><?php echo 'Enable'; ?></a></td>
						<?php endif; ?>

						<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form', null, ['id' => $result->adminId]); ?>">Edit</a></td>
						<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('delete', null, ['id' => $result->adminId]); ?>">Delete</a></td>

					</tr>
			
				<?php endforeach; ?>
			<?php else : ?>
					<tr>
						<td colspan='4'> No Records At The Moment. Have A Nice Day. </td>
					</tr>
			<?php endif; ?>

		</tbody>

	</table>
</div>