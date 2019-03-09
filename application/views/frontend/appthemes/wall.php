<div class="is_page" id="page_theme" style="display: none;">
  <div ng-app="ThemeApp" ng-controller="PageController">
    <div id="bar-preview">
      <ul class="inline-block left right">
        <li>
          <a href="javascript:;" class="c-hamburger" id="icon-cog-section">
            <span class="fa fa-cog"></span>
          </a>
        </li> 
        <li ng-if="(theme.sound && theme.sound != false && theme.sound != 'false')" ng-if="(theme.sound == 1)"><a ng-click="soundStartStop()" href="javascript:;"  ng-class="theme.sound_play == 1 ? 'active' : ''"><i class="fa fa-music"></i></a></li>
        <li ng-if="(theme.effect == 1)"><a ng-click="theme.effect_play = !theme.effect_play" href="javascript:;" ng-class="theme.effect_play == 1 ? 'active' : ''" ><i class="fa fa-snowflake-o"></i></a></li>
        <li><a ng-href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url()?>appthemes/view/{{theme.slug}}&t={{theme.name}}" target="_blank" href=""><i class="fa fa-facebook-f" aria-hidden="true"></i></a></li>
        <li>
          <a href="<?php echo base_url()?>" class="c-hamburger">
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
        <?php else:?>
          <li>
            <a href="<?php echo base_url("/account/login/");?>" class="c-hamburger sign-in" id="icon-logout-section">
              <span class="fa fa-sign-in"> </span>
            </a>
          </li>
        <?php endif?>
      </ul>
    </div>
    <div id="sidebar" class="priview-sidebar">
      <div id="nav-menu" class="content-fix">
         <div id="scrollbars">
          <ul data-support="section" class="nav-list-sections list_category">
            <li ng-class="section.active == 1 ? 'active' : ''"  ng-click="ToSection()" ng-repeat="section in sections" class="section" ramkey="{{section.ramkey}}"><span>{{section.name}}</span></li>
          </ul>
        </div>   
      </div>
    </div>
    <div class="{{mode_class}}" pageresize>
       <sections class="list-sections" ng-style="theme.style">
        <section ng-init="CreateBlockGroup($index)" ng-repeat="section in sections" class="section-item {{section.class_name}}" ramkey="{{section.ramkey}}" ng-attr-data-index="{{$index}}" data-index>
          <div id="content-section" ng-class="section.is_full == 0 ? 'container' : 'container-full'" ng-style="section.style">
            <div class="wrapper-section">            
              <blocks class="list-blocks">
                <div class="default-block block-title" ng-if="section.show_title == 1">
                  <h2 class="title-default" ng-style="
                    {
                      'font-size': section.title_size == 0 ? '' : section.title_size,
                      'color':section.title_color,
                      'font-family' : section.title_family,
                    };">{{section.name}}</h2>
                </div>
                <div class="row">
                  <block ng-class="[{true :'not-edit'}[block.actions.length == 0],{true : 'active'}[block.active == 1]]" ng-if="blockShow(section,block)" ng-repeat="block in section.blocks" class="col-xs-{{block.ncolum}} col-sm-{{block.ncolum}} col-md-{{block.ncolum}} col-lg-{{block.ncolum}} block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index >
                    <div class="wrapper-block">
                      <parts class="list-parts">
                        <div class="row">
                          <part ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} {{part.name}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>
                            <metadatas class="{{part.name}}" data-is="{{part.name}}">
                              <metadata ng-attr-data-value="{{(part.metas[0].meta_key != 'value_media') ? part.metas[0].value : part.metas[0].thumb}}" data-value="" class="{{part.metas[0].meta_key}}" compile="MetaShow()" ng-attr-data-index="0" data-index></metadata>
                            </metadatas>
                          </part>
                        </div>
                      </parts>
                    </div>
                  </block> 
                  <defaultblock ng-if="section.blocks_off.length > 0" section="section" ng-attr-data-index="{{$index}}" data-index data-item="{{section.ncolum_block}}" data-type = "{{section.class_name}}" class="list-block-default"></defaultblock>
                </div>
              </blocks> 
            </div>
          <fireworks ng-if="checkfireworks(section)"></fireworks>
          </div>
        </section>
      </sections>
    </div>
    <div id="modal-page">
      <div id="modal-view-block" class="modal fade" role="dialog">
        <div class="modal-dialog ">
          <!-- Modal content-->
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <div ng-class="block.class_name" class="modal-body">
                <div class="block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index>
                  <div class="wrapper-block">
                    <div class="list-parts">
                      <div ng-if="part.metas.length > 0" ng-repeat="part in block.parts" class="part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>
                        <div class="{{part.name}}" data-is="{{part.name}}">
                          <div ng-attr-data-value="{{(part.metas[0].meta_key != 'value_media') ? part.metas[0].value : part.metas[0].thumb}}" data-value="" class="{{part.metas[0].meta_key}}" compile="MetaShow(1)" ng-attr-data-index="0" data-index></div></div>
                      </div>
                    </div>
                  </div>
                </div> 
            </div>
          </div>
        </div>
      </div>
      <div class="modal" id="content-album-slider" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-grid">
          <div class="modal-content">
              <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div compile="block.more"></div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <effictelent ng-if="theme.effect_play == 1 && theme.effect == 1"></effictelent>
    <link ng-if="theme.font" rel="stylesheet" type="text/css" ng-href="{{theme.font.path_file}}">
    <link ng-if="theme.style_url" rel="stylesheet" type="text/css" ng-href="{{theme.style_url}}">
  </div>
</div>
<!--config theme-->
<!--load font-->
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/fancybox/dist/jquery.fancybox.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/skins/css/frontend.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/skins/css/themes.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/skins/css/common.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/jquery-ui/jquery-ui.min.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/colorpicker/css/evol-colorpicker.css")?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/bootstrap-slider/css/bootstrap-slider.css");?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/datetimepicker/build/jquery.datetimepicker.min.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/bxslider/dist/jquery.bxslider.min.css")?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/Waterfall/style.css")?>"/>
<script type="text/javascript">
  var AppAccess = "<?php echo base_url();?>";
  var AppAccessCotroller = "<?php echo base_url();?>";
  var AppAccessSkin = AppAccess + "public/themes/";
  var AppTemplates = AppAccessSkin + "templates/";
  var AppTemplatesSidebar = AppTemplates + "sidebar/";
  var AppTemplatesContent = AppTemplates + "content/";
  var ThemeID = "<?php echo @$post["id"] ;?>";
  var IsCreate = 2;
  var Ramkey = "<?php echo uniqid()?>";
  var sound_URL  = "<?php echo $post["sound_URL"]?>";
  var User_id = <?php echo $user_id;?>;
  var Privew = false;
</script>
<script type="text/javascript" src="<?php echo skin_url("themes/fancybox/dist/jquery.fancybox.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/jquery.countdown/jquery.countdown.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/bxslider/dist/jquery.bxslider.js");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/datetimepicker/build/jquery.datetimepicker.full.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/bootstrap-slider/bootstrap-slider.js");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/jquery-ui/jquery-ui.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/angular/angular.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/filemanager/filemanager.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/colorpicker/js/evol-colorpicker.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/tinymce/tinymce.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/tinymce/jquery.tinymce.min.js")?>"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_rQqp15I-s5F0f9gmPp2G3bFeFaeHE1k&libraries=places"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/jquery.snow/jquery.snow.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/angular/ng-map.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/jquery.fireworks/jquery.fireworks.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/Waterfall/newWaterfall.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/skins/js/hower.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/skins/js/main-view.js")?>"></script>