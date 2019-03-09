<div id="section-style">
    <ul class="nav nav-tabs">
      <li ng-class="tabsectionstyle != 1 ? 'active' : ''"><a ng-click="tabsectionstyle = 0;" data-toggle="tab" href="#image">Ảnh nền</a></li>
      <li ng-class="tabsectionstyle == 1 ? 'active' : ''"><a ng-click="tabsectionstyle = 1" data-toggle="tab" href="#color">Màu nền</a></li>
    </ul>
    <div class="tab-content">
      <div id="scrollbars">
        <div id="image" ng-class="tabsectionstyle != 1 ? 'active': ''" class="tab-pane fade in">
          <ul class="nav-list-items list_category">
            <li uploads="" data-max="1" data-type="image" data-action="background-image"><i class="fa fa-upload" aria-hidden="true"></i>Tải ảnh lên</li> 
            <li openfilemanager="" href="javascript:;" class="ui-button-text" data-action="background-image" data-type="image" data-max="1" id="openFilemanager"><i class="fa fa-folder-open" aria-hidden="true"></i>Mở thư viện file</li>         
            <li ng-class="(type.load == 1) ? 'loadding' : ''" ng-repeat="type in backgroundType" ng-click="getActionType(type)" class="item" id="{{type.id}}"><i class="fa fa-clone" aria-hidden="true"></i>{{type.name}}</li>
            <li class="item not-after">
              <p>Lặp lại</p>
              <select id="style-repeat" class="form-control" ng-model="section.style['background-repeat']">
                <option value="">-- chọn một mục --</option>
                <option ng-repeat ="item in background_repeat" value="{{item.value}}">{{item.label}}</option>
              </select>
            </li>
            <li class="item not-after">
              <p>Kích cỡ</p>
              <select class="form-control" id="style-size" ng-model="section.style['background-size']">
                <option value="">-- chọn một mục --</option>
                <option ng-repeat ="item in background_size" value="{{item.value}}">{{item.label}}</option>
              </select>
            </li>
            <li class="item not-after">
              <p>Vị trí</p>
              <select  class="form-control" id="style-position" ng-model="section.style['background-position']">
                <option value="">-- chọn một mục --</option>
                <option ng-repeat ="item in background_position" value="{{item.value}}">{{item.label}}</option>
              </select>
            </li>
          </ul>  
        </div>
        <div id="color" ng-class="tabsectionstyle == 1 ? 'active':''" class="tab-pane fade in">
          <input colorpicker type="text" ng-model="section.style['background-color']" ng-value="section.style['background-color']">
        </div>
        <div ng-if="(section.style['background-image'] && section.style['background-image'] != 'inherit') || (section.style['background-color'] && section.style['background-color'] != 'inherit')" class="setting-bg">
            <div class="item-cuttent-bg" ng-if="(section.style['background-image'] && section.style['background-image'] != 'inherit')">
              <p>Ảnh nền hiện tại</p>
              <div style="width: 100% ;height: 180px;background-size: cover; background-image: {{section.style['background-image']}}"><div class="action-bg"><span class="removebgnoew fa fa-remove" ng-click="RemoveBg(0)"></span></div></div>
            </div>
            <div class="item-cuttent-bg" ng-if="(section.style['background-color'] && section.style['background-color'] != 'inherit')">
              <p>Màu nền hiện tại <div style="float: right;margin-left: 20px;width: 30px; height: 30px;background-color: {{section.style['background-color']}}"></div> <div class="action-bg"><span class="removebgnoew fa fa-remove" ng-click="RemoveBg(1)"></span></div></p>
            </div>
        </div> 
      </div>
    </div>
</div>
<style type="text/css">
    #section-style .item-cuttent-bg {position: relative; margin-bottom: 20px;}
    #section-style .nav-tabs li{
        width: 50%;
    }
    #section-style .action-bg {
        position: absolute;
        top: 0;
        right: 0;
    }
    #section-style .nav-tabs li a{
        text-transform: uppercase;
        font-size: 15px;
        text-align: center;
    }
    #section-style .evo-cp-wrap .colorPicker {
      width: 100%;
      background: #fff;
      border-radius: 0;
      margin-bottom: -1px;
      display: block;
      position: relative;
      height: auto;
      font-size: 20px;
      padding: 5px;
      color: #ccc;
      border: 1px solid #ccc;
    }
    #section-style .evo-cp-wrap .ui-widget-content {
        width: 100%;
    }
    #section-style .evo-color div {
        width: 20px;
        height: 20px;
    }
    #section-style .evo-palcenter {
        padding: 5px;
        margin: 40px 0;
        text-align: center;
    }
    #section-style .setting-bg{
        margin-top: 0;
        float: left;
        width: 100%;
        background: #fff;
        padding: 15px 5px 5px 5px;
        background: #fff;
        margin-left: 1px;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: bold;
        -webkit-box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
        box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
    }
</style>