<div class="container">

	<?php $attributes = $this->getAttributes(); ?>

	<h1>Attributes</h1>
	<hr>

	<a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form'); ?>">Add New Admin</a>

	<br><br>

	<table class="table table-borderless">

		<thead>
			<tr>

				<th scope="col">Attribute Id</th>
				<th>Entiy Type Id</th>
				<th>Name</th>
				<th>Code</th>
				<th>Input Type</th>
				<th>Backend Type</th>
				<th>Sort Order</th>
				<th>Backend Model</th>
				<th colspan="2"></th>

			</tr>
		</thead>

		<tbody>
			<?php if ($attributes == true) : ?>
				<?php foreach ($attributes->getData() as $result) : ?>
				
					<tr>
						<td> <?php echo $result->attributeId; ?> </td>
						<td> <?php echo $result->entityTypeId; ?> </td>
						<td> <?php echo $result->name; ?> </td>
						<td> <?php echo $result->code; ?> </td>
						<td> <?php echo $result->inputType; ?> </td> 
						<td> <?php echo $result->backendType; ?> </td> 
						<td> <?php echo $result->sortOrder; ?> </td> 
						<td> <?php echo $result->backendModel; ?> </td> 

						<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form', null, ['id' => $result->attributeId]); ?>">Edit</a></td>
						<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('delete', null, ['id' => $result->attributeId]); ?>">Delete</a></td>

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