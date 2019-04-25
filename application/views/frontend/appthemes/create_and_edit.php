<?php $this->load->view("/frontend/appthemes/block/header");?>
<div class="is_page" id="page_theme" style="opacity: 0;height:  100vh; overflow: hidden;">
  <div ng-app="ThemeApp" id="appthemes" ng-controller="PageController">
    <style type="text/css">
      #iframe-content {
        width:{{currentScreen.size}}px!important;
        height:{{
          scaleScreen < 1  ? currentScreen.height  + (currentScreen.height - currentScreen.height * scaleScreen) : currentScreen.height
        }}px!important;  
        -ms-transform: scale({{scaleScreen}});
        -moz-transform: scale({{scaleScreen}});
        -o-transform: scale({{scaleScreen}});
        -webkit-transform: scale({{scaleScreen}});
        transform: scale({{scaleScreen}});
        -ms-transform-origin: 0 0;
        -moz-transform-origin: 0 0;
        -o-transform-origin: 0 0;
        -webkit-transform-origin: 0 0;
        transform-origin: 0 0;
      }
    </style>
    <div id="sidebar">
      <div class="box-open-close">
        <a ng-click="ToggleSidaber($event)" href="javascript:;" class="c-hamburger" id="icon-cog-section">
          <span class="fa fa-cog"></span>
        </a>
      </div>
      <div id="nav-menu" class="content-fix">
        <ul class="nav nav-tabs setting-box">
          <li ng-class="(taggetTab == 0) ? 'active' : ''"><a ng-click="taggetTab=0;" data-toggle="tab" href="#theme-setting">{{_Lang.APP_THEME_L_THEME_SETTING}}</a></li>
          <li ng-class="(taggetTab == 1) ? 'active' : ''"><a ng-click="taggetTab=1;" data-toggle="tab" href="#sections-setting">{{_Lang.APP_THEME_L_THEME_SECSSION}}</a></li>
        </ul>
        <div class="tab-content">
          <div ng-class="(taggetTab == 0) ? 'active' : ''" id="theme-setting" class="tab-pane fade in">
            <div id="scrollbars">
              <ul class="nav-list-sections list_category">
                <li class="section"><i class="fa fa-eye" aria-hidden="true"></i>{{_Lang.APP_THEME_L_MENU_THEME1}}
                  <div class="TriSea-technologies-Switch pull-right">
                    <input id="TriSeaPrimary" ng-true-value="1" ng-false-value="0" ng-model="mode" name="TriSea1" type="checkbox"/>
                    <label for="TriSeaPrimary" class="label-primary"></label>
                  </div>
                </li>
                <li ng-class="(menu.load == 1) ? 'loadding' : ''" ng-repeat="menu in menus" ng-click="getContentmenu()" class="section" id="{{menu.id}}"><i class="{{menu.icon}}"></i> {{(menu.name + ((menu.id == 'page-screen') ? ' ' + currentScreen.size+"px" : ""))}}</li>
                <li class="section" ng-if="_Lang" ng-click="PublicToDomain($event)"><i class="fa fa-heart" aria-hidden="true"></i>{{_Lang.APP_THEME_L_MENU_THEME8}}</li>
                <li class="save-box">
                  <div ng-click="Public()" ng-if="_Lang" class="save-box-left"><i class="fa fa-floppy-o" aria-hidden="true"></i>{{_Lang.APP_THEME_L_MENU_THEME9}}</div>
                  <div ng-click="Review()" ng-if="_Lang" class="disable save-box-right"><i class="fa fa-telegram" aria-hidden="true"></i>{{_Lang.APP_THEME_L_MENU_THEME10}}</div>
                </li>
              </ul>
            </div>
          </div>
          <div ng-class="(taggetTab == 1) ? 'active' : ''" id="sections-setting" class="tab-pane fade in">
            <div id="scrollbars">
              <ul sectionsmenu data-support="section" class="nav-list-sections list_category">
                <li ng-click="ToSection(section)" ng-repeat="section in sections" class="section" ramkey="{{section.ramkey}}"><span>{{section.name}}</span><div class="action"><a ng-click="$event.stopPropagation();" href="javascript:;" id="move-action"><i class="fa fa-arrows" aria-hidden="true"></i></a><a ng-click="$event.stopPropagation(); SectionDelete(section);" href="javascript:;" id="delete-section"><i class="fa fa-trash" aria-hidden="true"></i></a></div></li>
              </ul>
              <div class="save-box"><div ng-click="AddItem('theme')" class="disable save-box-right full-width" href="javascript:;">+ {{_Lang.APP_THEME_L_ADD}}</div></div>
            </div>
          </div>
        </div>
        <div id="sidebar-actions" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{action_name}}</h3><a class="close-actions" ng-click="CloseActions()" href="javascript:;">X</a></div>
          </div>
          <div id="scrollbars" class="actions-body" compile="action_body"></div>
          <div class="actions-bottom" compile="action_bottom"></div>
        </div>
        <div id="sidebar-single" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{single_name}}</h3><a class="close-actions" ng-click="CloseSingle()" href="javascript:;"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            </div>
          </div>
          <div id="scrollbars" class="actions-body" compile="single_body"></div>
          <div class="actions-bottom" compile="action_bottom"></div>
        </div>
        <div id="sidebar-section" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{section.name}}</h3><a class="close-actions active" ng-click="CloseSection()" href="javascript:;"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></div>
          </div>
          <div id="scrollbars" class="actions-body">
            <ul class="nav nav-tabs setting-box">
              <li ng-class="(taggetTab == 0) ? 'active' : ''"><a ng-click="taggetTab=0;" data-toggle="tab" href="#section-setting">{{_Lang.APP_THEME_L_THEME_SETTING}}</a></li>
              <li ng-class="(taggetTab == 1) ? 'active' : ''"><a ng-click="taggetTab=1;" data-toggle="tab" href="#section-blocks">{{_Lang.APP_THEME_L_THEME_SECSSION}}</a></li>
            </ul>
            <div class="tab-content" id="scrollbars">
              <div ng-class="(taggetTab == 0) ? 'active' : ''" id="section-setting" class="tab-pane fade in" compile="section.html_setting"></div>
              <div ng-class="(taggetTab == 1) ? 'active' : ''" data-support="block" id="section-blocks" class="tab-pane fade in">
                <ul blocksmenu class="nav-list-sections list_category">
                  <li ng-if="block.actions.length > 0 || block.id == section.default_block" ng-click="ToBlock()" ng-repeat="block in section.blocks" ramkey="{{block.ramkey}}"><span>{{block.name}}</span><div class="action"><a href="javascript:;" id="delete-section"><i class="fa fa-pencil" aria-hidden="true"></i></a></div></li>
                </ul>
                <div class="save-box" ng-if="section.default_block != 0">
                  <div ng-click="MoveBlockDefault(section)" href="javascript:;" class="save-box-left">{{_Lang.APP_THEME_L_THEME_ORDER}}</div>
                  <div ng-click="AddNewBlock()" href="javascript:;" class="disable save-box-right">+ {{_Lang.APP_THEME_L_THEME_ADD}}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="sidebar-order-block" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{_Lang.APP_THEME_L_THEME_ORDER}}</h3><a class="close-actions" ng-click="CloseOrderBlock()" href="javascript:;"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a></div>
          </div>
          <div id="scrollbars" class="actions-body">
            <ul blocksmenu class="nav-list-sections list_category">
              <li class="not-after" ng-if="block.id == section.default_block" ng-click="ToBlock()" ng-repeat="block in section.blocks" ramkey="{{block.ramkey}}"><span>{{block.name}}</span><div class="action"><a ng-click="$event.stopPropagation(); BlockDelete(block,section);" href="javascript:;" id="delete-section"><i class="fa fa-trash" aria-hidden="true"></i></a><a ng-click="$event.stopPropagation();" href="javascript:;" id="move-action"><i class="fa fa-arrows" aria-hidden="true"></i></a></div></li>
            </ul>
          </div>
        </div>
        <div id="sidebar-chosse" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{chosse_name}}</h3><a class="close-actions" ng-click="CloseChosse()" href="javascript:;"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            </div>
          </div>
          <div id="scrollbars" class="actions-body" compile="chosse_body"></div>
          <div class="actions-bottom" compile="action_bottom"></div>
        </div>
        <div id="sidebar-chang-style-section" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{section.name}}</h3><a class="close-actions" ng-click="ClosechangeSectionStyle()" href="javascript:;"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            </div>
          </div>
          <div id="scrollbars" class="actions-body">
            <div id="section-style">
              <ul class="nav nav-tabs">
                <li ng-class="tabsectionstyle != 1 ? 'active' : ''"><a ng-click="tabsectionstyle = 0;" data-toggle="tab" href="#image">{{_Lang.APP_THEME_L_THEME_BACKGROUND_IMAGE}}</a></li>
                <li ng-class="tabsectionstyle == 1 ? 'active' : ''"><a ng-click="tabsectionstyle = 1" data-toggle="tab" href="#color">{{_Lang.APP_THEME_L_THEME_BACKGROUND_COLOR}}</a></li>
              </ul>
              <div class="tab-content">
                <div id="scrollbars">
                  <div id="image" ng-class="tabsectionstyle != 1 ? 'active': ''" class="tab-pane fade in">
                    <ul class="nav-list-items list_category">
                      <li uploads="" data-max="1" data-type="image" data-action="background-image"><i class="fa fa-upload" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_UPLOAD_IMAGE}}</li> 
                      <li openfilemanager="" href="javascript:;" class="ui-button-text" data-action="background-image" data-type="image" data-max="1" id="openFilemanager"><i class="fa fa-folder-open" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_OPEN_LIBRARY_IMAGE}}</li>         
                      <li ng-class="(type.load == 1) ? 'loadding' : ''" ng-repeat="type in backgroundType" ng-click="getActionType(type)" class="item" id="{{type.id}}"><i class="fa fa-clone" aria-hidden="true"></i>{{type.name}}</li>
                      <li class="item not-after">
                        <p>{{_Lang.APP_THEME_L_THEME_REPEAT}}</p>
                        <select id="style-repeat" class="form-control" ng-model="section.style['background-repeat']">
                          <option value="">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
                          <option ng-repeat ="item in background_repeat" value="{{item.value}}">{{item.label}}</option>
                        </select>
                      </li>
                      <li class="item not-after">
                        <p>{{_Lang.APP_THEME_L_THEME_BACKGROUND_SIZE}}</p>
                        <select class="form-control" id="style-size" ng-model="section.style['background-size']">
                          <option value="">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
                          <option ng-repeat ="item in background_size" value="{{item.value}}">{{item.label}}</option>
                        </select>
                      </li>
                      <li class="item not-after">
                        <p>{{_Lang.APP_THEME_L_THEME_BACKGROUND_POSITION}}</p>
                        <select  class="form-control" id="style-position" ng-model="section.style['background-position']">
                          <option value="">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
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
                        <p>{{_Lang.APP_THEME_L_THEME_CURRENT_BACKGROUND_IMAGE}}</p>
                        <div style="width: 100% ;height: 180px;background-size: cover; background-image: {{section.style['background-image']}}"><div class="action-bg"><span class="removebgnoew fa fa-remove" ng-click="RemoveBg(0)"></span></div></div>
                      </div>
                      <div class="item-cuttent-bg" ng-if="(section.style['background-color'] && section.style['background-color'] != 'inherit')">
                        <p>{{_Lang.APP_THEME_L_THEME_CURRENT_BACKGROUND_COLOR}}<div style="float: right;margin-left: 20px;width: 30px; height: 30px;background-color: {{section.style['background-color']}}"></div> <div class="action-bg"><span class="removebgnoew fa fa-remove" ng-click="RemoveBg(1)"></span></div></p>
                      </div>
                  </div> 
                </div>
              </div>
          </div>
          </div>
        </div>
        <div id="sidebar-change-setting-title-section" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{_Lang.APP_THEME_L_THEME_SETTING_TITLE}}</h3><a class="close-actions" ng-click="ClosechangeSectionSetting()" href="javascript:;"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            </div>
          </div>
          <div id="scrollbars" class="actions-body">
            <div id="section-style">
              <div class="tab-content">
                <div id="scrollbars">
                  <div>
                    <ul class="nav-list-items list_category">
                      <li class="item not-after">
                        <input type="text" ng-model="section['name']" class="form-control"  ng-value="section['name']">
                      </li>
                      <li class="item not-after">
                        <p>{{_Lang.APP_THEME_L_THEME_COLOR_TEXT}}</p>
                        <input colorpicker type="text" ng-model="section['title_color']" ng-value="section['title_color']">
                      </li>
                       <li class="item not-after">
                        <p>{{_Lang.APP_THEME_L_THEME_FONT_SIZE}}</p>
                        <select class="form-control" ng-model="section['title_size']" ng-value="section['title_size']">
                          <option value="">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
                          <option ng-repeat ="item in [10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100] track by $index" value="{{item + 'px'}}">{{item + 'px'}}</option>
                        </select>
                      </li>
                      <li class="item not-after">
                        <p>{{_Lang.APP_THEME_L_THEME_FONT_FAMILY}}</p>
                        <select class="form-control" ng-model="section['title_family']" ng-value="section['title_family']">
                          <option value="">-- {{_Lang.APP_THEME_L_THEME_SELECT_ONE}} --</option>
                          <option ng-repeat ="item in AllFontFamily track by $index" value="{{item[1]}}">{{item[0]}}</option>
                        </select>
                      </li>
                    </ul>  
                  </div>
                </div>
              </div>
          </div>
          </div>
        </div>
         <div id="sidebar-change-setting-effect-section" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{_Lang.APP_THEME_L_THEME_SETTING_EFFECT}}</h3><a class="close-actions" ng-click="ClosechangeSectionSetting()" href="javascript:;"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            </div>
          </div>
          <div id="scrollbars" class="actions-body">
            <div id="section-style">
              <div class="tab-content">
                <div id="scrollbars">
                  <div>
                    <ul class="nav-list-items list_category">
                        <li>
                          <i class="fa fa-adjust" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_OPEN_EFFECT}}
                          <div class="TriSea-technologies-Switch pull-right">
                            <input id="TriSeaPrimaryshow_is_effect" ng-click="changeEffectSection()" ng-checked="section.is_effect == 1 || section.is_effect == true" name="is_effect" type="checkbox"/>
                            <label for="TriSeaPrimaryshow_is_effect" class="label-primary"></label>
                          </div>
                        </li>
                        <li ng-if="section.is_effect != 0">
                          <i class="fa fa-calendar-check-o" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_ALWAYS_OPEN}}
                          <div class="TriSea-technologies-Switch pull-right">
                            <input id="TriSeaPrimaryshow_everyday_effect" ng-click="changeEffectDaySection()"  ng-checked="section.everyday_effect == 1" name="everyday_effect" type="checkbox"/>
                            <label for="TriSeaPrimaryshow_everyday_effect" class="label-primary"></label>
                          </div>
                        </li>
                        <li class="item not-after" ng-if="section.everyday_effect != 1 && section.is_effect != 0">
                          <p><i class="fa fa-calendar" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_FROM_DAY}} :</p>
                          <input day type="text" ng-model="section.from_day_effect" name="from_day" class="form-control">
                        </li>
                        <li ng-if="section.is_effect != 0">
                          <i class="fa fa-play" aria-hidden="true"></i>{{_Lang.APP_THEME_L_THEME_VIEW_FLASH}}
                          <div class="TriSea-technologies-Switch pull-right">
                              <input id="TriSeaPrimaryshow_run_effect" ng-model="section.run_effect" ng-true-value="1" ng-false-value="0" ng-checked="section.run_effect == 1 || section.run_effect == true" name="run_effect" type="checkbox"/>
                              <label for="TriSeaPrimaryshow_run_effect" class="label-primary"></label>
                          </div>
                        </li>
                    </ul>  
                  </div>
                </div>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>
    <div id="bar-preview">
      <ul class="inline-block left right">
          <li>
           <select class="form-control" ng-model="currentScreen" ng-options="item as ( _Lang.APP_THEME_L_THEME_SCREEN + item.label) for item in screens track by item.size"></select>
         </li>
          <li>
            <a ng-click="Public()"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
          </li>
           <li>
            <a ng-click="Review()"><i class="fa fa-telegram" aria-hidden="true"></i></a>
          </li> 
          <li>
            <a href="<?php echo base_url("themes");?>" class="c-hamburger" id="icon-cog-section">
              <i class="fa fa-th" aria-hidden="true"></i>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url();?>" class="c-hamburger" id="icon-cog-section">
              <i class="fa fa-home" aria-hidden="true"></i>
            </a>
          </li>
          <?php if(isset($is_login) && $is_login): ?>
          <li>           
              <div class="dropdown nav-profile">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img class="img-circle" width="40" height="40" src="<?php echo @$user['avatar']; ?>">
                </a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url('/profile'); ?>"><i class="fa fa-user-circle" aria-hidden="true"></i> Thông tin cá nhân</a></li>
                  <?php if( @$user['sub_domain'] || @$user['domain']):?>
                    <?php if(@$user['domain'] == null):?>
                      <?php if(@$user['sub_domain']):?>
                        <li><a href="//<?php echo @$user['sub_domain']; ?>"><i class="fa fa-tripadvisor" aria-hidden="true"></i> Trang tường</a></li>
                      <?php endif;?>
                    <?php else : ?>
                      <li><a href="//<?php echo @$user['domain']; ?>"><i class="fa fa-tripadvisor" aria-hidden="true"></i> Trang tường</a></li>
                    <?php endif;?>
                  <?php endif;?>
                  <li><a href="<?php echo base_url('/themes/my/'); ?>"><i class="fa fa-th" aria-hidden="true"></i> Giao diện của bạn</a></li>
                  <li><a href="<?php echo base_url('/profile/change_password'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Đổi mật khẩu</a></li>
                  <li><a href="<?php echo base_url('/profile/payment_history'); ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> Lịch sử thanh toán</a></li>
                  <li><a href="<?php echo base_url('/invite/'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> Mời bạn bè</a></li>
                  <li><a href="<?php echo base_url('/profile/logout/'); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a></li>
                </ul>
              </div>
          </li>
          <?php endif; ?>
      </ul>
    </div>
    <div id="content">
      <table height="100%" width="100%">
        <tr>
          <td valign="middle" align="center">
            <iframe iframe-onload="iframeLoadedCallBack()" id="iframe-content" ng-src="<?php echo base_url('/appthemes/iframe?time='.uniqid())?>"></iframe>
          </td>
        </tr>
      </table>
    </div>
    <div class="fix-box-action-runing">
      <a ng-if="audio_play" ng-click="soundStartStop()" href="javascript:;" ng-class="audio_play == 1 ? 'active' : ''"><i class="fa fa-music"></i></a>
      <a ng-if="theme.effect_play" ng-class="theme.effect_play == 1 ? 'active' : ''" ng-click="theme.effect_play = !theme.effect_play" href="javascript:;"><i class="fa fa-snowflake-o"></i></a>
    </div>
    <div id="modal-page">
        <div id="modal-edit-block" class="modal fade" role="dialog">
          <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div ng-class="block.class_name" class="modal-body" compile="block.html_setting"></div>
              <div class="modal-footer text-right">
                <button data-dismiss="modal" aria-label="Close" class="btn btn-primary relative"><i class="fa fa-angle-double-down" aria-hidden="true"></i> Đóng</button>
              </div>
            </div>
          </div>
        </div>
        <div id="modal-delete-item" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body"><h3>{{_Lang.APP_THEME_L_THEME_CONFIRM}}</h3></div>
              <div class="modal-footer text-right">
                  <button type="button" class="btn btn-default" data-dismiss="modal">{{_Lang.APP_THEME_L_NO}}</button>
                  <button ng-click="DeleteItem()" class="btn btn-warning relative">{{_Lang.APP_THEME_L_YES}}</button>
              </div>
            </div>
          </div>
        </div>
        <div id="modal-edit-part" class="modal fade" role="dialog">
          <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="modal-body" compile="part.html_setting"></div>
            </div>
          </div>
        </div>
        <div id="modal-review" class="modal fade" role="dialog">
          <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
              <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fa fa-close" aria-hidden="true"></span>
              </a>
              <div class="modal-body">
                <iframe ng-if="review == 1" id="iframe-review" ng-src="{{'/appthemes/view/' + theme.slug + '?iframe=true'}}" src="#"></iframe>
              </div>
            </div>
          </div>
        </div>
        <div class="modal" id="modal-domain" class="modal fade" role="dialog">
          <div class="modal-dialog " role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="modal-header">
                <h1 class="modal-title text-center">{{_Lang.APP_THEME_L_PUBLIC_DOMAIN}}</h1>
              </div>
              <div class="modal-body">
                <div class="text-center" id="message-box"> </div>
              </div>
              <div class="modal-footer text-right">
                <button data-dismiss="modal" aria-label="Close" class="btn btn-primary relative"><i class="fa fa-angle-double-down" aria-hidden="true"></i> Đóng</button>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div id="box-upload" class="none">
      <input type="file" class="none" ng-model="changeupload" onchange="angular.element(this).scope().Upload(this)" name="upload" id="upload">
      <input type="file" class="none" ng-model="changeuploads" onchange="angular.element(this).scope().Uploads(this)" name="uploads" id="uploads" multiple>
    </div>
    <effictelent ng-if="theme.effect_play == 1"></effictelent>
    <script ng-if="theme.script_url" type="text/javascript" ng-src="{{theme.script_url}}"></script>
  </div>
