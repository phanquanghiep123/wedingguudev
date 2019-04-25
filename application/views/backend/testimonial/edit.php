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
                            <input type="text" name="name" class="form-control required" value="<?php echo @$record['name']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <?php echo $this->ckeditor->editor('content',@$record['content']);?>
                        </div>
                        <?php if(@$languages):?>
                            <div class="form-group">
                                <label>Ngôn ngữ</label>
                                <select class="form-control required" name="lang">
                                     <?php 
                                        foreach ($languages as $key => $value) {
                                            if($record["lang"] == $value["id"]){
                                                echo '<option value="'.$value["id"].'" selected>'.$value["name"].'</option>';
                                            }else{
                                                echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
                                            }
                                        }
                                     ?>
                                </select>
                            </div>
                        <?php endif;?>

                        <div class="form-group">
                            <label>Ảnh đại diện</label>
                            <div class="featured-image <?php echo @$record['image']!= null ? 'active' : ''; ?>">
                                <span class="remove-featured-image" onclick="ClearFileCustom(this);" title="Xóa ảnh">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </span>
                                <a href="#" onclick="BrowseServerCustom(this);return false;">
                                    <i class="fa fa-plus" title="Chọn ảnh"></i>
                                </a>
                                <img src="<?php echo @$record['image']; ?>">
                                <input name="image" value="<?php echo @$record['image']; ?>" type="hidden" size="60" class="form-control xImagePath">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Số sao</label>
                            <input type="number" class="form-control" name="rate" min="1" max="5" value="<?php echo @$record['rate']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Địa điểm</label>
                            <input type="text" class="form-control" name="address" value="<?php echo @$record['address']; ?>">
                        </div>
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
<link href="<?php echo skin_url('backend/vendors/select2/dist/css/select2.css');?>" rel="stylesheet">
<script src="<?php echo skin_url('backend/vendors/select2/dist/js/select2.js');?>"></script>
<script type="text/javascript">
    $(".js-example-tokenizer").select2({
       tags: true,
       tokenSeparators: [',', ' ']
    });
</script>