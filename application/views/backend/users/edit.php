<div class="main-page <?php echo @$main_page;?>">
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
    		<div class="x_panel">
    			<div class="x_title">
    				<div class="row">
                        <div class="col-sm-12">
                            <h2>
                                <?php echo @$label; ?> 
                                <?php $this->load->view(@$backend_asset.'/includes/add_new',array('is_add' => @$is_add,'base_controller' => @$base_controller)); ?> 
                            </h2>
                        </div>            
                    </div>
    			</div>
    			<div class="x_content">
    				<form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo $this->session->flashdata('message');
                            } 
                            if($this->session->flashdata('record') && @$record == null){
                                $record = $this->session->flashdata('record');
                            }
                        ?>
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" name="last_name" class="form-control required" value="<?php echo @$record['last_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control required" value="<?php echo @$record['email']; ?>" <?php echo @$action == 'edit' ? 'disabled' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label>Ảnh đại diện</label>
                            <div class="featured-image <?php echo @$record['avatar']!= null ? 'active' : ''; ?>">
                                <span class="remove-featured-image" onclick="ClearFileCustom(this);" title="Xóa ảnh">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </span>
                                <a href="#" onclick="BrowseServerCustom(this);return false;">
                                    <i class="fa fa-plus" title="Chọn ảnh"></i>
                                </a>
                                <img src="<?php echo @$record['avatar']; ?>">
                                <input name="avatar" value="<?php echo @$record['avatar']; ?>" type="hidden" size="60" class="form-control xImagePath">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo @$record['phone']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <select class="form-control required" name="gender">
                                <option value="1" <?php echo @$record['gender'] == 1 ? 'selected' : ''; ?>>Nam</option>
                                <option value="0" <?php echo @$record['gender']!= null && @$record['gender'] == 0 ? 'selected' : ''; ?>>Nữ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ngày cưới</label>
                            <input type="text" name="wedding_date" class="form-control datetimepicker" value="<?php echo @$record['wedding_date'] != null ? date('Y-m-d',strtotime(@$record['wedding_date'])) : ''; ?>">
                        </div>
                        
                        <?php /*
                        <div class="form-group">
                            <label>Quốc gia</label>
                            <input type="text" name="country_name" class="form-control" value="<?php echo @$record['country_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Múi giờ</label>
                            <?php $timezone_list = get_timezone_list(); ?>
                            <select class="form-control required" name="country_timezone">
                                <?php foreach ($timezone_list as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo @$record['country_timezone'] == $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Liên kết</label>
                            <input type="text" name="url" class="form-control" value="<?php echo @$record['url']; ?>">
                        </div>*/ ?>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <input id="is_newsletter" type="checkbox" <?php echo @$record['is_newsletter'] == 1 ? 'checked' : ''; ?> name="is_newsletter" value="1">
                            <label for="is_newsletter">Nhận bản tin</label>
                        </div>
                        <div class="form-group">
                            <input id="is_premium" type="checkbox" <?php echo @$record['is_premium'] == 1 ? 'checked' : ''; ?> name="is_premium" value="1">
                            <label for="is_premium">Tài khoản Premium</label>
                        </div>
                        <?php if(@$action == 'edit'): ?>
                            <div class="form-group">
                                <label>Gói dịch vụ</label>
                                <select class="form-control" name="package">
                                    <option value="">Chọn gói dịch vụ</option>
                                    <?php if(isset($package) && $package != null): ?>
                                        <?php foreach ($package as $key => $item): ?>
                                            <?php if($item['price'] > 0): ?>
                                                <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ngày hết hạn</label>
                                <input type="text" class="form-control" value="<?php echo @$record['expired_date'] != null ? date('d/m/Y',strtotime(@$record['expired_date'])) : ''; ?>" readonly>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control required" name="status">
                                <option value="1" <?php echo @$record['status'] == 1 ? 'selected' : ''; ?>>Hoạt động</option>
                                <option value="0" <?php echo @$record['status']!= null && @$record['status'] == 0 ? 'selected' : ''; ?>>Ngưng hoạt động</option>
                            </select>
                        </div>
                        <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
    				</form>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<link href="<?php echo skin_url('backend/bootstrap-datepicker/css/bootstrap-datepicker.css'); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo skin_url('backend/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
    $(function () {
        $('.datetimepicker').datepicker({ format: 'yyyy-mm-dd' });
    });
</script>