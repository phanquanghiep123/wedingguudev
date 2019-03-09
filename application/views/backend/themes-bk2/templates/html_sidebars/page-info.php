<div id="info-theme">
  <div class="form-group"> 
    <input type="text" ng-model="theme.name" name="name" class="form-control" placeholder="Nhập vào tên giao diện"> 
  </div>
  <div class="form-group"> 
    <textarea name="description" ng-model="theme.description" class="form-control" placeholder="Nhập vào mô tả của giao diện"></textarea> 
  </div>
  <div class="form-group"> 
    <div class="box-choose-type-file">
      <a uploads data-max="1" data-action="theme_thumb" id="toggle-upload-file" data-type="image" class="btn btn-primary">Chọn ảnh</a>
      <a openfilemanager href="javascript:;" data-action="theme_thumb" class="btn btn-success"data-type="image" data-max="1" id="openFilemanager">Mở thư viện ảnh</a> 
    </div>
    <div ng-if="theme.thumb_url" id="box-show-background-image">
      <div class="img">
        <img class="hero_image" name="hero_image" src="#" ng-src="{{theme.thumb_url}}">
      </div>
    </div> 
  </div>
  <div class="form-group"> 
     <select ng-model="theme.public" name="public" class="form-control">
        <option value="0">-- Chọn chế độ--</option>
        <option value="1">Công khai</option>
        <option value="2">Chưa xong</option>
     </select>
  </div>
  <div class="form-group"> 
      <select ng-model="theme.status" name="status" class="form-control">
        <option value="0">-- Chọn trạng thái--</option>
        <option value="1">Hiện</option>
        <option value="2">Ẩn</option>
      </select>
  </div>
</div>
<style type="text/css">
  #sidebar-actions #info-theme{
    margin-top: 20px;
    padding: 0 5px;
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