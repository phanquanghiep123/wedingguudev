<div class="main-page <?php echo @$main_page;?>">
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
    		<div class="x_panel">
    			<div class="x_title">
    				<div class="row">
                        <div class="col-sm-12">
                            <h2>Chi tiết lịch sử thanh toán</h2>
                        </div>            
                    </div>
    			</div>
    			<div class="x_content">
                    <form method="post">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo $this->session->flashdata('message');
                            } 
                        ?>
    				    <div class="form-group">
                            <label>Người dùng</label>
                            <input type="text"  class="form-control" value="<?php echo @$record['last_name']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tên liên hệ</label>
                            <input type="text"  class="form-control" value="<?php echo @$record['nameContact']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>SĐT</label>
                            <input type="text"  class="form-control" value="<?php echo @$record['phone']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Gói dịch vụ</label>
                            <input type="text"  class="form-control" value="<?php echo @$record['label']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Số tháng</label>
                            <input type="number"  class="form-control" value="<?php echo @$record['months']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tổng tiền</label>
                            <input type="text" class="form-control" value="<?php echo number_format(@$record["total_price"]); ?> VNĐ" disabled>
                        </div>
                        <div class="form-group">
                            <label>Ngày bắt đầu</label>
                            <input type="text" class="form-control" value="<?php echo date("d/m/Y",strtotime(@$record["start_date"])); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Ngày hết hạn</label>
                            <input type="text" class="form-control" value="<?php echo date("d/m/Y",strtotime(@$record["expired_at"])); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control" rows="10" disabled><?php echo @$record["payment_info"]; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control required" name="status">
                                <option value="1" <?php echo @$record['status'] == 1 ? 'selected' : ''; ?>>Hoàn thành</option>
                                <option value="2" <?php echo @$record['status'] == 2 ? 'selected' : ''; ?>>Đã hủy</option>
                                <?php if(@$record['status'] == 0) : ?>
                                    <option value="0" <?php echo @$record['status']!= null && @$record['status'] == 0 ? 'selected' : ''; ?>>Đang chờ</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
    			    </form>
                </div>
    		</div>
    	</div>
    </div>
</div>