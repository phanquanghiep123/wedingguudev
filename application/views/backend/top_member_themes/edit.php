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
                            <label>Theme ID</label>
                            <select class="form-control js-example-tokenizer" name="member_theme_id">
                                <?php if(isset($member_theme) && $member_theme != null): ?>
                                    <?php foreach ($member_theme as $key => $item): ?>
                                        <option <?php echo @$item['id'] == @$record['member_theme_id'] ? 'selected' : ''; ?> value="<?php echo @$item['id']; ?>"><?php echo @$item['id']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
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
                            <label>URL</label>
                            <input type="text" name="url" class="form-control required" value="<?php echo @$record['url']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Thứ tự</label>
                            <input type="number" name="sort_number" class="form-control required" value="<?php echo @$record['sort_number'] != null; ?>">
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