</div>

<!--config theme-->
<!--load font-->

<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/skins/css/frontend.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/skins/css/themes.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/skins/css/common.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/jquery-ui/jquery-ui.min.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/colorpicker/css/evol-colorpicker.css")?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/bootstrap-slider/css/bootstrap-slider.css");?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/datetimepicker/build/jquery.datetimepicker.min.css");?>">

<script type="text/javascript">
  var AppAccess = "<?php echo base_url();?>";
  var AppAccessCotroller = "<?php echo base_url();?>";
  var AppAccessSkin = AppAccess + "skins/themes/";
  var AppTemplates = AppAccessSkin + "templates/";
  var AppTemplatesSidebar = AppTemplates + "sidebar/";
  var AppTemplatesContent = AppTemplates + "content/";
  var ThemeID = "<?php echo @$post["id"] ? $post["id"] : 0 ?>";
  var IsCreate = "<?php echo @$post["is_create"] ? $post["is_create"] : 0 ?>";
  var Ramkey = "<?php echo uniqid()?>";
</script>
<script type="text/javascript" src="<?php echo skin_url("themes/datetimepicker/build/jquery.datetimepicker.full.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/bootstrap-slider/bootstrap-slider.js");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/jquery-ui/jquery-ui.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/angular/angular.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/filemanager/filemanager.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/colorpicker/js/evol-colorpicker.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/jquery.snow/jquery.snow.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/tinymce/tinymce.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/tinymce/jquery.tinymce.min.js")?>"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_rQqp15I-s5F0f9gmPp2G3bFeFaeHE1k&libraries=places"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/angular/ng-map.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/skins/js/main-frontend.js")?>"></script>
<?php $this->load->view("/frontend/appthemes/block/footer");?>
