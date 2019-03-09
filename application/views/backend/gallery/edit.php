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
                            <label>Bộ sưu tập</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="featured-image">
                                    <a href="#" onclick="selectFileWithCKFinder(this);return false;">
                                        <i class="fa fa-plus" title="Chọn ảnh"></i>
                                    </a>
                                </div>
                                <div class="list-image" id="sortable">
                                    <?php $gallary = json_decode(@$record['image'],true); ?>
                                    <?php if(@$gallary != null): ?>
                                        <?php foreach ($gallary as $key => $item): ?>
                                            <div class="featured-image" style="background-image:url('<?php echo $item; ?>');cursor: move;">   
                                                <span class="remove-featured-image" onclick="removeItem(this);" title="Xóa ảnh">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </span>
                                                <input type="hidden" name="gallery_item[]" value="<?php echo $item; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <?php echo $this->ckeditor->editor('description',@$record['description']);?>
                        </div>
                        <div class="form-group">
                            <label>Chuyên mục</label>
                            <select class="form-control" name="category_id" >
                                <?php if(isset($category) && $category != null): ?>
                                    <?php foreach ($category as $key => $item): ?>
                                        <option value="<?php echo @$item['id']; ?>" <?php echo $item['id'] == @$record['category_id'] ? 'selected' : ''; ?> ><?php echo @$item['name']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Loại</label>
                            <select class="form-control required" name="type">
                                <option value="1" <?php echo @$record['type'] == 1 ? 'selected' : ''; ?>>Hệ thống</option>
                                <option value="0" <?php echo @$record['type']!= null && @$record['type'] == 0 ? 'selected' : ''; ?>>Người dùng</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control required" name="status">
                                <option value="1" <?php echo @$record['status'] == 1 ? 'selected' : ''; ?>>Hoạt động</option>
                                <option value="0" <?php echo @$record['status']!= null && @$record['status'] == 0 ? 'selected' : ''; ?>>Ngưng hoạt động</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Người dùng</label>
                            <select class="form-control js-example-tokenizer" name="member_id">
                                <option value="0">Chọn người dùng</option>
                                <?php if(isset($member) && $member != null): ?>
                                    <?php foreach ($member as $key => $item): ?>
                                        <option <?php echo @$item['id'] == @$record['member_id'] ? 'selected' : ''; ?> value="<?php echo @$item['id']; ?>"><?php echo @$item['first_name'].' '.@$item['last_name']; ?></option>
                                    <?php endforeach; ?>
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
<link href="<?php echo skin_url('backend/vendors/select2/dist/css/select2.css');?>" rel="stylesheet">
<script src="<?php echo skin_url('backend/vendors/select2/dist/js/select2.js');?>"></script>
<script type="text/javascript">
    function selectFileWithCKFinder(element) {
        CKFinder.modal( {
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function(finder) {
                finder.on( 'files:choose', function( evt ) {
                    var files = evt.data.files;
                    var html = '';
                    
                    files.forEach( function( file, i ) {
                        html += '<div class="featured-image" style="background-image:url(\'' + file.getUrl() + '\');cursor: move;">';
                        html += '   <span class="remove-featured-image" onclick="removeItem(this);" title="Xóa ảnh">';
                        html += '      <i class="fa fa-times" aria-hidden="true"></i>';
                        html += '   </span>';
                        html += '   <input type="hidden" name="gallery_item[]" value="' + file.getUrl() + '">';
                        html += '</div>';
                    });
                    $('.list-image').append(html);
                    $('.overlay-ckfinder').hide();
                });
                $("#ckf-modal-header #ckf-modal-close").attr("onclick","$('.overlay-ckfinder').hide();");
                $('.overlay-ckfinder').show();
            }
        } );
    }

    function removeItem(element){
        $(element).parents('.featured-image').remove();
    }
    $( function() {
        $("#sortable").sortable();
        $("#sortable").disableSelection();
    });
    $(".js-example-tokenizer").select2();
</script>
<style type="text/css">
    .featured-image{
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 15px;
        float: left;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .featured-image .remove-featured-image{
        display: block !important;
    } 
</style>