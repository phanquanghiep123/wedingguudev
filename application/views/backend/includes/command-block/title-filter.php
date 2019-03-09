<div class="x_title">
	<form action="" method="get">
		<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
		<div class="row">
			<div class="col-sm-4">
		    	<h2><?php echo @$title_page; ?> <a class="btn btn-success create-item" href="<?php echo backend_url(@$base_controller."/create");?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Thêm mới</a></h2>
		    </div>
			<?php if (!isset($is_search_keyword)) : ?>
			<div class="col-sm-3">
				<div class="form-group">
					<input type="text" name="keyword" placeholder="Từ khóa" class="form-control" maxlength="200" value="<?php echo $this->input->get('keyword'); ?>">
				</div>
	        </div>
			<?php endif; ?>
			<?php if (!isset($is_search_status)) : ?>
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
			<?php if (!isset($is_search_keyword) || !isset($is_search_status)) : ?>
	        <div class="col-sm-2">
				<button type="submit" class="btn btn-primary">Tìm kiếm</button>
	        </div>
			<?php endif; ?>
		</div>
	</form>
</div>