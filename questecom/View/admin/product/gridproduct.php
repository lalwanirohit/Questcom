<div class="container">
	<?php $products = $this->getProducts(); ?>
	
	<h1>Products</h1>
	<hr>
	<a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form','admin_product'); ?>">Add New Product</a>
	
	<br><br>
	<table class="table table-borderless">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th>Price</th>
				<th>Discount</th>
				<th>Quantity</th>
				<th>Discription</th>
				<th>SKU</th>
				<th>Status</th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($products->data as $result) : ?>
				<tr>
					<th scope='row'> <?php echo $result->productId; ?> </th>
					<td> <?php echo $result->name; ?> </td>
					<td> <?php echo $result->price; ?> </td>
					<td> <?php echo $result->discount; ?> </td>
					<td> <?php echo $result->quantity; ?> </td>
					<td> <?php echo $result->description; ?> </td>
					<td> <?php echo $result->sku; ?> </td>
				
					<?php if ($result->status == 1) : ?>
						<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('status', NULL, ['id' => $result->productId, 'status' => $result->status]); ?>"><?php echo 'Disable'; ?></a></td>
					<?php else : ?>
						<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('status', NULL, ['id' => $result->productId, 'status' => $result->status]); ?>"><?php echo 'Enable'; ?></a></td>
					<?php endif; ?>
					
					<td><a class="btn btn-info" href="<?php echo $this->getUrl()->getUrl('form', NULL, ['id' => $result->productId]); ?>">Edit</a></td>
					<td><a class="btn btn-danger" href="<?php echo $this->getUrl()->getUrl('delete', NULL, ['id' => $result->productId]); ?>">Delete</a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>