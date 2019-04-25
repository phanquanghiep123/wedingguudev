<div id="page-background">
    <ul class="nav nav-tabs">
      <li ng-class="tabbackground != 1 ? 'active' : ''"><a ng-click="tabbackground = 0;" data-toggle="tab" href="#image">{{_Lang.APP_THEME_L_THEME_BACKGROUND_IMAGE}}</a></li>
      <li ng-class="tabbackground == 1 ? 'active' : ''"><a ng-click="tabbackground = 1;" data-toggle="tab" href="#color">{{_Lang.APP_THEME_L_THEME_BACKGROUND_COLOR}}</a></li>
    </ul>
    <div class="tab-content">
      <div id="scrollbars">
        <div id="image" ng-class="tabbackground != 1 ? 'active': ''" class="tab-pane fade in">
          <ul class="nav-list-items list_category">
            <li uploads="" data-max="1" data-type="image" data-action="background-image"><i class="fa fa-upload" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_UPLOAD_IMAGE}}</li>
            <li openfilemanager href="javascript:;" class="ui-button-text" data-action="background-image" data-type="image" data-max="1" id="openFilemanager"><i class="fa fa-folder-open" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_OPEN_LIBRARY_IMAGE}}</li>
            <li ng-class="(type.load == 1) ? 'loadding' : ''" ng-repeat="type in backgroundType" ng-click="getActionType(type)" class="item" id="{{type.id}}"><i class="fa fa-clone" aria-hidden="true"></i>{{type.name}}</li>
            <li class="item not-after">
              {{_Lang.APP_THEME_L_THEME_REPEAT}}
              <select id="background-repeat" class="form-control" ng-model="theme.style['background-repeat']">
                <option value="">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
                <option ng-repeat ="item in background_repeat" value="{{item.value}}">{{item.label}}</option>
              </select>
            </li>
            <li class="item not-after">
              {{_Lang.APP_THEME_L_THEME_BACKGROUND_SIZE}}
              <select class="form-control" id="background-size" ng-model="theme.style['background-size']">
                <option value="">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
                <option ng-repeat ="item in background_size" value="{{item.value}}">{{item.label}}</option>
              </select>
            </li>
            <li class="item not-after">
              {{_Lang.APP_THEME_L_THEME_BACKGROUND_POSITION}}
              <select class="form-control" id="background-position" ng-model="theme.style['background-position']">
                <option value="">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
                <option ng-repeat ="item in background_position" value="{{item.value}}">{{item.label}}</option>
              </select>
            </li>
            <li class="item not-after">
              {{_Lang.APP_THEME_L_THEME_BACKGROUND_FIX}}
              <select class="form-control" id="background-attachment" ng-model="theme.style['background-attachment']">
                <option value="">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
                <option ng-repeat ="item in background_attachment" value="{{item.value}}">{{item.label}}</option>
              </select>
            </li> 
          </ul>  
        </div>
        <div id="color" ng-class="tabbackground == 1 ? 'active':''" class="tab-pane fade in">
          <input style="background-color:{{theme.style['background-color']}}" colorpicker type="text" ng-model="theme.style['background-color']" ng-value="theme.style['background-color']">
        </div>
        <div ng-if="(theme.style['background-image'] != undefined && theme.style['background-image'] != 'inherit') || (theme.style['background-color'] != undefined && theme.style['background-color'] != 'inherit')" class="setting-bg">
            <div class="item-cuttent-bg" ng-if="(theme.style['background-image'] != undefined && theme.style['background-image'] != 'inherit')">
              <label>{{_Lang.APP_THEME_L_THEME_CURRENT_BACKGROUND_IMAGE}} </label>
              <div style="width: 100% ;height: 180px;background-size: cover; background-image: {{theme.style['background-image']}}"><div class="action-bg"><span class="removebgnoew fa fa-remove" ng-click="RemoveBg(0)"></span></div></div>
            </div>
            <div class="item-cuttent-bg" ng-if="(theme.style['background-color'] != undefined && theme.style['background-color'] != 'inherit')">
              <label>{{_Lang.APP_THEME_L_THEME_CURRENT_BACKGROUND_COLOR}} <div style="float: right;margin-left: 20px;width: 30px; height: 30px;background-color: {{theme.style['background-color']}}"></div> <div class="action-bg"><span class="removebgnoew fa fa-remove" ng-click="RemoveBg(1)"></span></div></label>
            </div>
        </div>
      </div> 
    </div>
</div>
<style type="text/css">
    #page-background .item-cuttent-bg{margin-bottom: 10px;position: relative;}
    #page-background .nav-tabs li{
        width: 50%;
    }
    #page-background .nav-tabs li a{
        text-transform: uppercase;
        font-size: 15px;
        text-align: center;
    }
    #page-background .action-bg {
        position: absolute;
        top: 0;
        right: 0;
    }
    #page-background .evo-cp-wrap .colorPicker {
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
    #page-background .evo-cp-wrap .ui-widget-content {
        width: 100%;
    }
    #page-background .evo-color div {
        width: 20px;
        height: 20px;
    }
    #page-background .evo-palcenter {
        padding: 5px;
        margin: 40px 0;
        text-align: center;
    }
    #page-background .setting-bg{
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