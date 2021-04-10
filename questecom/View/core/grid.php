<div class="container-fluid" style="padding-left:100px; padding-right:100px">

<?php $rows = $this->getCollection();?>
<?php $columns = $this->getColumns();?>
<?php $actions = $this->getActions();?>
<?php $status = $this->getStatus();?>
<?php $buttons = $this->getButtons();?>
<?php $primaryColumn = $this->getPrimaryColumn();?>
<?php $filters = $this->getFilters();?>
<?php $filterButtons = $this->getFilterButtons();?>

<form id="gridForm" method="post">
	<h1> <?php echo $this->setTitle() ?> </h1>
	<hr><br>

	<?php if ($buttons): ?>
		<?php foreach ($buttons as $key => $button): ?>
			<a type="button" style="<?php echo $button['style'] ?>" href="javascript:void(0)" class="<?php echo $button['class'] ?>" onclick="<?php echo $this->getButtonUrl($button['method']) ?>"><?php echo $button['label'] ?></a>
		<?php endforeach;?>
	<?php endif;?>
	<br><br>

	<table class="table table-borderless">
		<thead>
			<tr>
				<?php if ($filters): ?>
					<?php foreach ($filters as $key => $filter): ?>
						<th scope="col"><input type="text" class="<?php echo $filter['class']; ?>" name="<?php echo $filter['name'] ?>" style="<?php echo $filter['style'] ?>" value="<?php echo $filter['value'] ?>" placeholder="<?php echo $filter['placeholder'] ?>"></th>
					<?php endforeach;?>
				<?php endif?>

				<?php if ($filterButtons): ?>
					<?php foreach ($filterButtons as $key => $filters): ?>
						<th colspan="2" style="<?php echo $filters['style'] ?>"><a class="<?php echo $filters['class']; ?>" href="javascript:void(0);" onclick="<?php echo $this->getButtonUrl($filters['method']) ?>"><?php echo $filters['label'] ?></a></th>
					<?php endforeach;?>
				<?php endif?>
			</tr>

			<?php if ($rows): ?>
				<tr>
					<?php foreach ($columns as $column): ?>
						<th scope="col"> <?php echo $column['label'] ?></th>
					<?php endforeach;?>

					<?php if ($status): ?>
						<th scope="col">Status</th>
					<?php endif?>

					<?php if ($actions): ?>
						<?php foreach ($actions as $key => $action): ?>
							<th scope="col"><?php echo $action['label'] ?></th>
						<?php endforeach;?>
					<?php endif?>
				</tr>
		</thead>

		<tbody>
			<?php foreach ($rows->getData() as $row): ?>
				<tr>
					<?php foreach ($columns as $key => $column): ?>
				<td scope="row"> <?php echo $this->getFieldValue($row, $column['field']) ?></td>
			<?php endforeach;?>

			<?php if ($status): ?>
				<?php if ($row->status == '1'): ?>
					<td><a style="<?php echo $status[0]['style']; ?>" class="<?php echo $status[0]['class']; ?>" onClick="<?php echo $this->getMethodUrl($row, $status[0]['method']) ?>"><?php echo $status[0]['label'] ?></a></td>
				<?php else: ?>
					<td><a style="<?php echo $status[1]['style']; ?>" class="<?php echo $status[1]['class']; ?>" onClick="<?php echo $this->getMethodUrl($row, $status[1]['method']) ?>"><?php echo $status[1]['label'] ?></a></td>
				<?php endif;?>
			<?php endif;?>


			<?php if ($actions): ?>
				<?php foreach ($actions as $key => $action): ?>
					<td><a style="<?php echo $action['style']; ?>" class="<?php echo $action['class']; ?>" href="javascript:void(0)" onClick="<?php echo $this->getMethodUrl($row, $action['method']) ?>"><?php echo $action['label'] ?></a></td>
				<?php endforeach;?>
			<?php endif;?>

			<?php foreach ($primaryColumn as $key => $col): ?>
				<td><input type="checkbox" name="remove[]" value="<?php echo $this->getFieldValue($row, $col['field']) ?>"></td>
			<?php endforeach;?>

		</tr>
	<?php endforeach;?>

	<?php else: ?>
		no records available
	<?php endif;?>
</tbody>
</table>
</form>

<?php if ($this->getPager()->getPrevious()): ?>
	<a href="javascript:void(0);" type="button" onclick="object.resetParams().setUrl('<?php echo $this->getUrl()->getUrl(null, null, ['page' => $this->getPager()->getPrevious()]) ?>').load();">Privious</a>
<?php endif?>

<a href="javascript:void(0);" class="active"><?php echo $this->getPager()->getCurrentPage(); ?></a>

<?php if ($this->getPager()->getNext()): ?>
	<a href="javascript:void(0);" onclick="object.resetParams().setUrl('<?php echo $this->getUrl()->getUrl(null, null, ['page' => $this->getPager()->getNext()]) ?>').load();">Next</a>
<?php endif?>




<script>

function removeData(button)
{
	var form = $(button).closest('form');
	form.attr('action','<?php echo $this->getUrl()->getUrl('remove', $this->keepController()); ?>');
}

function applyData(button)
{
	var form = $(button).closest('form');
	form.attr('action','<?php echo $this->getUrl()->getUrl('filter', 'admin_filter'); ?>');
}

function setText()
{
	var fill = $(".clear").each(function(){
	alert(111);
	});
}

</script>