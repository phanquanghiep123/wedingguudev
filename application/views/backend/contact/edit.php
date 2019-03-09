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
                            <input type="text" name="full_name" class="form-control required" value="<?php echo @$record['full_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control required" value="<?php echo @$record['email']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" class="form-control required" value="<?php echo @$record['phone']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" name="subject" class="form-control required" value="<?php echo @$record['subject']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <?php echo $this->ckeditor->editor('message',@$record['message']);?>
                        </div>
                        <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
    				</form>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<script type="text/javascript" src="<?php echo skin_url('js/ckfinder/ckfinder_v1.js'); ?>"></script>
<script type="text/javascript">
    var object;
    function BrowseServerCustom(obj){
        object = obj;
        var finder = new CKFinder() ;
        finder.BasePath = base_url + 'skins/js/ckfinder/';
        finder.SelectFunction = SetFileFieldCustom;
        finder.SelectFunctionData = obj;
        finder.Popup();
    }

    function ClearFileCustom(obj){
        $(obj).parents('.featured-image').find('.xImagePath').val('');
        $(obj).parents('.featured-image').removeClass('active');
    }

    function SetFileFieldCustom( fileUrl, data ,files){
        $(object).parents('.featured-image').find('.xImagePath').val(fileUrl);
        $(object).parents('.featured-image').find('img').attr('src',fileUrl);
        $(object).parents('.featured-image').addClass('active');
    }
</script>