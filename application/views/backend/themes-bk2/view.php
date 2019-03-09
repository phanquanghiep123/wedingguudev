<?php $this->load->view("/backend/themes/block/header");?>
<div class="is_page" id="page_theme">
  <div ng-app="ThemeApp" ng-controller="PageController">
    <div id="sidebar">
      <div id="nav-menu" class="content-fix">
        <ul class="nav nav-tabs setting-box">
          <li ng-class="(taggetTab == 0) ? 'active' : ''"><a ng-click="taggetTab=0;" data-toggle="tab" href="#theme-setting">Cài đặt</a></li>
          <li ng-class="(taggetTab == 1) ? 'active' : ''"><a ng-click="taggetTab=1;" data-toggle="tab" href="#sections-setting">Thành phần</a></li>
        </ul>
        <div class="tab-content">
          <div ng-class="(taggetTab == 0) ? 'active' : ''" id="theme-setting" class="tab-pane fade in">
            <div id="scrollbars">
              <ul class="nav-list-sections list_category">
                <li ng-class="(section.load == 1) ? 'loadding' : ''" ng-repeat="section in menus" ng-click="getContentmenu(section)" class="section" id="{{section.id}}">{{section.name}}</li>
                <li class="save-box">
                  <div ng-click="Public()" class="save-box-left">lƯU</div>
                  <div class="disable save-box-right">lƯU & XEM</div>
                </li>
              </ul>
            </div>
          </div>
          <div ng-class="(taggetTab == 1) ? 'active' : ''" id="sections-setting" class="tab-pane fade in">
            <div id="scrollbars">
              <ul sectionsmenu data-support="section" class="nav-list-sections list_category">
                <li ng-click="ToSection()" ng-repeat="section in sections" class="section" ramkey="{{section.ramkey}}"><span>{{section.name}}</span><div class="action"><a ng-click="$event.stopPropagation(); SectionDelete($index);" href="javascript:;" id="delete-section"><i class="fa fa-trash" aria-hidden="true"></i></a><a ng-click="$event.stopPropagation();" href="javascript:;" id="move-action"><i class="fa fa-arrows" aria-hidden="true"></i></a></div></li>
              </ul>
              <div class="save-box"><div ng-click="AddItem('theme')" class="disable save-box-right full-width" href="javascript:;">+ Thêm</div></div>
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
              <h3 class="action_name">{{single_name}}</h3><a class="close-actions" ng-click="CloseSingle()" href="javascript:;"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>
            </div>
          </div>
          <div id="scrollbars" class="actions-body" compile="single_body"></div>
          <div class="actions-bottom" compile="action_bottom"></div>
        </div>
        <div id="sidebar-section" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{section.name}}</h3><a class="close-actions" ng-click="CloseSection()" href="javascript:;"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a></div>
          </div>
          <div id="scrollbars" class="actions-body">
            <ul class="nav nav-tabs setting-box">
              <li ng-class="(taggetTab == 0) ? 'active' : ''"><a ng-click="taggetTab=0;" data-toggle="tab" href="#section-setting">Cài đặt</a></li>
              <li ng-class="(taggetTab == 1) ? 'active' : ''"><a ng-click="taggetTab=1;" data-toggle="tab" href="#section-blocks">Thành phần</a></li>
            </ul>
            <div class="tab-content" id="scrollbars">
              <div ng-class="(taggetTab == 0) ? 'active' : ''" id="section-setting" class="tab-pane fade in" compile="section.html_setting"></div>
              <div ng-class="(taggetTab == 1) ? 'active' : ''" data-support="block" id="section-blocks" class="tab-pane fade in">
                <ul blocksmenu class="nav-list-sections list_category">
                  <li ng-if="block.actions.length > 0" ng-mouseover="hoverInBlock()" ng-mouseleave="hoverOutBlock()" ng-click="ToBlock()" ng-repeat="block in section.blocks" ramkey="{{block.ramkey}}"><span>{{block.name}}</span><div class="action"><a href="javascript:;" id="delete-section"><i class="fa fa-pencil" aria-hidden="true"></i></a></div></li>
                </ul>
                <div class="save-box" ng-if="section.default_block != 0">
                  <div ng-click="MoveBlockDefault(section)" href="javascript:;" class="save-box-left">Xắp xếp</div>
                  <div ng-click="AddNewBlock()" href="javascript:;" class="disable save-box-right">+ Thêm</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="sidebar-order-block" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">Xắp xếp</h3><a class="close-actions" ng-click="CloseOrderBlock()" href="javascript:;"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a></div>
          </div>
          <div id="scrollbars" class="actions-body">
            <ul blocksmenu class="nav-list-sections list_category">
              <li ng-mouseover="hoverInBlock()" ng-mouseleave="hoverOutBlock()" class="not-after" ng-if="block.id == section.default_block" ng-click="ToBlock()" ng-repeat="block in section.blocks" ramkey="{{block.ramkey}}"><span>{{block.name}}</span><div class="action"><a ng-click="$event.stopPropagation(); SectionDelete($index);" href="javascript:;" id="delete-section"><i class="fa fa-trash" aria-hidden="true"></i></a><a ng-click="$event.stopPropagation();" href="javascript:;" id="move-action"><i class="fa fa-arrows" aria-hidden="true"></i></a></div></li>
            </ul>
          </div>
        </div>
        <div id="sidebar-chosse" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{chosse_name}}</h3><a class="close-actions" ng-click="CloseChosse()" href="javascript:;"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>
            </div>
          </div>
          <div id="scrollbars" class="actions-body" compile="chosse_body"></div>
          <div class="actions-bottom" compile="action_bottom"></div>
        </div>
        <div ng-class="is_changeSectionStyle == true ? 'open' : '' "  id="sidebar-chang-style-section" class="content-actions">
          <div class="actions-top">
            <div class="bg-white">
              <h3 class="action_name">{{section.name}}</h3><a class="close-actions" ng-click="is_changeSectionStyle = false;" href="javascript:;"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>
            </div>
          </div>
          <div id="scrollbars" class="actions-body" compile="section.html_style"></div>
        </div>
      </div>
    </div>
    <div id="content" class="{{mode_class}}">
      <sections class="list-sections" ng-style="theme.style">
        <section ng-repeat="section in sections" class="section-item {{section.class_name}}" ramkey="{{section.ramkey}}" ng-attr-data-index="{{$index}}" data-index>
          <div id="content-section" ng-class="section.is_full == 0 ? 'container' : 'container-full'" ng-style="section.style">
            <div class="wrapper-section">            
              <blocks class="row list-blocks">
                <div class="default-block block-title" ng-if="section.show_title == 1">
                  <h2 class="title-default" ng-style="{'font-size':theme.size_title == 0 ? '' : theme.size_title +'px' ,'color':theme.color_title};"">{{section.name}}</h2>
                </div>
                <block ng-class="[{true :'not-edit'}[block.actions.length == 0],{true : 'active'}[block.active == 1]]" ng-if="blockShow(section,block)" ng-repeat="block in section.blocks" class="col-md-{{block.ncolum}} block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index >
                  <div class="wrapper-block">
                    <div ng-if="mode == 0" class="menu-action" id="support_block">
                      <ul ng-if="block.actions.length > 0" class="menu-block" compile="ActionBlock(section)">
                      </ul>
                    </div>
                    <parts class="row list-parts">
                      <part ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>
                        <metadatas class="{{part.name}}" data-is="{{part.name}}">
                          <metadata ng-attr-data-value="{{(part.metas[0].meta_key != 'value_media') ? part.metas[0].value : part.metas[0].thumb}}" data-value="" class="{{part.metas[0].meta_key}}" compile="MetaShow()" ng-attr-data-index="0" data-index></metadata>
                        </metadatas>
                      </part>
                    </parts>
                  </div>
                </block>            
                <div  ng-if="section.default_block > 0">
                  <defaultblock ng-attr-data-index="{{$index}}" data-index data-item="{{section.ncolum_block}}" data-type = "{{section.class_name}}" class="list-block-default">
                      <block ng-class="[{true :'not-edit'}[block.actions.length == 0],{true : 'active'}[block.active == 1]]" ng-repeat="block in section.blocks" ng-if="section.default_block == block.id" class="col-md-{{block.ncolum}} block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index>
                        <div class="wrapper-block">
                          <div ng-if="mode == 0" class="menu-action" id="support_block">
                            <ul class="menu-block" compile="ActionBlock(section)">
                            </ul>
                          </div>
                          <parts class="row list-parts">
                            <part ng-if="part.metas.length > 0" ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>
                              <metadatas class="{{part.name}}" data-is="{{part.name}}">
                                <metadata ng-attr-data-value="{{(part.metas[0].meta_key != 'value_media') ? part.metas[0].value : part.metas[0].thumb}}" data-value="" class="{{part.metas[0].meta_key}}" compile="MetaShow()" ng-attr-data-index="0" data-index></metadata>
                              </metadatas>
                            </part>
                          </parts>
                        </div>
                      </block>  
                  </defaultblock>
                </div>
              </blocks> 
            </div>
          </div>
          <div ng-if="mode == 0" class="menu-action" id="support_section">
            <ul class="menu-block" compile="ActionSection(section)"></ul>
          </div> 
          <fireworks ng-if="$index%2==0"></fireworks>
        </section>
      </sections>
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
          </div>
        </div>
      </div>
      <div id="modal-delete-item" class="modal fade" role="dialog">
        <div class="modal-dialog ">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body"><h3>Bạn muốn làm điều này!</h3></div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                <button ng-click="DeleteItem()" class="btn btn-warning relative">Xóa</button>
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
            <div class="modal-body"><iframe ng-src="{{'/themes/view/' + theme.id}}" src="#"></iframe></div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đống</button>
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
    <link ng-if="theme.font" rel="stylesheet" type="text/css" ng-href="{{theme.font.path_file}}">
    <link ng-if="theme.style_url" rel="stylesheet" type="text/css" ng-href="{{theme.style_url}}">
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
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/datetimepicker/build/jquery.datetimepicker.min.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/bxslider/dist/jquery.bxslider.min.css")?>"/>
<script type="text/javascript">
  var AppAccess = "<?php echo base_url();?>";
  var AppAccessCotroller = "<?php echo base_url();?>";
  var AppAccessSkin = AppAccess + "public/themes/";
  var AppTemplates = AppAccessSkin + "templates/";
  var AppTemplatesSidebar = AppTemplates + "sidebar/";
  var AppTemplatesContent = AppTemplates + "content/";
  var ThemeID = "<?php echo @$post["id"] ? $post["id"] : 0 ?>";
  var IsCreate = "<?php echo @$post["is_create"] ? $post["is_create"] : 0 ?>";
  var Ramkey = "<?php echo uniqid()?>";
</script>
<script type="text/javascript" src="/skins/plugin-sc/js/jquery.countdown/jquery.countdown.min.js"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/bxslider/dist/jquery.bxslider.min.js");?>"></script>
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
<script type="text/javascript" src="<?php echo skin_url("themes/skins/js/main-view.js")?>"></script>
<?php $this->load->view("/backend/themes/block/footer");?>
