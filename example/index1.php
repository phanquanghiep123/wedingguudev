<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Weddinguu - [[THEME_NAME]]</title>
    [[META]]
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="icon" href="[[BASE_URL]]/uploads/ckfinder/userfiles/files/42568951_281327895924389_6879779207161839616_n.png" type="image/*">
    <link rel="stylesheet" href="[[SKIN_URL]]themes/skins/css/bootstrap.min.css">
    <!-- Optional theme -->
    <!-- Latest compiled and minified JavaScript -->
        <script src="[[SKIN_URL]]themes/skins/js/jquery.min.js"></script>
		<script src="[[SKIN_URL]]themes/skins/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="[[SKIN_URL]]themes/skins/js/config.js"></script>
		<link rel="stylesheet" href="[[SKIN_URL]]themes/skins/css/font-awesome.css" rel="stylesheet" />
		<link rel="stylesheet" href="[[SKIN_URL]]themes/skins/css/responsive.css" rel="stylesheet" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="is_page" id="page_theme" style="display:none">
  	<!--không chỉnh sửa đoạn này-->
		<div ng-app="ThemeApp" ng-controller="PageController">
		    <div class="view-page">
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
		    <link ng-if="theme.style_url" rel="stylesheet" type="text/css" href="[[BASE_STYLE]]">
		</div>
	<!--không chỉnh sửa đoạn này-->
	</div>
	<input type="hidden" name="" id="onload-success" value="0">
	<!--config theme-->
	<!--load font-->
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/fancybox/dist/jquery.fancybox.css">
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/skins/css/frontend.css">
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/skins/css/themes.css">
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/skins/css/common.css">
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/colorpicker/css/evol-colorpicker.css"/>
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/bootstrap-slider/css/bootstrap-slider.css">
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/datetimepicker/build/jquery.datetimepicker.min.css">
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/bxslider/dist/jquery.bxslider.min.css"/>
	<link rel="stylesheet" type="text/css" href="[[SKIN_URL]]themes/Waterfall/style.css"/>
	<script type="text/javascript" src="[[BASE_MAIN]]"></script>
	<script type="text/javascript">
		var AppAccess           = "[[BASE_URL]]";
		var AppAccessCotroller  = AppAccess;
		var AppAccessSkin       = AppAccess     + "public/themes/";
		var AppTemplates        = AppAccessSkin + "templates/";
		var AppTemplatesSidebar = AppTemplates  + "sidebar/";
		var AppTemplatesContent = AppTemplates  + "content/";
		var ThemeID    = "[[THEME_ID]]";
		var IsCreate   = 2;
		var Ramkey     = "[[UNQEID]]";
		var sound_URL  = "[[SOUND_URL]]";
		var User_id    = "[[MEMBER_ID]]";
		var Privew = false;
	</script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_rQqp15I-s5F0f9gmPp2G3bFeFaeHE1k&libraries=places"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/fancybox/dist/jquery.fancybox.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/jquery.countdown/jquery.countdown.min.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/bxslider/dist/jquery.bxslider.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/bootstrap-slider/bootstrap-slider.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/angular/angular.min.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/angular/ng-map.min.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/filemanager/filemanager.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/colorpicker/js/evol-colorpicker.min.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/tinymce/jquery.tinymce.min.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/jquery.snow/jquery.snow.min.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/jquery.fireworks/jquery.fireworks.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/Waterfall/newWaterfall.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/skins/js/hower.js"></script>
	<script type="text/javascript" src="[[SKIN_URL]]themes/skins/js/main-view.js"></script>
  </body>
</html>