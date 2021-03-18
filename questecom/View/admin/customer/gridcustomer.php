<div class="container">

	<?php $customers = $this->getCustomers(); ?>

	<h1>Customers</h1>
	
	<hr>
	<a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form'); ?>">Add New Customer</a>
	
	<br><br>
	<table class="table table-borderless">
		
		<thead>
			
			<tr>
				<th scope="col">Customer Group</th>
				<th>Customer Id</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>Zip Code</th>
				<th>Status</th>
				<th colspan="2"></th>
			</tr>

		</thead>
		
		<tbody>
			<?php foreach ($customers->data as $result) : ?>
				
				<tr>
					<td> 
						<?php if($group = $this->getGroupName($result->groupId)) : ?>
						<?php echo $group ?>
						<?php else : ?>
						<?php echo 'not assigned' ?>
						<?php endif; ?>
					</td>
					<td> <?php echo $result->customerId ?> </td>
					<td> <?php echo $result->firstName ?> </td>
					<td> <?php echo $result->lastName ?> </td>
					<td> <?php echo $result->email ?> </td>
					<td> <?php echo $result->mobile ?> </td>
					<td> 
						<?php if($zip = $this->getZip($result->customerId)) : ?>
						<?php echo $zip ?>
						<?php else : ?>
						<?php echo 'not assigned' ?>
						<?php endif; ?>
					</td>

					<?php if ($result->status == 1) : ?>
						<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('status', NULL, ['id' => $result->customerId, 'status' => $result->status]); ?>"><?php echo 'Disable'; ?></a></td>
					<?php else : ?>
						<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('status', NULL, ['id' => $result->customerId, 'status' => $result->status]); ?>"><?php echo 'Enable'; ?></a></td>
					<?php endif; ?>

					<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form', NULL, ['id' => $result->customerId]); ?>">Edit</a></td>
					<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('delete', NULL, ['id' => $result->customerId]); ?>">Delete</a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
</div>