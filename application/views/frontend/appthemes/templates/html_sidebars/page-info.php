<div id="info-theme">
  <div class="form-group"> 
    <input type="text" ng-model="theme.name" name="name" class="form-control" placeholder="Nhập vào tên giao diện"> 
  </div>
  <div class="form-group"> 
    <textarea name="description" ng-model="theme.description" class="form-control" placeholder="Nhập vào mô tả của giao diện"></textarea> 
  </div>
  <div class="form-group"> 
    <div class="box-choose-type-file">
      <a uploads data-max="1" data-action="theme_thumb" id="toggle-upload-file" data-type="image" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> {{_Lang.APP_THEME_L_SELECT_PHOTO}}</a>
      <a openfilemanager href="javascript:;" data-action="theme_thumb" class="btn btn-success"data-type="image" data-max="1" id="openFilemanager"><i class="fa fa-folder-open" aria-hidden="true"></i> {{_Lang.APP_THEME_L_THEME_OPEN_LIBRARY_IMAGE}}</a> 
    </div>
    <div ng-if="theme.thumb_url" id="box-show-background-image">
      <div class="img">
        <img class="hero_image" name="hero_image" src="#" ng-src="{{theme.thumb_url}}">
      </div>
    </div> 
  </div>
  <div class="form-group"> 
    <select ng-model="theme.public" name="public" class="form-control">
      <option value="0">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
      <option value="1">{{_Lang.APP_THEME_L_THEME_SELECT_PUBLIC}}</option>
      <option value="2">{{_Lang.APP_THEME_L_THEME_SELECT_PRIVATE}}</option>
    </select>
  </div>
  <div class="form-group" ng-if="theme.is_active != 1"><a ng-click="Deletetheme()" class="full-width btn btn-danger" href="javascript:;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa theme </a></div>
</div>
<style type="text/css">
  #sidebar-actions #info-theme{
    margin-top: 20px;
    padding: 0 5px;
  }
  .full-width{
    width: 100%;
  }
  #sidebar-actions #info-theme .hero_image{
    background: #fff;
    padding: 2px;
    width: 100%;
  }
  #sidebar-actions #info-theme textarea.form-control{
      height: 140px;
  }
  #sidebar-actions #info-theme .box-choose-type-file{
    margin-bottom: 10px;
  }
</style>