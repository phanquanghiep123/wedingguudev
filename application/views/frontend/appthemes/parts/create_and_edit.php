<div class="is_page" id="page_parts">
  <div class="main-page <?php echo @$main_page;?>">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><?php echo (@$post["html_edit"]) ? "Edit ": "Add new "?> theme part</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      <form method="post" action="<?php echo ($action_save)?>">
          <div class="form-group">
            <label for="name" class="col-sm-4 col-form-label">Tên phần</label>
            <div class="col-sm-8">
              <input type="text" name="name" class="form-control" id="name" value="<?php echo @$post["name"]?>" required="required">
            </div>
          </div>
          <div class="form-group">
            <label for="html_edit" class="col-sm-4 col-form-label">Html edit</label>
            <div class="col-sm-8">
              <textarea name="html_edit" class="form-control" id="html_edit" required="required"><?php echo htmlspecialchars(@$post["html_edit"])?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="html_show" class="col-sm-4 col-form-label">Html show</label>
            <div class="col-sm-8">
              <textarea name="html_show" class="form-control" id="name" required="required"><?php echo htmlspecialchars(@$post["html_show"])?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="list_show" class="col-sm-4 col-form-label">List show</label>
            <div class="col-sm-8">
              <textarea name="list_show" class="form-control" id="list_show" required="required"><?php echo htmlspecialchars(@$post["list_show"])?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="list_show" class="col-sm-4 col-form-label">Giá trị mặt định</label>
            <div class="col-sm-8">
              <textarea name="default_value" class="form-control" id="default_value" required="required"><?php echo htmlspecialchars(@$post["default_value"])?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-4 col-form-label">meta key</label>
            <div class="col-sm-8">
              <select class="form-control"  name="meta_key" id="meta_key" value="<?php echo @$post["meta_key"]?>" required="required">
                <option value="value_text">value_text</option>
                <option value="value_media">value_media</option>
                <option value="map_point">map_point</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="status" class="col-sm-4 col-form-label">Trạng thái</label>
            <div class="col-sm-8">
              <select name="status" value="<?php echo @$post["status"]?>" class="form-control" required="required">
                  <option value="">--chọn trạng thái--</option>
                  <option value="0" selected="true">ẩn</option>
                  <option value="1">hiện</option>
              </select>
            </div>
          </div>
            <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
      </form>
    </div>
  </div>
</div>
<link rel="stylesheet" href="<?php echo skin_url("themes/skins/css/style.css");?>">
<style type="text/css">
  .form-group{float: left;width: 100%;}
  #page_parts textarea{
    height: 300px !important;
  }
</style>
<script type="text/javascript" src="<?php echo skin_url("themes/filemanager/filemanager.js")?>"></script>
<script type="text/javascript">
  $(document).ready (function(){
    $.each($("select[value]"),function(){
      $(this).val($(this).attr("value"));
    });
  });
</script>
