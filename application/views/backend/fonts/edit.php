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
                            <input type="text" name="name" class="form-control required" value="<?php echo @$record['name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Đường dẫn</label>
                             <input name="path_file" value="<?php echo @$record['path_file']; ?>" type="text" size="60" class="form-control" required>
                        </div>
                        <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
