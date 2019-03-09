<div class="main-page <?php echo @$main_page;?>">
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
                        <label>Tiêu đề</label>
                        <input type="text" name="Title" class="form-control required" value="<?php echo @$record['Title']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Key</label>
                        <input type="text" name="Key_Identify" class="form-control required" value="<?php echo @$record['Key_Identify']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <?php echo $this->ckeditor->editor('Content',@$record['Content']);?>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select class="form-control required" name="Status">
                            <option value="1" <?php echo @$record['Status'] == 1 ? 'selected' : ''; ?>>Hoạt động</option>
                            <option value="0" <?php echo @$record['Status']!= null && @$record['Status'] == 0 ? 'selected' : ''; ?>>Ngưng hoạt động</option>
                        </select>
                    </div>
                    <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
				</form>
			</div>
		</div>
	</div>
</div>
