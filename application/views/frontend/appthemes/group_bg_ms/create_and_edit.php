<div class="is_page" id="page_parts">
  <div class="main-page <?php echo @$main_page;?>">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><?php echo (@$post["id"]) ? "Edit ": "Add new "?> theme group media</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <form method="post" action="<?php echo ($action_save)?>">
          <div class="row form-group">
            <label for="name" class="col-sm-4 col-form-label">Tên nhóm</label>
            <div class="col-sm-8">
              <input type="text" name="name" class="form-control" id="name" value="<?php echo @$post["name"]?>" required="required">
            </div>
          </div>
          <div class="row form-group">
            <label for="path_html" class="col-sm-4 col-form-label">Ảnh đại diện</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="path_name" name="path_name" value="<?php echo @$post["path_name"]?>" required="required" readonly="">
              <input type="hidden" value="<?php echo @$post["thumb"]?>" class="form-control" id="thumb" name="thumb" value="">
            </div>
            <div class="col-sm-3"><a id="choose-file-html" class="btn btn-primary">Chọn file</a></div>
          </div>
          <div class="row form-group">
            <label for="path_html" class="col-sm-4 col-form-label">Trạng thái</label>
            <div class="col-sm-8">
              <select name="type" value="<?php echo @$post["type"]?>" class="form-control" required="required">
                <option value="">--Dành cho--</option>
                <option value="background">background</option>
                <option value="music">music</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <label for="path_html" class="col-sm-4 col-form-label">Trạng thái</label>
            <div class="col-sm-8">
              <select name="status" value="<?php echo @$post["status"]?>" class="form-control" required="required">
                <option value="">--chọn trạng thái--</option>
                <option value="0">ẩn</option>
                <option value="1">hiện</option>
              </select>
            </div>
          </div>
          <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<link rel="stylesheet" href="<?php echo skin_url("themes/skins/css/style.css");?>">
<script type="text/javascript" src="<?php echo skin_url("themes/filemanager/filemanager.js")?>"></script>
<script type="text/javascript">
  $('#choose-file-html').Scfilemanagers({
    base_url : "<?php echo base_url();?>",
    query    : {
      max_file  : 1,
      type_file : "image"
    },
    beforchoose : function(val){
      $("#path_name").val(val[0].name);
      $("#thumb").val(val[0].id);
    }
  });
  $.each($("select[value]"),function(){
    $(this).val($(this).attr("value"));
  });
</script>