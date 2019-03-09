<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php base_url('/uploads/ckfinder/userfiles/files/123.png');?>" type="image/*">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Weddinguu - App Theme Iframe</title>
    <?php echo @$metas;?>
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo skin_url("themes/skins/css/bootstrap.min.css");?>">
    <link rel="stylesheet" href="<?php echo skin_url("themes/skins/css/responsive.css");?>">
    <!-- Optional theme -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?php echo skin_url("themes/skins/js/jquery.min.js");?>"></script>
    <script src="<?php echo skin_url("themes/skins/js/bootstrap.min.js");?>"></script>
    <script src="<?php echo skin_url("themes/skins/js/config.js");?>"></script>
    <link rel="stylesheet" href="<?php echo skin_url("themes/skins/css/font-awesome.css");?>" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body ng-app="ThemeAppIframe" id="body-iframe" ng-controller="PageIframeController">
  <link ng-if="parentWindow.theme.font" rel="stylesheet" type="text/css" ng-href="{{parentWindow.theme.font.path_file}}">
  <link ng-if="parentWindow.theme.style_url" rel="stylesheet" type="text/css" ng-href="{{parentWindow.theme.style_url}}">
  <div class="{{parentWindow.mode_class}}" >
    <sections class="list-sections" ng-style="parentWindow.theme.style">
        <section ng-init="CreateBlockGroup($index)" ng-class="section.active==1?'changing' : ''" ng-repeat="section in parentWindow.sections" class="section-item {{section.class_name}}" ramkey="{{section.ramkey}}" ng-attr-data-index="{{$index}}">
          <div id="content-section" ng-class="section.is_full == 0 ? 'container' : 'container-full'" ng-style="section.style">
            <div class="wrapper-section">         
              <blocks class="list-blocks">
                  <div class="default-block block-title" ng-if="section.show_title == 1">
                    <h2 class="title-default" ng-style="{ 'font-size': section.title_size == 0 ? '' : section.title_size, 'color':section.title_color, 'font-family' : section.title_family};">{{section.name}}</h2>
                  </div>
                  <div class="row">
                    <block ng-class="block.actions.length == 0 ? 'not-edit' : ''" ng-repeat="block in section.blocks_on" class="col-xs-{{block.ncolum}} col-sm-{{block.ncolum}} col-md-{{block.ncolum}} col-lg-{{block.ncolum}} block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index >
                      <div class="wrapper-block">
                        <div ng-if="parentWindow.mode == 0" class="menu-action" id="support_block">
                         <ul ng-if="block.actions.length > 0" class="menu-block" compile="parentWindow.ActionBlock(block,section)"></ul>
                        </div>
                        <parts class="list-parts">
                          <div class="row">
                            <part ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} {{part.name}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>
                              <metadatas class="{{part.name}}" data-is="{{part.name}}">
                                <metadata ng-attr-data-value="{{(part.metas[0].meta_key != 'value_media') ? part.metas[0].value : part.metas[0].thumb}}" data-value="" class="{{part.metas[0].meta_key}}" compile="parentWindow.MetaShow(part)" ng-attr-data-index="0" data-index></metadata>
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
          </div>
          <div ng-if="parentWindow.mode == 0" class="menu-action" id="support_section">
           <ul class="menu-block" compile="parentWindow.ActionSection(section)"></ul>
          </div>  
          <fireworks ng-if="section.run_effect == 1 && section.is_effect == 1"></fireworks>
        </section>
    </sections>
  </div>
</body>
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
  var AppAccessSkin = AppAccess + "skins/themes/";
  var AppTemplates = AppAccessSkin + "templates/";
  var AppTemplatesSidebar = AppTemplates + "sidebar/";
  var AppTemplatesContent = AppTemplates + "content/";
</script>
<script type="text/javascript" src="<?php echo skin_url("themes/jquery.fireworks/jquery.fireworks.js")?>"></script>
<script type="text/javascript" src="/skins/plugin-sc/js/jquery.countdown/jquery.countdown.min.js"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/bxslider/dist/jquery.bxslider.min.js");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/datetimepicker/build/jquery.datetimepicker.full.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/bootstrap-slider/bootstrap-slider.js");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/jquery-ui/jquery-ui.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/angular/angular.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/filemanager/filemanager.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/colorpicker/js/evol-colorpicker.min.js")?>"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_rQqp15I-s5F0f9gmPp2G3bFeFaeHE1k&libraries=places"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/angular/ng-map.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/jquery.snow/jquery.snow.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/skins/js/iframe-app.js")?>"></script>
</html>
