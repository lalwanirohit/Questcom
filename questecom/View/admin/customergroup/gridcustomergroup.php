<div class="container">
		<?php $customerGroups = $this->getCustomerGroups(); ?>

		<h1>Customer Groups</h1>
		
		<hr>
		<a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form'); ?>">Add New Customer Group</a>

		<br><br>
		<table class="table table-borderless">

		<thead>	
			<tr>

				<th scope="col">Name</th>
				<th>Status</th>
				<th>Created At</th>
				<th colspan="2"></th>

			</tr>
		</thead>

		<tbody>

			<?php if($customerGroups == true) : ?> 
				<?php foreach ($customerGroups->data as $result) : ?>
					
					<tr>
						<td> <?php echo $result->name; ?> </td>
						<td> <?php echo $result->status; ?> </td>
						<td> <?php echo $result->createdAt; ?> </td>

						<?php if ($result->status == 1) : ?>
							<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('status', NULL, ['id' => $result->groupId, 'status' => $result->status]); ?>"><?php echo 'Disable'; ?></a></td>
						<?php else : ?>
							<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('status', NULL, ['id' => $result->groupId, 'status' => $result->status]); ?>"><?php echo 'Enable'; ?></a></td>
						<?php endif; ?>

						<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form', NULL, ['id' => $result->groupId]); ?>">Edit</a></td>
						<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('delete', NULL, ['id' => $result->groupId]); ?>">Delete</a></td>
				
					</tr>

				<?php endforeach; ?>
			<?php else : ?>
				No Records At The Moment. Have A Nice Day.
			<?php endif; ?>
		</tbody>	
	</table>
</div>