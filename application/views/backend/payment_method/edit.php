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
                            <label>Mô tả</label>
                            <?php echo $this->ckeditor->editor('description',@$record['description']);?>
                        </div>
                        <div class="form-group">
                            <label>Thông số API</label>
                            <div class="list-api-item">
                                <?php 
                                    $api = json_decode(@$record['json_api'],true);
                                    if(isset($api) && count($api) > 0):
                                       foreach ($api as $key => $item): 
                                ?>
                                    <div class="row api-item">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Key</label>
                                                <input class="form-control" type="text" value="<?php echo $key; ?>" name="api[key][]">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Value</label>
                                                <input class="form-control" type="text" value="<?php echo $item; ?>" name="api[value][]">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="#" class="btn-remove-item-api" style="display:inline-block;color:#ff0000;margin-top: 25px;"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                <?php  endforeach;
                                    endif; 
                                ?>
                                <div class="row api-item">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Key</label>
                                            <input class="form-control" type="text" value="" name="api[key][]">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Value</label>
                                            <input class="form-control" type="text" value="" name="api[value][]">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <a href="#" class="btn-remove-item-api" style="display:none;color:#ff0000;margin-top: 25px;"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        <a href="#" style="margin-top: 25px;" class="btn btn-primary btn-add-new-item-api">Thêm mới</a>
                                    </div>
                                </div>
                            </div>
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
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','.btn-add-new-item-api',function(){
            var html = $(this).parents('.api-item').html();
            $(".list-api-item").find('.btn-add-new-item-api').hide();
            $(".list-api-item").find('.btn-remove-item-api').css('display','inline-block');
            $(".list-api-item").append('<div class="row api-item" style="margin: 0;">' + html + '</div>');
            return false;
        });
        $(document).on('click','.btn-remove-item-api',function(){
            $(this).parents('.api-item').remove();
            return false;
        });
    });
</script>