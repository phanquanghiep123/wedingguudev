<div class="form-group text-right">
    <input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
    <a href="<?php echo backend_url($base_controller); ?>" class="btn btn-default">Quay lại</a>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</div>