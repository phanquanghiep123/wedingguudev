<div id="page-sound">
    <ul class="nav nav-tabs">
      <li ng-class="tabsound == 0 ? 'active' : ''"><a data-toggle="tab" href="#chosse">Chọn nhạc nền</a></li>
      <li ng-if="theme.sound_play == 1" ng-class="tabsound == 1 ? 'active' : ''"><a data-toggle="tab" href="#brown">Nhạc nền mẫu </a></li>
    </ul>
    <div class="tab-content">
      <div ng-class="tabsound == 0 ? 'active' : ''" id="chosse" class="tab-pane fade in">
        <ul class="nav-list-items list_category">
          <li class="sections">
            <i class="fa fa-power-off" aria-hidden="true"></i>Bật nhạc nền
            <div class="TriSea-technologies-Switch pull-right">
              <input id="TriSeaPrimarysound_play" ng-checked="theme.sound_play == 1" ng-click="ChangeRunSound()" name="sound_play" type="checkbox"/>
              <label for="TriSeaPrimarysound_play" class="label-primary"></label>
            </div>
          </li>
          <li ng-if="theme.sound_play == 1" uploads data-max="1" data-type="audio" data-action="sound"><i class="fa fa-upload"></i>Tải nhạc lên</li>
          <li ng-if="theme.sound_play == 1" openfilemanager href="javascript:;" class="ui-button-text" data-action="sound" data-type="audio" data-max="1" id="openFilemanager"><i class="fa fa-folder-open" aria-hidden="true"></i>Mở thư viện file</li>
        </ul>
      </div>
      <div ng-if="theme.sound_play == 1" ng-class="tabsound == 1 ? 'active' : ''" id="brown" class="tab-pane fade in">
          <ul class="nav-list-items list_category">
            <li ng-class="(item.load == 1) ? 'loadding' : ''" ng-repeat="item in group_sounds" ng-click="getSounds(item)" class="item" id="{{item.id}}">{{item.name}}</li>
          </ul> 
      </div>
    </div>
    <div ng-if="(theme.sound_play == 1 && theme.sound && theme.sound != false && theme.sound != 'false')" class="setting-bg">
      <p>Nhạc nền hiện tại</p> 
      <div class="sound-current sounds">
        <p>
          <span class="sound_name" ng-title="theme.sound.name">{{theme.sound.name}}</span>
          <div class="action-sound">
            <span ng-class="(theme.sound.start == 1) ? 'fa fa-play-circle':'fa fa-pause-circle'" ng-click="StartStop(theme.sound,$event)" id="start_stop" class="removesound"></span>
            <span class="removesound fa fa-remove" ng-click="RemoveSound()"></span>
          </div>
        </p>
      </div>
    </div>
</div>
<style type="text/css">
    #page-sound .nav-tabs li{
        width: 50%;
    }
    .sound-current{
      position: relative;
    }
    .action-sound{
      position: absolute;
      top: -30px;
      right: 10px;
    }
    #page-sound .nav-tabs li a{
        text-transform: uppercase;
        font-size: 15px;
        text-align: center;
    }
    #page-sound .evo-cp-wrap .colorPicker {
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
    #page-sound .evo-cp-wrap .ui-widget-content {
        width: 100%;
    }
    #page-sound .evo-color div {
        width: 20px;
        height: 20px;
    }
    #page-sound .evo-palcenter {
        padding: 5px;
        margin: 40px 0;
        text-align: center;
    }
    #page-sound .setting-bg{
      margin-top: 0;
      float: left;
      width: 100%;
      background: #fff;
      padding: 15px 5px 5px 5px;
      background: #fff;
      margin-left: 1px;
      cursor: pointer;
      text-transform: uppercase;
    }
</style>