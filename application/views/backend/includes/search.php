<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
<div class="col-sm-3">
	<div class="form-group">
		<input type="text" name="keyword" placeholder="Từ khóa" class="form-control" maxlength="200" value="<?php echo $this->input->get('keyword'); ?>">
	</div>
</div>
<?php if(!(isset($is_status) && !$is_status)): ?>
	<div class="col-sm-3">
		<div class="form-group">
			<select class="form-control" name="status">
				<option value="">Trạng thái</option>
				<option value="1" <?php echo $this->input->get('status') == 1 ? 'selected' : ''; ?>>Hoạt động</option>
				<option value="0" <?php echo $this->input->get('status') != null && $this->input->get('status') == 0 ? 'selected' : ''; ?>>Ngưng hoạt động</option>
			</select>
		</div>
	</div>
<?php endif; ?>
<div class="col-sm-2">
	<button type="submit" class="btn btn-primary">Tìm kiếm</button>
</div>