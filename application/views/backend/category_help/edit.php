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
    					<input type="hidden" name="ID" value="<?php echo @$record['id']; ?>" />
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
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control required" rows="7"><?php echo @$record['description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Ngôn ngữ</label>
                            <select class="form-control required" name="Lang">
                                <?php
                                    foreach (@$langs as $key => $value) {
                                        echo '<option value="'.$value["id"].'" '.(@$record['Lang'] == $value["id"] ? 'selected' : '').'>'.$value["name"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control required" name="status">
                                <option value="1" <?php echo @$record['status'] == 1 ? 'selected' : ''; ?>>Hoạt động</option>
                                <option value="0" <?php echo @$record['status'] == 0 ? 'selected' : ''; ?>>Ngưng hoạt động</option>
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