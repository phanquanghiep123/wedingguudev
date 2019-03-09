<div class="table-responsive">
	<table class="table table-striped jambo_table bulk_action">
		<thead>
			<tr class="headings">
				<th>#</th>
				<th>Họ và tên</th>
				<th>Email</th>
				<th>Trạng thái</th>
				<th>Ngày tạo</th>
			</tr>
		</thead>
		<tbody>
		    <?php if (isset($collection_child)): ?>
	        	<?php foreach ($collection_child as $key_child => $item_child) : ?>
		    		<tr>
						<td><?php echo ($key_child+1);?> </td>
						<td><?php echo @$item_child["first_name"].' '. @$item_child["last_name"]; ?></td>
						<td><?php echo @$item_child["email"]; ?></td>
						<td><?php echo @$item_child["status"] == 1 ? 'Hoạt động' : 'Ngưng hoạt động'; ?></td>
						<td><?php echo date("d/m/Y, g:i A",strtotime($item_child["created_at"])); ?></td>
					</tr>
		    	<?php endforeach; ?>
		    <?php endif; ?>
		</tbody>
	</table>
</div>