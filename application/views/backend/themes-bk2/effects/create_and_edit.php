<div class="is_page" id="page_parts">
  <div class="main-page <?php echo @$main_page;?>">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><?php echo (@$post["id"]) ? "Edit ": "Add new "?> theme sections</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form method="post" action="<?php echo ($action_save)?>">
            <div class="row form-group">
              <label for="name" class="col-sm-4 col-form-label">Tên</label>
              <div class="col-sm-8">
                <input type="text" name="name" class="form-control" id="name" value="<?php echo @$post["name"]?>" required="required">
              </div>
            </div>
            <div class="row form-group">
              <label for="media_name" class="col-sm-4 col-form-label">Media file</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="media_name" name="media_name" value="<?php echo @$post["media_name"]?>" required="required" readonly="">
                <input type="hidden" value="<?php echo @$post["media_id"]?>" class="form-control" id="media_id" name="media_id" value="" required="required">
              </div>
              <div class="col-sm-3"><a id="choose-file-html" class="btn btn-primary">Chọn file</a></div>
            </div>
            <div class="row form-group">
              <label for="status" class="col-sm-4 col-form-label">Trạng thái</label>
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
<script type="text/javascript" src="<?php echo skin_url("themes/filemanager/filemanager.js")?>"></script>
<script type="text/javascript">
  $('#choose-file-html').Scfilemanagers({
    base_url : "<?php echo base_url();?>",
    query    : {
      max_file  : 1,
    },
    beforchoose : function(val){
      $("#media_name").val(val[0].name);
      $("#media_id").val(val[0].id);
    }
  });
  $.each($("select[value]"),function(){
    $(this).val($(this).attr("value"));
  });
  $("#select_type").change(function(){
    var t = $(this).val();
  });
</script>