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
                            <label>Tiêu đề</label>
                            <input type="text" name="Name" class="form-control required" value="<?php echo @$record['Name']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <?php echo $this->ckeditor->editor('Summary',@$record['Summary']);?>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <?php echo $this->ckeditor->editor('Content',@$record['Content']);?>
                        </div>
                        <div class="form-group">
                            <label>Ảnh đại diện</label>
                            <div class="featured-image <?php echo @$record['Media']!= null ? 'active' : ''; ?>">
                                <span class="remove-featured-image" onclick="ClearFileCustom(this);" title="Xóa ảnh">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </span>
                                <a href="#" onclick="BrowseServerCustom(this);return false;">
                                    <i class="fa fa-plus" title="Chọn ảnh"></i>
                                </a>
                                <img src="<?php echo @$record['Media']; ?>">
                                <input name="Media" value="<?php echo @$record['Media']; ?>" type="hidden" size="60" class="form-control xImagePath">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Chuyên mục</label>
                            <select class="form-control js-example-tokenizer" name="category[]" multiple="multiple">
                                <?php echo @$option_category; ?>
                            </select>
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
</div>
<link href="<?php echo skin_url('backend/vendors/select2/dist/css/select2.css');?>" rel="stylesheet">
<script src="<?php echo skin_url('backend/vendors/select2/dist/js/select2.js');?>"></script>
<script type="text/javascript">
    $(".js-example-tokenizer").select2({
       tags: true,
       tokenSeparators: [',', ' ']
    });
</script>