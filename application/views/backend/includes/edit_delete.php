<?php if(@$is_edit == 1): ?>
	<a href="<?php echo backend_url(@$base_controller.'/edit/'.@$id)?>">Chỉnh sửa</a> 
<?php endif; ?>
<?php if(@$is_edit == 1 && @$is_delete == 1): ?>
	|
<?php endif; ?>
<?php if(@$is_delete == 1): ?>
	<a onclick="return confirm('Bạn có thật sự muốn xóa?');" href="<?php echo backend_url(@$base_controller.'/delete/'.@$id)?>">Xóa</a>
<?php endif; ?>