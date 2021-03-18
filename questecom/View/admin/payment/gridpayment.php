<div class="container">

	<?php $payments = $this->getPayments(); ?>

	<h1>Payments</h1>
	
	<hr>
	<a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form'); ?>">Add New payment</a>
	
	<br><br>
	<table class="table table-borderless">
		
		<thead>
			<tr>

				<th scope="col">Name</th>
				<th>Code</th>
				<th>Discription</th>
				<th>Status</th>
				<th colspan="2"></th>
	
			</tr>
		</thead>
	
		<tbody>

			<?php if($payments == true) : ?>
				<?php foreach ($payments->data as $result) : ?>
					
					<tr>
						<td> <?php echo $result->name; ?> </td>
						<td> <?php echo $result->code; ?> </td>
						<td> <?php echo $result->description; ?> </td>

						<?php if ($result->status == 1) : ?>
							<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('status', NULL, ['id' => $result->methodId, 'status' => $result->status]); ?>"><?php echo 'Disable'; ?></a></td>
						<?php else : ?>
							<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('status', NULL, ['id' => $result->methodId, 'status' => $result->status]); ?>"><?php echo 'Enable'; ?></a></td>
						<?php endif; ?>

						<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form', NULL, ['id' => $result->methodId]); ?>">Edit</a></td>
						<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('delete', NULL, ['id' => $result->methodId]); ?>">Delete</a></td>
					
					</tr>

				<?php endforeach; ?>
			<?php else : ?>
				No Records At The Moment. Have A Nice Day.
			<?php endif; ?>

		</tbody>

	</table>
</div>