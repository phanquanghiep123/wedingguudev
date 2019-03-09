<div id="section-background">
    <ul class="nav nav-tabs">
      <li ng-class="tabsectionbackground == 0 ? 'active' : ''"><a ng-click="tabsectionbackground = 0;" data-toggle="tab" href="#image">Ảnh nền</a></li>
      <li ng-class="tabsectionbackground == 1 ? 'active' : ''"><a ng-click="tabsectionbackground = 1" data-toggle="tab" href="#color">Màu nền</a></li>
    </ul>
    <div class="tab-content">
      <div id="image" ng-class="tabsectionbackground == 0 ? 'active': ''" class="tab-pane fade in">
        <ul class="nav-list-items list_category">
          <li ng-class="(type.load == 1) ? 'loadding' : ''" ng-repeat="type in backgroundType" ng-click="getActionType(type)" class="item" id="{{type.id}}">{{type.name}}</li>
          <li class="item not-after">
            <label for="background-repeat">Lặp lại</label>
            <select ng-options="item for item in background_repeat track by item" id="background-repeat" class="form-control" ng-model="section.style['background-repeat']">
              <option value="">-- chọn một mục --</option>
            </select>
          </li>
          <li class="item not-after">
            <label for="background-size">Kích cỡ</label>
            <select ng-options="item for item in background_size track by item" class="form-control" id="background-size" ng-model="section.style['background-size']">
              <option value="">-- chọn một mục --</option>
            </select>
          </li>
          <li class="item not-after">
            <label for="background-position">Vị trí</label>
            <select ng-options="item for item in background_position track by item" class="form-control" id="background-position" ng-model="section.style['background-position']">
              <option value="">-- chọn một mục --</option>
            </select>
          </li>
        </ul>  
      </div>
      <div id="color" ng-class="tabsectionbackground == 1 ? 'active':''" class="tab-pane fade in">
        <input colorpicker type="text" ng-model="section.style['background-color']" ng-value="theme.style['background-color']">
      </div>
      <div class="setting-bg">
          <div ng-if="(section.style['background-image'] && section.style['background-image'] != 'inherit')">
            <label>Ảnh nền hiện tại</label>
            <div style="width: 100% ;height: 180px;background-size: cover; background-image: {{theme.style['background-image']}}"></div>
          </div>
          <div ng-if="(section.style['background-color'] && section.style['background-color'] != 'inherit')">
            <label>Màu nền hiện tại <div style="float: right;margin-left: 20px;width: 30px; height: 30px;background-color: {{theme.style['background-color']}}"></div> </label>
          </div>
      </div> 
    </div>
</div>
<style type="text/css">
    #section-background .nav-tabs li{
        width: 50%;
    }
    #section-background .nav-tabs li a{
        text-transform: uppercase;
        font-size: 15px;
        text-align: center;
    }
    #section-background .evo-cp-wrap .colorPicker {
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
    #section-background .evo-cp-wrap .ui-widget-content {
        width: 100%;
    }
    #section-background .evo-color div {
        width: 20px;
        height: 20px;
    }
    #section-background .evo-palcenter {
        padding: 5px;
        margin: 40px 0;
        text-align: center;
    }
    #section-background .setting-bg{
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