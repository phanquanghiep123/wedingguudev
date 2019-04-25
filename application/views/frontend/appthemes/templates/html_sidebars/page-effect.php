<div id="page-effect">
  <ul class="nav-list-sections list_category">
    <li class="sections">
      <i class="fa fa-power-off" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_OPEN_EFFECT}} :
      <div class="TriSea-technologies-Switch pull-right">
        <input id="TriSeaPrimaryeffect" ng-click="Changeffect()" ng-checked="theme.effect == 1"  name="effect" type="checkbox"/>
        <label for="TriSeaPrimaryeffect" class="label-primary"></label>
      </div>
    </li>
    <li ng-if="theme.effect == 1" class="sections" uploads="" data-max="1" data-type="image" data-action="effect"><i class="fa fa-upload" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_UPLOAD_IMAGE}}</li>
    <li ng-if="theme.effect == 1" class="sections" openfilemanager="" href="javascript:;" class="ui-button-text" data-action="effect" data-type="image" data-max="1" id="openFilemanager"><i class="fa fa-folder-open" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_OPEN_LIBRARY_IMAGE}}</li>
    <li ng-if="theme.effect == 1" class="sections" ng-click="OpenExampleEffect()" ng-if="theme.effect == 1"><i class="fa fa-clone" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_USE_EXAMPLE_IMAGE}}</li>
    <li ng-if="theme.effect == 1" class="item not-after">
      {{_Lang.APP_THEME_L_THEME_MIN_WIDTH_IMAGE}}
      <select ng-options="item as item for item in [5,10,15,20,25,30,35,40] track by item" class="form-control" ng-model="theme.effect_file.minsize"></select>
    </li>
    <li class="sections" ng-if="theme.effect == 1" class="item not-after">
      {{_Lang.APP_THEME_L_THEME_MAX_WIDTH_IMAGE}}
      <select ng-options="item as item for item in [20,25,30,35,40,45,50,55,60,65,70,75,80] track by item" class="form-control" ng-model="theme.effect_file.maxsize"></select>
    </li>
    <li class="sections" ng-if="theme.effect == 1" class="item not-after">
      <label for="background-repeat">{{_Lang.APP_THEME_L_THEME_SPEED_FALLS}}</label>
      <select class="form-control" ng-model="theme.effect_file.onnew">
        <option value="500">0.5 {{_Lang.APP_THEME_L_THEME_SPEED_SECONDS}}</option>
        <option value="600">0.6 {{_Lang.APP_THEME_L_THEME_SPEED_SECONDS}}</option>
        <option value="700">0.7 {{_Lang.APP_THEME_L_THEME_SPEED_SECONDS}}</option>
        <option value="800">0.8 {{_Lang.APP_THEME_L_THEME_SPEED_SECONDS}}</option>
        <option value="900">0.9 {{_Lang.APP_THEME_L_THEME_SPEED_SECONDS}}</option>
        <option value="1000">1 {{_Lang.APP_THEME_L_THEME_SPEED_SECONDS}}</option>
      </select>
    </li>
  </ul>
  <div ng-if="theme.effect == 1 && theme.effect_file.thumb" class="setting-bg">
    <div class="item-cuttent-bg">
      {{_Lang.APP_THEME_L_THEME_CURRENT_IMAGE}}
      <div style="width: 100%;background-repeat: no-repeat;height: 100px;background-size: contain;background-position: center;background-image: url({{theme.effect_file.thumb}})">
        <div class="action-bg">
          <span ng-class="(theme.effect_play == 1) ? 'fa fa-pause-circle':'fa fa-play-circle'" ng-click="theme.effect_play = !theme.effect_play" id="start_stop" class="removebgnoew"></span>
          <span class="removebgnoew fa fa-remove" ng-click="RemoveEffectFile()"></span>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css" class="ng-scope">
  #page-effect .margin-top-10 {
    margin-top: 10px;
  }
  #page-effect .allow-box label {
    width: 50%;
    text-transform: capitalize;
    font-size: 14px;
  }

  #page-effect .allow-box label span {
    margin-left: 10px;
    margin-top: -5px;
  }
  #page-effect .setting-bg {
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
  #page-effect .is_full {
    width: 49%;
    display: inline-block;
  }

  #page-effect .is_full .btn-group {
    width: 100%;
  }

  #page-effect .is_full input[type="radio"] {
    display: none;
  }

  #page-effect .is_full input[type="radio"]+.btn-group>label span:first-child {
    display: none;
  }

  #page-effect .is_full input[type="radio"]+.btn-group>label span:last-child {
    display: inline-block;
  }

  #page-effect .is_full input[type="radio"]:checked+.btn-group>label span:first-child {
    display: inline-block;
  }

  #page-effect .is_full input[type="radio"]:checked+.btn-group>label span:last-child {
    display: none;
  }

  #page-effect .form-group .form-group {
    width: 50%;
    margin-bottom: 0;
  }

  #page-effect .label-left {
    width: 100%;
    border-radius: 0;
  }

  #page-effect .label-right {
    width: 70%;
  }

  #page-effect .form-group .form-group .btn-group {
    width: 100%;
  }
  #page-effect .action-bg{
    position: absolute; 
    top: 0;
    right: 0;
  }

  .bg-action {
      position: absolute;
      top: -30px;
      right: 10px;
  }
</style>