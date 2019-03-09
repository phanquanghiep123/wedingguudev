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
                            <input type="text" name="title" class="form-control required" value="<?php echo @$record['title']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Định dạng</label>
                            <?php $format_list = get_format_datetime_list(); ?>
                            <select class="form-control required" name="format">
                                <?php foreach ($format_list as $format): ?>
                                    <option value="<?php echo $format; ?>" <?php echo @$record['format'] == $format ? 'selected' : ''; ?>><?php echo date($format); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Người dùng</label>
                            <select class="form-control js-example-tokenizer" name="member_id">
                                <?php if(isset($member) && $member != null): ?>
                                    <?php foreach ($member as $key => $item): ?>
                                        <option <?php echo @$item['id'] == @$record['member_id'] ? 'selected' : ''; ?> value="<?php echo @$item['id']; ?>"><?php echo @$item['first_name'].' '.@$item['last_name']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
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
    $(".js-example-tokenizer").select2();
</script>