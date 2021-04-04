<div class="container">
	<table width="">
		<tbody>
			<tr>
				<?php if ($this->getRequest()->getGet('id')): ?>

				<td width="200px">
					<?php echo $this->getTabHtml(); ?>
				</td>

				<td width="800px">
				<?php else: ?>
				<td width="1000px" style="padding-left: 100px;">
				<?php endif;?>
	    			<form method="POST" id="form" enctype="multipart/form-data">
	        			<?php echo $this->getTabContent(); ?>
	    			</form>
				</td>
			</tr>
		</tbody>
	</table>
</div>


