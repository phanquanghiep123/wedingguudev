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
                            <label>Nhãn</label>
                            <input type="text" name="label" class="form-control required" value="<?php echo @$record['label']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <?php echo $this->ckeditor->editor('description',@$record['description']);?>
                        </div>
                        <div class="form-group">
                            <label>Danh sách lựa chọn của gói</label>
                            <hr/>
                            <div class="">
                                <ul id="sortable">
                                     <?php 
                                        foreach ($options as $key => $value) {
                                            $ckeck = $value["is_connect"] ? 'checked' : '';
                                            echo '<li class="ui-state-default">
                                                    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span><label><input type="checkbox" name="options['.$value["id"].']" value="1" '.$ckeck.'>'.$value["label"].'<label>
                                                </li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Giá</label>
                            <input type="number" name="price" class="form-control required" value="<?php echo @$record['price']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Số tháng</label>
                            <input type="number" name="months" class="form-control required" value="<?php echo @$record['months']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control required" name="status">
                                <option value="1" <?php echo @$record['status'] == 1 ? 'selected' : ''; ?>>Hoạt động</option>
                                <option value="0" <?php echo @$record['status'] != null && @$record['status'] == 0 ? 'selected' : ''; ?>>Ngưng hoạt động</option>
                            </select>
                        </div>
                        <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em;}
  #sortable li span { position: absolute; margin-left: -1.3em; }
  #sortable li input[type=checkbox]{
        margin: 1px 8px 0px;
  }
  #sortable li label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 0;
    font-weight: 700;
}
#sortable li span {
    position: absolute;
    margin: 3px -20px;
}
</style>
<script type="text/javascript">
    $( function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
      } );
</script>