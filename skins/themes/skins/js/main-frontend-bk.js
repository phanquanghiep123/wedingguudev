var geolocation = {
	lat: 21.028511,
	lng: 105.804817
};
var window_W = $("html").width();
var window_H = $("html").height();
if (navigator.geolocation) {
	navigator.geolocation.getCurrentPosition(function(position) {
		geolocation = {
			lat: position.coords.latitude,
			lng: position.coords.longitude
		};
	});
}
function loadding ($element){
	$element.append('<div class="loadding_ajax"><div class="load_ajax"></div></div>')
}
function removeloadding($element){
	$element.find(".loadding_ajax").remove();
}
var App = angular.module('ThemeApp', []);
App.config(['$qProvider', function($qProvider) {
	$qProvider.errorOnUnhandledRejections(false);
}]);
App.config(['$httpProvider', function($httpProvider) {
	$httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
	$httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
	$httpProvider.interceptors.push(['$q', function($q) {
		return {
			request: function(config) {
				if (config.data && typeof config.data === 'object') {
					config.data = $.param(config.data);
				}
				return config || $q.when(config);
			}
		};
	}]);
}]);
App.controller("PageController", function($scope, $http) {
	$("#content").hide();
	var callserver = 0;
	$scope.review   = 0;
	$scope.snow     = null;
	$scope.upload   = $("#box-upload #upload");
	$scope.uploads  = $("#box-upload #uploads");
	$scope.theme = {};
	$scope.oldFunction = null;
	$scope.theme.id = ThemeID;
	$scope.theme.ramkey = Ramkey;
	$scope.theme.effect = 0;
	$scope.theme.effect_file = {
		minsize : 10,
		maxsize : 40,
		onnew   : '800'
	};
	$scope.change_section        = 0;
	$scope.theme.effect_media_id = 0;
	$scope.theme.effect_play  = 0;
	$scope.theme.sound_play   = 0;
	$scope.mode_class = "adjustment view-page";
	$scope.content_actions = "";
	$scope.sections = null;
	$scope.blocks = null;
	$scope.parts = null;
	$scope.metas = null;
	$scope.Pmetas = [];
	$scope.SVblocks = [];
	$scope.SVsections = [];
	$scope.SVparts = [];
	$scope.section = null;
	$scope.block = null;
	$scope.part = null;
	$scope.meta = null;
	$scope.mode = 0;
	$scope.tabbackground = 0;
	$scope.action_name = "";
	$scope.action_body = "";
	$scope.action_bottom = "";
	$scope.group_backgrounds = [];
	$scope.group_sounds = [];
	$scope.sounds = [];
	$scope.tabsound = 0;
	$scope.backgrounds = [];
	$scope.fonts = [];
	$scope.taggetTab = 0;
	$scope.item = {};
	var min = 1990;
	var max = (new Date()).getFullYear();
	$scope.years = [];
	for (var i = min; i <= max; i++) {
		$scope.years.push(i);
	}
	var tag_audio = new Audio();
	var currentAction = false;
	$scope.support_key = "theme";
	var zindex = 9999;
	var current_key = 0;
	$scope.background_repeat = ["repeat", "repeat-x", "repeat-y", "no-repeat", "initial", "inherit"];
	$scope.background_size = ["auto", "cover", "contain", "initial", "inherit"];
	$scope.backgroundType = [ {
		name: "Sử dụng ảnh mẫu",
		"id": "1"
	}];
	$scope.background_position = ["left top", "left center", "left bottom", "right top", "right center", "right bottom", "center top", "center center",
		"center bottom"
	];
	$scope.background_attachment = ["scroll", "fixed", "local", "initial", "inherit"];
	$scope.is_changeSectionStyle = false;
	$scope.$watch('theme.font', function() {
		if ($scope.theme.font != null && typeof $scope.theme.font.name != "undefined") {
			$scope.theme.style["font-family"] = $scope.theme.font.name;
			$scope.theme.font_file = $scope.theme.font.id;
		}	
	}, true);
	$scope.ReloadTag = function(){
		if($scope.change_section == 1){
			if($scope.section != null){
				var element = $("sections section:eq("+$scope.section.$index+") defaultblock");
				if($scope.section.layout_show_block == "grid"){
					var index = 1;
					element.find(".break-clolums").remove();
					$.each(element.find("block"),function(key,value){
						if(index % $scope.section.ncolum_block == 0  && index > 1){
							$(this).after('<div class="row break-clolums"><div/>');
						}
						index++;
					});
				}else if ($scope.section.layout_show_block == "slider"){
					var _this = this;
					try {
						element.find(".default-blocks").destroySlider();
					}catch(e){
						                		
					}
					setTimeout(function(){
						var pager;
						var controls ;
						var item = element.attr("data-item");
						var w    = element.width();
						var lenght_item  = element.find("block").length;
						item = parseInt(item);
						if(lenght_item > item)  item;
						else item = lenght_item;
						if(window_W < 1025) {
							pager = true ; 
							controls = false;
							item = 3;
						}
						else {
							pager = false;
							controls = true;
						}
						if(window_W < 769) {
							item = 2;
						}
						if(window_W < 421) {
							item = 1;
							pager = false;
							controls = true;
						}
						element.find(".default-blocks").bxSlider({
							minSlides  : item,
							maxSlides  : item,
							slideWidth : w/item,
							pager      : pager,
							controls   : controls,
							auto       : false,
							infiniteLoop: false,
							autoStart: false,
							slideMargin : 15
						});
						setTimeout(function(){
							$(window).trigger('resize');
						},200);
					},1000);
				}
			}
		}else{
			$scope.change_section = 1;
		}
		
	}
	
	$scope.$watch('section.blocks', function(newVal, oldVal) {
		if($scope.section != null){
			if($scope.change_section == 1){
				$scope.section.blocks_on = [];
				$scope.section.blocks_off = [];
				for (var i = 0; i < $scope.section.blocks.length; i++) {
					$scope.section.blocks[i].$index = i;
					if($scope.section.blocks[i].id == $scope.section.default_block){
						$scope.section.blocks_off.push($scope.section.blocks[i]);
					}else{
						$scope.section.blocks_on.push($scope.section.blocks[i]);
					}
				}
			} 
		}
	});
	$scope.$watch('section.ncolum_block', function(newVal, oldVal) {
		$scope.change_section = 1;
		$scope.ReloadTag();
		$scope.change_section = 0;
	});
	$scope.$watch('section.blocks_off', function(newVal, oldVal) {
		$scope.change_section = 1;
		$scope.ReloadTag();
		$scope.change_section = 0;
	});
	$scope.$watch('section.ncolum_show_block', function(newVal, oldVal) {
		$scope.ReloadTag();
	});
	$scope.$watch('theme.sound', function() {
		if ($scope.theme.sound == null) tag_audio.pause();
		if ($scope.theme.sound != null) $scope.theme.sound_file = $scope.theme.sound.id;
		else $scope.theme.sound_file = 0;
	}, true);
	
	//sidebar.
	$scope.actionschange = [
		{
			id: 0,
			value: "adjustment view-page",
			name: "Tuy chỉnh",
			active: 1
		},
		{
			id: 1,
			value: "view-page",
			name: "Xem trang",
			active: 0
		}
	]
	$scope.menus = [
		{
			name: "Nền trang",
			id: "page-background",
			controller: "SidebarBackground",
			icon : "fa fa-picture-o"
		},
		{
			name: "Phông chữ",
			id: "page-font",
			controller: "SidebarFont",
			icon : "fa fa-fonticons"
		},
		{
			name: "Nhạc nền",
			id: "page-sound",
			controller: "SidebarSound",
			icon : "fa fa-music"
		},
		{
			name: "Hiệu ứng",
			id: "page-effect",
			controller: "SidebarEffect",
			icon : 'fa fa-snowflake-o'
		},
		{
			name: "Sắp xếp",
			id: "sort-section",
			controller: "SortSection",
			icon : "fa fa-refresh"
		},
		{
			name: "Thông tin giao diện",
			id: "page-info",
			controller: "SidebarParts",
			icon : "fa fa-info-circle"
		}

	];
	$scope.font_size = "";
	for (var i = 10 ; i< 100 ; i++){
		$scope.font_size += i+"px ";
	}
	//get pramater_server 
	$scope.loaddPage = function(){
		$("body").append('<div class="loadding_ajax"><div class="load_ajax"></div></div>');
	}	
	$scope.CreateBlockGroup = function($index){
		this.section.$index = $index;
		this.section.blocks_on = [];
		this.section.blocks_off = [];
		this.section.more = parseInt(this.section.ncolum_show_block);
		for (var i = 0; i < this.section.blocks.length; i++) {
			this.section.blocks[i].$index = i;
			if(this.section.blocks[i].id == this.section.default_block){
				this.section.blocks_off.push(this.section.blocks[i]);
			}else{
				this.section.blocks_on.push(this.section.blocks[i]);
			}
		}
		return true;
		 
	}
	$scope.Changeffect = function(){
		if($scope.theme.effect != 1) $scope.theme.effect = 1;
		else $scope.theme.effect = 0;
	}
	$scope.changeShowHiddenSection = function(){ 
		if($scope.section.show_title != 1) $scope.section.show_title = 1;
		else $scope.section.show_title = 0;
	}
	$scope.changeWidthSection = function(){ 
		if($scope.section.is_full != 1) $scope.section.is_full = 1;
		else $scope.section.is_full = 0;
	}
	$scope.ChangeRunSound = function(){
		if($scope.theme.sound_play != 1) $scope.theme.sound_play = 1;
		else $scope.theme.sound_play = 0;
	}
	$scope.ChangeActive = function(){
		if($scope.theme.is_active != 1) $scope.theme.is_active = 1;
		else $scope.theme.is_active = 0;
	}
	$scope.removeloaddPage = function(){
		$("body > .loadding_ajax").remove();
	}
	$scope.ToggleSidaber = function($event){
		$("#sidebar").toggleClass("open");
		if($scope.support_key == "section") $scope.save_section();
		return false;
	}
	$scope.initPage = function(){
		$scope.loaddPage(); 
		if(callserver == 0){
			//get section
			$http({
				method: "POST",
				responseType: "json",
				data: {
					id : $scope.theme.id,
					is_create : IsCreate
				},
				url: AppAccessCotroller + "appthemes/get_section/" + $scope.theme.id
			}).then(function(response) {
				if(response.data.status == "success"){
					$scope.sections   = response.data.sections;
					$scope.SVsections = response.data.sectionsv;
					$scope.theme      = Object.assign($scope.theme, response.data.theme);
					if($scope.theme.effect_file == null){
						$scope.theme.effect_file = {};
					}
					if (history.pushState) {
					  window.history.pushState("object or string", "Cập nhật", "/appthemes/edit/" + $scope.theme.slug);
					}
				}else{
					if(response.data.redirect != "undefined"){
						window.location.href = response.data.redirect;
					}
				}
				$("#content").show();
				$scope.removeloaddPage();

			}, function(error) {
				location.reload();
			});
			//!get section;
			//get sounds  backgrounds effect
			$http({
				method         : "POST",
				responseType   : "json",
				url: AppAccessCotroller + "appthemes/get_groups_backgrounds_sounds"
			}).then(function(response) {
				$scope.group_backgrounds = response.data.backgrounds;
				$scope.group_sounds = response.data.sounds;
			}, function(error) {
				location.reload();
			});
			//!get sounds 
			//get font 
			$http({
				method       : "POST",
				responseType : "json",
				url: AppAccessCotroller + "appthemes/get_fonts"
			}).then(function(response) {
				$scope.fonts = response.data;
			}, function(error) {
				location.reload();							
			});	
			//!get font 
		}
		$.datetimepicker.setLocale('vi');
		
	}
	$scope.initPage();	
	$scope.CallActions = function(){
		if(this.action.key_id == "add"){
			$scope.BlockAdd(this.$parent.block,this.$parent.$parent.section);
		}else if(this.action.key_id == "edit"){
			$scope.BlockEdit(this.$parent.block,this.$parent.$parent.section)
		}else if(this.action.key_id == "delete"){
			$scope.BlockDelete(this.$parent.$parent.$index,this.$parent.$parent.section.blocks)
		}
	}
	$scope.DeleteMeta = function(index){
		this.$parent.$parent.part.metas.splice(index,1);
	}
	$scope.InitBlockAction = function ($type){
		$.each (this.block.actions,function(){
			if(this.key_id == $type && (this.active == 1 || this.active == "1")){
				return true;
			}
		});
		return false;
	}
	callserver = 1;
	$scope.checkaction = function() {
		if ($scope.actionChangeCurrent = this.action.value) {
			this.action.check = true;
		}
	}
	$scope.hoverInBlock = function(){
		this.block.active = 1;
	}
	$scope.hoverOutBlock = function(){
		this.block.active = 0;
	}
	$scope.getContentmenu = function(item  = null) {
		var _this = item != null ? item : this.menu;
		$scope.support_key = "theme";
		$scope.action_name = _this.name;
		if(_this.id == "sort-section"){
			$scope.taggetTab = 1;
			return false;
		}
		if(typeof _this.template != "undefined"){
			$scope.action_body = _this.template ;
			_this.load = 0;
			$("#sidebar-actions").css("z-index", zindex);
			zindex++;
			$("#sidebar-actions").addClass("open");
			$scope.oldFunction = function (){
				$scope.getContentmenu(_this);
			};
			return false;
		}
		_this.load = 1;
		$http({
			method: "POST",
			responseType : "text",
			data: {
				template: _this.id,
				theme_id: $scope.theme.id
			},
			url: AppAccessCotroller + "appthemes/get_template_by_sidebar"
		}).then(function(response) {
			$(".content-actions").removeClass("open");
			 _this.template = $scope.action_body = response.data;
			_this.load = 0;
			$("#sidebar-actions").css("z-index", zindex);
			zindex++;
			$("#sidebar-actions").addClass("open");
			$scope.oldFunction = function (){
				$scope.getContentmenu(_this);
			};
		}, function(error) {	
			_this.load = 0;
			window.location.href = "/appthemes/edit/"+$scope.theme.slug;
		});
		return false;
	}
	$scope.getBackgrounds = function(group) {
		$(".content-actions").removeClass("open");
		$scope.chosse_name = group.name;
		$scope.backgrounds = group.backgrounds;
		group.load = 1;
		$scope.chosse_body = "<ul class=\"nav-list-items list_image\"><li ng-init=\"initBackground(background)\" ng-class=\"(background.active == 1) ? 'active' :''\" ng-repeat=\"background in backgrounds\" ng-click=\"ChosseBackground(background)\" class=\"item\" id=\"{{background.id}}\"><img src=\"#\" ng-src=\"{{background.thumb}}\"/></li></ul>";
		$("#sidebar-chosse").css("z-index", zindex);
		zindex++;
		$("#sidebar-chosse").addClass("open");
		group.load = 0;
		return false;
	}
	$scope.getSounds = function(group) {
		$scope.single_name = group.name;
		$scope.sounds = group.sounds;
		group.load = 1;
		$scope.single_body = "<ul class=\"nav-list-items list_category sounds\"><li ng-class=\"(sound.active == 1) ? 'active' :''\" ng-repeat=\"sound in sounds\" ng-click=\"ChosseSounds(sound)\" class=\"item\" id=\"{{sound.id}}\"><a src=\"#\" ng-src=\"{{sound.path}}\"/>{{sound.name}} <span ng-class=\"(sound.start == 1) ?'start':'stop'\" ng-click=\"StartStop(sound,$event)\" id=\"start_stop\"></span></a></li></ul>";
		$(".content-actions").removeClass("open");
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		group.load = 0;
		return false;
	}
	$scope.AddNewBlock = function(){
		$scope.loaddPage(); 
		$http({
			method: "POST",
			responseType : "json",
			data: {
				theme_id         : $scope.theme.id,
				theme_section_id : $scope.section.theme_section_id,
				parent_id        : $scope.theme.clone_id,
				section_id       : $scope.section.id,
				sort             : $scope.section.blocks.length,
				block_id         : $scope.section.default_block
			},
			url: AppAccessCotroller + "appthemes/addnewblock"
		}).then(function(response) {
			$scope.block  = response.data;
			$scope.section.blocks.push($scope.block);
			if($scope.block.id == $scope.section.default_block){
				$scope.section.blocks_off.push($scope.block);
			}else{
				$scope.section.blocks_on.push($scope.block);
			}
			$scope.BlockEdit($scope.block,$scope.section);
			try{
				$scope.section.reload();
			}catch(e){
			}
			$scope.removeloaddPage(); 
			$scope.change_section = 1;
		}, function(error) {
			$scope.removeloaddPage();
			window.location.href = "/appthemes/edit/"+$scope.theme.slug;
		});
	}
	$scope.AddItem = function($type = null) {
		if($type != null) $scope.support_key = $type;
		if ($scope.support_key == "theme") {
			$scope.single_name = "Thêm section";
			$scope.single_body =
				"<ul class=\"nav-list-items list_category add-items svsections\"><li ng-class=\" (svsection.load == 1) ?'loadding' : ''\" ng-repeat=\"svsection in SVsections\" ng-click=\"SectionAddNow(svsection)\" class=\"item\" id=\"{{svsection.id}}\">{{svsection.name}}</li></ul>";
		} else if ($scope.support_key == "section") {
			$scope.single_name = "Thêm block";
			$scope.single_body =
				"<ul class=\"nav-list-items list_category add-items svblocks\"><li ng-class=\" (svblock.load == 1) ?'loadding' : ''\" ng-repeat=\"svblock in SVblocks\" ng-click=\"BlockAddNow(svblock)\" class=\"item\" id=\"{{svblock.id}}\">{{svblock.name}}</li></ul>";
		} else if ($scope.support_key == "block") {
			$scope.single_name = "Thêm block";
			$scope.single_body =
				"<ul class=\"nav-list-items list_category add-items svparts\"><li ng-class=\" (svpart.load == 1) ?'loadding' : ''\" ng-repeat=\"svpart in SVparts\" ng-click=\"PartAddNow(svpart)\" class=\"item\" id=\"{{svpart.id}}\">{{svpart.name}}</li></ul>";
		}
		$(".content-actions").removeClass("open");
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		$scope.support_key == "theme";
	}
	$scope.IsList = function(part){
		if(part.name.trim() == "list images") return true;
		return false;
	}
	$scope.SectionAddNow = function(svsection) {
		svsection.load = 1;
		$http({
			method: "POST",
			responseType : "json",
			data: {
				svsection   : svsection,
				ramkey      : $scope.theme.ramkey,
				sort        : $scope.sections.length,
				theme_id    : $scope.theme.id,
				parent_id   : $scope.theme.clone_id,
			},
			url: AppAccessCotroller + "appthemes/addsection"
		}).then(function(response) {
			$scope.section = (response.data);
			$scope.sections.push(response.data);
			svsection.load = 0;
			setTimeout(function(){
				if ($scope.section != null && $scope.support_key == "section") {
					$('section.active').removeClass("active");
					$('section[ramkey=' + $scope.section.ramkey + ']').addClass("active");
					try {
						$('html').animate({
							scrollTop: $('section[ramkey=' + $scope.section.ramkey + ']').offset().top - 22
						}, 400);	
					} catch (r) {}
				}
			},300);
		}, function(error) {
			svsection.load = 0;
			//window.location.href = "/appthemes/edit/"+$scope.theme.slug;
		});
	}
	$scope.BlockAddNow = function(svblock) {
		svblock.load = 1;
		$scope.support_key == "block";
		$http({
			method: "POST",
			responseType : "json",
			data: {
				svblock 	     : svblock,
				section_id       : $scope.section.id,
				sort             : $scope.section.blocks.length,
				theme_section_id : $scope.section.theme_section_id
			},
			url: AppAccessCotroller + "appthemes/addblock"
		}).then(function(response) {	
			$scope.block = (response.data);
			$scope.blocks.push(response.data);
			svblock.load = 0;
			try{
				$scope.section.reload();
			}catch(e){
			}
			$scope.BlockEdit($scope.block, $scope.section);
			setTimeout(function(){
				try {
					$('html').animate({
						scrollTop: $('block[ramkey=' + $scope.block.ramkey + ']').offset().top 
					}, 400);
					$scope.block.active = 1	
				} catch (r) {}
				//$scope.support_key == "section";
			},300);
			$scope.ToBlock();
		}, function(error) {
			svblock.load = 0;
			window.location.href = "/appthemes/edit/"+$scope.theme.slug;
		});
	}
	$scope.ChangeSackgroundSection = function() {
		$(".content-actions").removeClass("open");
		$("#sidebar-chang-style-section").css("z-index", zindex);
		zindex++;
		$("#sidebar-chang-style-section").addClass("open");
		$scope.is_changeSectionStyle = true;
	}
	$scope.RemoveSound = function() {
		$.each($scope.sounds, function() {
			this.active = 0;
		});
		$scope.theme.sound = false;
	}
	$scope.Review = function(){
		$scope.review = 1;
		$scope.loaddPage();
		$scope.Public($("save-box-right"),1);
	}
	$scope.StartStop = function(sound, $event) {
		$event.stopPropagation();
		$.each($scope.sounds, function() {
			if (sound.id != this.id) {
				this.start = 0;
			}
		});
		if (sound.start == 1) {
			tag_audio.pause();
			sound.start = 0;
		} else {
			tag_audio.src = sound.path;
			tag_audio.play();
			sound.start = 1;
		}
		return false;
	}
	$scope.ChosseSounds = function(sound) {
		$.each($scope.sounds, function() {
			if (sound.id != this.id) {
				this.active = 0;
			}
		});
		sound.active = !sound.active;
		if (sound.active == 1) {
			$scope.theme.sound      = sound;
			$scope.theme.sound_file = sound.media_id;
		} else {
			$scope.theme.sound = null;
			$scope.theme.sound_file = 0;
		}
		return false;
	}
	$scope.getActionType = function(type) {
		$scope.single_name = type.name;
		type.load = 1;
		if (type.id == 0) {
			$scope.single_body = "<ul class=\"nav-list-items list_category\"><li openfilemanager href=\"javascript:;\" class=\"ui-button-text\" data-action=\"background-image\" data-type=\"image\" data-max=\"1\" id=\"openFilemanager\"> Mở thư viện file</li><li uploads data-max=\"1\" data-type=\"image\" data-action=\"background-image\">Tải ảnh lên</li> </ul>";
		} else {
			$scope.single_body ="<ul class=\"nav-list-items list_category\"><li ng-class=\"(group.load == 1) ? loadding:''\" ng-repeat=\"group in group_backgrounds\" ng-click=\"getBackgrounds(group)\" class=\"item\" id=\"{{group.id}}\">{{group.name}}</li></ul>";
		}
		$(".content-actions").removeClass("open");
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		type.load = 0;
		return false;
	}
	$scope.ChangeEffectFile = function(){
		$scope.support_key = "theme";
		$scope.single_name = "Chọn ảnh hiệu ứng";
		$scope.single_body = "<ul class=\"nav-list-items list_category\"><li openfilemanager href=\"javascript:;\" class=\"ui-button-text\" data-action=\"effect\" data-type=\"image\" data-max=\"1\" id=\"openFilemanager\"> Mở thư viện file</li><li uploads data-max=\"1\" data-type=\"image\" data-action=\"effect\">Tải ảnh lên</li> </ul>";
		$(".content-actions").removeClass("open");
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		return false;
	}
	$scope.ChosseBackground = function(background) {
		if ($scope.support_key == "theme") {
			$scope.theme.style["background-image"] = "url('" + background.thumb + "')";
		} else if ($scope.support_key == "section") {
			$scope.section.style["background-image"] = "url('" + background.thumb + "')";
		}
		$.each($scope.backgrounds, function() {
			this.active = 0;
		});
		background.active = 1;
		return false;
	}
	$scope.RemoveBg = function($v) {
		if ($v == 0) {
			if ($scope.support_key == "theme") {
				$scope.theme.style["background-image"] = "inherit";
			} else if ($scope.support_key == "section") {
				$scope.section.style["background-image"] = "inherit";
			}
		} else if ($v == 1) {
			if ($scope.support_key == "theme") {
				$scope.theme.style["background-color"] = "inherit";
			} else if ($scope.support_key == "section") {
				$scope.section.style["background-color"] = "inherit";
			}
		}
	}
	$scope.changmode = function(action) {
		$.each($scope.actionschange, function() {
			this.active = 0;
		});
		$scope.mode = action.id;
		$.each($scope.sections,function(){
			try{
				this.reload();
			}catch(e){}
		});
		action.active = 1;
		$scope.mode_class = action.value;
		return false;
	}
	$scope.Ftabbackgroundimage = function($v) {
		$scope.tabbackgroundimage = $v;
		return false;
	}
	$scope.CloseActions = function() {
		$("#sidebar-actions").removeClass("open");
		return false;
	}
	$scope.CloseSingle = function() {
		$("#sidebar-single").removeClass("open");
		try {
			$scope.oldFunction();
		}catch(e){}
		return false
	}
	$scope.CloseChosse = function() {
		$("#sidebar-chosse").removeClass("open");
		return false;
	}
	$scope.ToSection = function() {
		$scope.change_section = 0;
		$(".content-actions").removeClass("open");
		$("#sidebar-section").css("z-index", zindex);
		zindex++;
		$("#sidebar-section").addClass("open");
		$scope.support_key = "section";
		$scope.section     = this.section;
		$scope.blocks      = this.section.blocks;
		if ($scope.section != null && $scope.support_key == "section") {
			$('section.active').removeClass("active");
			$('section[ramkey=' + $scope.section.ramkey + ']').addClass("active");
			try {
				$('html').animate({
					scrollTop: $('section[ramkey=' + $scope.section.ramkey + ']').offset().top - 22
				}, 400);	
			} catch (r) {}
		}
		return false;
	}
	$scope.MoveBlockDefault = function(section) {
		$scope.support_key = "section";
		$scope.section     = this.section;
		$scope.blocks      = this.section.blocks;
		$(".content-actions").removeClass("open");
		$("#sidebar-order-block").css("z-index", zindex);
		zindex++;
		$("#sidebar-order-block").addClass("open");
		return false;
	}
	$scope.CloseOrderBlock =function(){
		$scope.support_key = "theme";
		$("#sidebar-order-block").removeClass("open");
		return false;
	}
	$scope.ToBlock = function(block) {
		$scope.support_key = "block";
		this.block.active = 1;
		$scope.block = this.block;
		setTimeout(function(){
			try {
			$('html').animate({
				scrollTop: $('block[ramkey=' + $scope.block.ramkey + ']').offset().top - 22
			}, 400);	
		} catch (r) {}
		},300)
		
		$scope.BlockEdit(this.block, this.$parent.section);
		return false;
	}

	//content.
	$scope.MetaShow = function() {
		//meta show
		var part = this.part;
		var html_show = part.html_show;
		var list_show = part.list_show;
		html_show     = html_show.replace("{{value}}",list_show);
		var stringR = '';
		if(part.metas.length > 0){
			if (part.metas[0].media_id != 0 && part.metas[0].meta_key =="value_media") {
				stringR = html_show.replace("{{value}}",'{{part.metas[0].thumb}}').replace("{{media_id}}", "{{part.metas[0].media_id}}");
			} else {
				if(this.part.name == "content"){
					var text = part.metas[0].value;
					jtext = $(text);
					var stringText = "";
					var content = $("<div></div>");
					$.each(jtext.find("span"),function(key,val){
						key ++;
						var stringspan = $(this).text();
						stringText += stringspan;
						if(stringText.length >= 280){
							stringspan = stringspan.substring(0, 280);
							$(this).html(stringspan);
							content.append($(this).parent());
							return false;
						}else{
							content.append($(this).parent());
						}

					});
					jtext.html(content.html());
					stringR = jtext.wrap("<div></div>").parent().html();
					stringR = html_show.replace("{{value}}",stringR);
				}else{
					stringR = html_show.replace("{{value}}",part.metas[0].value);
				}
				
			}
		}

		return stringR;
	}
	$scope.Show_Title = function(val) {
		if (val == 1 || $scope.mode == 0) return true;
		else return false;
	}
	$scope.blockShow = function(section,block){
		if(block.id == section.default_block){
			return false;
		} 
		else return true;
	}
	$scope.SectionEdit = function(section) {
		$scope.change_section = 0;
		$(".content-actions").removeClass("open");
		$scope.save_section();
		$scope.support_key = "section";
		$scope.section = section;
		$scope.blocks = section.blocks;
		$scope.taggetTab = 0;
		$("#sidebar-section").css("z-index", zindex);
		zindex++;
		$("#sidebar-section").addClass("open");
		setTimeout(function(){
			$("#sidebar").addClass("open");
		},500);
		$scope.oldFunction = function(){
			$scope.SectionEdit(section);
		}
		return false;
	}
	$scope.SectionDelete = function($index) {
		current_key  = $index;
		$scope.section = this.section;
		$scope.support_key = 'section';
		$("#modal-delete-item").modal();
		return false;
	}
	$scope.Deletetheme = function($index) {
		$scope.support_key = 'theme';
		$("#modal-delete-item").modal();
		return false;
	}
	$scope.SectionAdd = function(section) {
		$scope.support_key = "section";
		$scope.section = section;
		$scope.blocks = section.blocks;
		$scope.AddNewBlock();
		return false;
	}
	$scope.BlockEdit = function(block, section) {
		$scope.support_key = "block";
		$scope.block = block;
		$scope.parts = block.parts;
		$scope.section = section;
		$("#modal-edit-block").modal();
		return false;
	}
	$scope.BlockDelete = function($index, blocks) {
		$scope.blocks  = blocks;
		$scope.block   = this.block;
		$scope.section = this.$parent.$parent.$parent.$parent.section;
		current_key  = $index;
		$scope.support_key = 'block';
		$("#modal-delete-item").modal();
		return false;
	}
	$scope.BlockAdd = function(block, section) {
		$scope.support_key = "block";
		$scope.block = block;
		$scope.parts = block.parts;
		$scope.section = section;
		$scope.AddItem();
		return false;
	}
	$scope.FormEdit = function(meta) {
		var html_edit = this.$parent.part.html_edit;
		var form_edit = html_edit.replace("{{value}}", "");
		if (meta["meta_key"] == "value_text") {
			var s = $('<div>' + form_edit + '</div>');
			s.find('[name="value_text"]').attr("ng-model", "meta.value");
			s.find('[name="value_text"]').attr("id",meta.ramkey);
		} else {
			return form_edit;
		}
		return s.html();
	}
	$scope.FormEditNull = function() {
		var html_edit = this.$parent.part.html_edit;
		return html_edit;
	}
	$scope.ValueForm = function(meta) {
		var list_show = this.$parent.part.list_show;
		var html_show = this.$parent.part.html_show;
		list_show     = html_show.replace("{{value}}",list_show)
		$scope.part   = this.$parent.part
		$scope.metas   = $scope.part.metas;
		var form_edit = "";
		if (meta["meta_key"] != "value_text") {
			if (meta["meta_key"] == "value_media") {
				form_edit = list_show.replace("{{value}}", "{{meta.thumb}}").replace("{{media_id}}", "{{meta.media_id}}");
				form_edit =  $("<div>"+form_edit+"</div>");
				form_edit.find(".delete-item").attr("ng-click","DeleteMeta($index)");
				form_edit = form_edit.html();
			} else if (meta["meta_key"] == "map_point") {
				form_edit = list_show.replace("{{value}}", "");
				form_edit = $('<div>' + form_edit + '</div>');
				form_edit.find('[name^="map_point"]').attr("ng-model", "meta.value");
				form_edit = form_edit.html();
			}
		}
		return form_edit;
	}
	$scope.PartEdit = function(part) {
		$scope.part  = part;
		$scope.metas = $scope.part.metas;
		$scope.support_key = "part";
		$("#modal-edit-part").modal();
		return false;
	}
	$scope.DeleteItem = function (){
		$scope.change_section = 1;
		var data = null;
		var $e = $("#modal-delete-item .btn-warning");
		loadding($e);
		if($scope.support_key == "section"){
			data  = {
				theme_section_id : $scope.section.theme_section_id
			};
			$scope.sections.splice(current_key, 1);
		}else if($scope.support_key == "block"){
			data  = {
				theme_section_id : $scope.block.theme_section_id,
				section_block_id : $scope.block.section_block_id
			};
			$scope.blocks.splice(current_key, 1);
			console.log(current_key);
			try{
				$scope.section.reload();
			}catch(e){
			}
		}else if($scope.support_key == "part"){
			data  = {
				block_part_id    : $scope.part.block_part_id,
				theme_section_id : $scope.part.theme_section_id,
				section_block_id : $scope.part.section_block_id
			};
			$scope.parts.splice(current_key, 1);
		}else if($scope.support_key == "theme"){
			$http({
				method : "POST",
				responseType : "json",
				data : {id : $scope.theme.id},
				url  : AppAccessCotroller + "appthemes/deletetheme/",
			}).then(function(response) {
				removeloadding($e);
				$("#modal-delete-item").modal("hide");
				if(response.data.status == "success"){
					window.location.href = response.redirect;
				}else{
					window.location.href = "/appthemes/edit/"+$scope.theme.slug;
				}
			}, function(error) {
				removeloadding($e);
				window.location.href = "/appthemes/edit/"+$scope.theme.slug;
			});
			return false;
		}
		setTimeout(function(){
			$scope.change_section = 0;
		},200);
		if(data != null){
			$http({
				method : "POST",
				responseType : "json",
				data : {item : data},
				url  : AppAccessCotroller + "appthemes/deleteitem/" + $scope.support_key,
			}).then(function(response) {
				removeloadding($e);
				$("#modal-delete-item").modal("hide");
			}, function(error) {
				removeloadding($e);
				window.location.href = "/appthemes/edit/"+$scope.theme.slug;
			});
		}
	}
	$scope.PartDelete = function($index, parts) {
		current_key  = $index;
		$scope.support_key = 'part';
		$scope.parts = parts;
		$scope.part  = this.part;
		$("#modal-delete-item").modal();
		return false;
	}
	$scope.Public = function ($e = null,openreview = 0){
		if($e == null){
			$e = $(".save-box-left");
		}
		loadding($e);
		try{
			if($scope.support_key == "section")
				$scope.save_section();
		}catch(e){}
		var dataTheme = {
				id 				: $scope.theme.id,
				name 			: $scope.theme.name,
				description 	: $scope.theme.description,
				thumb 			: $scope.theme.thumb,
				font_file  	 	: $scope.theme.font_file,
				sound_file  	: $scope.theme.sound_file,
				size_title  	: $scope.theme.size_title,
				color_title 	: $scope.theme.color_title,
				color_title 	: $scope.theme.color_title,
				effect      	: $scope.theme.effect,
				effect_file 	: $scope.theme.effect_file,
				effect_media_id : $scope.theme.effect_media_id,
				public      	: $scope.theme.public,
				style       	: $scope.theme.style,
				sound_play      : $scope.theme.sound_play,
				is_active       : $scope.theme.is_active
			}
		$http({
			method : "POST",
			responseType : "json",
			data : dataTheme,
			url  : AppAccessCotroller + "appthemes/save_theme/",
		}).then(function(response) {
			setTimeout(function(){
				if(openreview == 1) $("#modal-review").modal();
			},300);
			removeloadding($e);
		}, function(error) {
			removeloadding($e);
			window.location.href = "/appthemes/edit/"+$scope.theme.slug;
		});
	}
	$scope.save_block = function(){
		if($scope.support_key == "block"){
			$scope.support_key == "section";
			//$scope.loaddPage();
			var parts = [];
			var metas = [];
			$.each($scope.block.parts,function(key,val){
				metas = [];
				$.each(this.metas,function(){
					metas.push({
						id               : this.id,
						value            : this.value,
						media_id         : this.media_id,
						section_block_id : this.section_block_id,
						meta_key         : this.meta_key,
						theme_section_id : this.theme_section_id,
						block_part_id    : this.block_part_id,
						ramkey           : this.ramkey
					});
					try{ this.reload(); }catch(e){}
				});
				parts.push({
					block_part_id    : this.block_part_id,
					section_block_id : this.section_block_id,
					theme_section_id : this.theme_section_id,
					metas            : metas,
					sort             : key,
				});
			});
			$http({
				method: "POST",
				responseType: "json",
				data : {parts : parts},
				url  : AppAccessCotroller + "appthemes/save_block/",
			}).then(function(response) {
				$scope.support_key == "section";
			}, function(error) {
				window.location.href = "/appthemes/edit/"+$scope.theme.slug;
			});
		}
	}
	$scope.save_section = function(){
		if($scope.support_key == "section"){
			$scope.loaddPage();
			$http({
				method: "POST",
				responseType: "json",
				data: {
					theme_section_id : $scope.section.theme_section_id,
					actions          : $scope.section.actions,
					class_name       : $scope.section.class_name,
					name 			 : $scope.section.name,
					sort             : $scope.section.sort,
					show_title       : $scope.section.show_title,
					default_block    : $scope.section.default_block,
					ncolum_show_block: $scope.section.ncolum_show_block,
					ncolum_block     : $scope.section.ncolum_block,
					is_full          : $scope.section.is_full,
					style            : $scope.section.style
				},
				url  : AppAccessCotroller + "appthemes/save_section/",
			}).then(function(response) {
				$scope.removeloaddPage();
				$scope.change_section = 1;
				$scope.support_key == "theme";
			}, function(error) {
				window.location.href = "/appthemes/edit/"+$scope.theme.slug;
			});	
		}
	}
	$scope.RemoveEffectFile = function(){
		$scope.theme.effect_file.thumb = null;
	}
	$scope.CloseSection = function() {
		$scope.support_key == "section";
		$scope.save_section();
		$scope.section = null;
		$("#sidebar-section").removeClass("open");
		$scope.support_key = "theme";
		$scope.taggetTab = 0;
		return false;
	}
	$scope.UpdateSort = function ($type = "section",$list = []){
		$http({
			method: "POST",
			responseType: "json",
			data : {list : $list},
			url  : AppAccessCotroller + "appthemes/updatesort/" + $type,
		}).then(function(response) {
		}, function(error) {
			window.location.href = "/appthemes/edit/"+$scope.theme.slug;
		});
	}
	$scope.MoreSection = function(section) {
		section.more += parseInt(section.ncolum_show_block);
		try{ 
			section.reload(); 
		}catch(e){
		
		}
		return true;
	}
	$scope.ActionSection = function(section){
		var section_action = "";
		var  Actionadd = Actiondelete = Actionedit =  ActionMove =  ActionMore = "";
		$.each(section.actions,function(){
			if(this.key_id == "edit"){
				Actionedit ='<li><a ng-click="SectionEdit(section)" href="javascript:;" id="edit-action"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>';
			}else if(this.key_id == "delete"){
				Actiondelete = '<li><a ng-click="SectionDelete($index)" href="javascript:;" id="delete-action"><i class="fa fa-trash" aria-hidden="true"></i></a></li>';
			}
            else if(this.key_id == "add"){
				Actionadd   = '<li><a ng-click="SectionAdd(section)" href="javascript:;" id="add-action"><i class="fa fa-plus-square" aria-hidden="true"></i></a></li>';
				ActionMove  = '<li><a ng-click="MoveBlockDefault(section)" href="javascript:;"><i class="fa fa-arrows" aria-hidden="true"></i></a></li>';	
				ActionMore  = '<li><a ng-if="section.more < section.blocks_off.length" ng-click="MoreSection(section)" href="javascript:;"><i class="fa fa-arrow-down" aria-hidden="true"></i></a></li>';	
			}	
		}); 
		return (Actionedit + Actionadd + Actiondelete + ActionMove + ActionMore);
	};
	$scope.ClosechangeSectionStyle =function(){
		$("#sidebar-chang-style-section").removeClass("open");
		try{
			$scope.oldFunction();
		}catch(e){}
		return false;
	}
	$scope.ActionBlock = function(section){
		var block = this.block;
		var block_action = "";
		if(block.id == section.default_block){
			block_action+='<li><a ng-click ="BlockEdit(block,section)" href="javascript:;" id="edit-block"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>';
			block_action+= '<li><a ng-click ="BlockDelete($index,section.blocks)" href="javascript:;" id="delete-block"><i class="fa fa-trash" aria-hidden="true"></i></a></li>';
			return block_action;
		}
		$.each(block.actions,function(){
			if(this.key_id == "edit"){
				block_action+='<li><a ng-click ="BlockEdit(block,section)" href="javascript:;" id="edit-block"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>';
			}
            else if(this.key_id == "delete"){
				block_action+= '<li><a ng-click ="BlockDelete($index,section.blocks)" href="javascript:;" id="delete-block"><i class="fa fa-trash" aria-hidden="true"></i></a></li>';
			}            
		});
		return block_action;
	}

	$scope.Upload = function(_this){
		var formData = new FormData();  
		$.each(_this.files,function(k,v){
			formData.append('files[]', v, v.name);
		}) ;
		var type_action = $(_this).attr("data-action");
		$scope.loaddPage();      
		$.ajax({
		    url  	 : AppAccessCotroller + "/filemanager/uploadflash/",
		    data 	 : formData,
		    type     : 'POST',
		    dataType : "json",
		    contentType  : false, 
		    processData  : false,  
		    success : function(e){
		    	if(e.status == "success"){
		    		$.each(e.response, function(k, v) {
		    			if($scope.support_key == "block"){
		    				v.media_id 			= v.id;
							v.id 				= $scope.part.metas[0];
							v.block_part_id    	= $scope.part.block_part_id;
							v.meta_key         	= "value_media";
							v.section_block_id 	= $scope.part.section_block_id;
							v.theme_section_id 	= $scope.part.theme_section_id;
							$scope.part.metas[0] = (v);
		    			}else if($scope.support_key == "theme"){
							if (type_action == "background-image") {
								$scope.theme.style['background-image'] = 'url(' + v.path + ')';
							}else if(type_action == "sound"){
								var newsound       = v;
								newsound.active    = 1;
								newsound.start     = 0;
								$scope.theme.sound = newsound;
								$scope.theme.sound_file = newsound.media_id;
							}else if (type_action == "effect") {
								$scope.theme.effect = 1;
								$scope.theme.effect_file.path = v.path;
								$scope.theme.effect_file.thumb = v.thumb;
								$scope.theme.effect_media_id = v.id;
							}
							else if (type_action == "theme_thumb") {
								$scope.theme.thumb_url = v.thumb;
								$scope.theme.thumb = v.id;
							}
		    			}else if($scope.support_key == "section"){
		    				$scope.section.style["background-image"] = 'url(' + v.path + ')';
		    			}
		    			return false;	
					});
					$scope.$apply();
		    	}	    	
		    	$scope.removeloaddPage();
		    },error : function(e){
		    	console.log(e);
		    	$scope.removeloaddPage();
				//window.location.href = "/appthemes/edit/"+$scope.theme.slug;
		    }
		});
	}
	$scope.Uploads = function(_this){
		var formData = new FormData();  
		var length = $scope.part.metas.length;
		var max = parseInt($(_this).attr("data-max"));
		if(max - length < _this.files.length){
			alert("Vui lòng chọn tối đa " + (max - length) + " file");
			return false;
		}
		$.each(_this.files,function(k,v){
			formData.append('files[]', v, v.name);
		}) ;
		$scope.loaddPage();      
		$.ajax({
		    url  	 : AppAccessCotroller + "/filemanager/uploadflash/",
		    data 	 : formData,
		    type     : 'POST',
		    dataType : "json",
		    contentType  : false, 
		    processData  : false,  
		    success : function(e){
		    	if(e.status == "success"){
		    		$.each(e.response, function(k, v) {
		    			if($scope.support_key == "block"){
							v.media_id 			= v.id;
							v.id 				= 0;
							v.block_part_id    	= $scope.part.block_part_id;
							v.meta_key         	= "value_media";
							v.section_block_id 	= $scope.part.section_block_id;
							v.theme_section_id 	= $scope.part.theme_section_id;
							$scope.part.metas.push(v);
						}
					});
					$scope.$apply();
		    	}	    	
		    	$scope.removeloaddPage();
		    },error : function(){
		    	$scope.removeloaddPage();
		    	alert("Có vấn đề xãy ra chúng tôi sẽ reload lại trang!");
				window.location.href = "/appthemes/edit/"+$scope.theme.slug;
		    }
		});
	}
	$('#modal-edit-block').on('hidden.bs.modal', function () {
		$scope.support_key == "block";
		$scope.save_block();
		$scope.block.active = 0;

	});
	$('#modal-review').on('show.bs.modal', function () {
		$scope.removeloaddPage();
	});
	$('#modal-review').on('hidden.bs.modal', function () {
		$scope.review = 0;
		$scope.$apply();
	});
	$('#modal-edit-block').on('shown.bs.modal', function () {
		$scope.support_key == "block";
	});
	$('.modal').on('shown.bs.modal', function () {
		$.each($(this).find("input[sliderbootstrap]"),function(){
			$(this).sliderbootstrap("setValue",$(this).val());
		});
	});
	$scope.$watch("theme.effect_play",function(){
		if($scope.theme.effect_play != 1){
			try {
                $.fn.snow({
                    start: false
                });
            } catch (err) {}
		}
	});
}).filter('trustHtml', function($sce) {
	return function(html) {
		return $sce.trustAsHtml(html);
	}
});
App.directive('compile', ['$compile', function($compile) {
	return function(scope, element, attrs) {
		scope.$watch(
			function(scope) {
				return scope.$eval(attrs.compile);
			},
			function(value) {
				element.html(value);
				$compile(element.contents())(scope);
			}
		);
	};
}]);
App.directive('blocks', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			element.sortable({
				connectWith: "parent",
				handle: "#move-action",
				cursor: "move",
				revert: true,
				stop: function(event, ui) {
					var parent = ui.item.parent();
					var blocks = [];
					var sort = 0;
					var item = ui.item.scope();
					scope.blocks  = item.$parent.section.blocks;
					var sortlist = [];
					$.each(parent.find("block"), function(k, v) {
						var ramkey = $(this).attr("ramkey");
						$.each(scope.blocks, function(k, v) {
							if (ramkey == v.ramkey) {
								v.sort = sort;
								blocks.push(v);
								sortlist.push({
									section_block_id : v.section_block_id ,
									theme_section_id : v.theme_section_id
								});
								sort++;
							}
						});
					});
					scope.section = item.$parent.section;
					scope.blocks  = blocks;
					scope.section.blocks = blocks;
					scope.UpdateSort("block",sortlist);
					scope.$apply();
				}
			});
			element.disableSelection();
		}
	};
});
App.directive('map', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			if(element.parents("#modal-edit-block").length == 0) return false;
			element.parent().parent().prepend('<div class="form-group"><input type="text" name="class_name" class="form-control" id="search-places" value="" placeholder="Enter the place you want to find"></div>');
			this.meta     = scope.meta;
			this.position = this.meta.value.replace(/\'/g, '"');
		    this.mapdiv   = element[0];
		    this.map      = new google.maps.Map(this.mapdiv, {
				zoom: 6,
			});
			this.infowindow    = new google.maps.InfoWindow();
			this.geocoder      = new google.maps.Geocoder();
			this.draggable     = true;
			this.position      = JSON.parse(this.position);
			this.search        = element.parent().parent().find("#search-places")[0];
			this.marker        = new google.maps.Marker(this);
			this.marker.parent = this.meta;
			var _this = this;
			_this.geocoder.geocode({
				'latLng':  _this.position
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results.length > 0) {
						_this.infowindow.setContent(results[0].formatted_address);
					} else {
						_this.infowindow.setContent("Not found");
					}
					_this.infowindow.open(_this.map, _this.marker);
				}
			});
			setTimeout(function() {
				google.maps.event.trigger(_this.map, "resize");
				_this.map.setCenter(_this.position);
			}, 200);
			//Search place
			_this.autocomplete = new google.maps.places.Autocomplete(_this.search, {
				types: ['geocode']
			});
			_this.autocomplete.bindTo('bounds', _this.map);
			_this.autocomplete.addListener('place_changed', function() {
				var place = this.getPlace();
				if (!place.geometry) {
					window.alert("No details available for input: '" + place.name + "'");
					return;
				}
				if (place.geometry.viewport) {
					_this.map.fitBounds(place.geometry.viewport);
				} else {
					_this.map.setCenter(place.geometry.location);
				}

				_this.marker.setPosition(place.geometry.location);
				_this.marker.infowindow.setContent(place.formatted_address);
				_this.marker.infowindow.open(_this.map, _this.marker);
				_this.marker.parent.value = JSON.stringify(place.geometry.location);
				_this.marker.parent.markerPoint.setPosition(place.geometry.location);
				_this.marker.parent.markerPoint.infowindow.setContent(place.formatted_address);
				_this.marker.parent.markerPoint.infowindow.open(_this.marker.parent.markerPoint.map,_this.marker.parent.markerPoint);		
			});
			//bin event 
			_this.marker.addListener('dragend', function(event) {
				var latlng = {
					lat: event.latLng.lat(),
					lng: event.latLng.lng()
				}
				_this.marker.setPosition(latlng);
				_this.marker.parent.value = JSON.stringify(latlng);
				_this.marker.infowindow.open(_this.map, _this.marker);
				_this.geocoder.geocode({
					'latLng': latlng
				}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						if (results.length > 0) {
							_this.marker.infowindow.setContent(results[0].formatted_address);
							try{
								_this.marker.parent.markerPoint.infowindow.setContent(results[0].formatted_address);
							}catch(e){}
						} else {
							_this.marker.infowindow.setContent("Not found");
							try{
								_this.marker.parent.markerPoint.setContent("Not found");
							}catch(e){}
							
						}
						_this.marker.infowindow.open(_this.map,_this.marker);
						try{
							_this.marker.parent.markerPoint.infowindow.open(_this.marker.parent.markerPoint.map,_this.marker.parent.markerPoint);
						}catch(e){}
					}
				});
			});	 
		}
	};
});
App.directive('sectionsmenu', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			element.sortable({
				connectWith: "parent",
				cursor: "move",
				handle: "#move-action",
				revert: true,
				stop: function(event, ui) {
					var sections = [];
					var sortlist = [];
					angular.forEach(angular.element("#sections-setting ul[sectionsmenu] li"), function(value, key) {
						var ramkey = angular.element(value).attr("ramkey");
						var sort = 0;
						$.each(scope.sections, function(key, val) {
							if (val.ramkey == ramkey) {
								val.sort = sort;
								sections.push(val);
								sortlist.push({
									theme_section_id : val.theme_section_id
								});
								sort++;
							}
						});
					});
					scope.sections = sections;
					scope.UpdateSort("section",sortlist);
					$.each(scope.sections,function(){
						try{
							this.reload();
						}catch(e){}
					});
					scope.$apply();
				}
			});
			element.disableSelection();
		}
	};
});
App.directive('sortablemeta', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'C',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			element.sortable({
				connectWith: "parent",
				cursor: "move",
				handle:'.is_list',
				revert: true,
				placeholder: "ui-state-highlight",
				stop: function(event, ui) {					
					var parent   = ui.item.parent();
					var metas    = [];
					var item     = ui.item.scope();
					var sortlist = [];
					var sort     = 0;
					$.each(parent.find(">li"), function(k, v) {
						var ramkey = $(this).attr("ramkey");
						$.each(item.$parent.$parent.part.metas, function(k, v) {
							if (ramkey == v.ramkey) {
								v.sort = sort;
								metas.push(v);
								sortlist.push({
									meta_id          : v.id,
									section_block_id : v.section_block_id ,
									theme_section_id : v.theme_section_id
								});
								sort ++;
							}
						});					
					});
					item.$parent.$parent.part.metas = metas;
					scope.UpdateSort("meta",sortlist);
					try{
						scope.$apply();
					}catch(e){
						console.log(e)
					}
					
				}
			});
			element.disableSelection();
		}
	};
});
App.directive('blocksmenu', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			element.sortable({
				connectWith: "parent",
				cursor: "move",
				handle: "#move-action",
				revert: true,
				stop: function(event, ui) {
					var parent = ui.item.parent();
					var blocks = [];
					var sort = 0;
					var item = ui.item.scope();
					var sortlist = [];
					$.each(element.find("> li"), function(k, v) {
						var ramkey = $(this).attr("ramkey");
						$.each(scope.blocks, function(k, v) {
							if (ramkey == v.ramkey) {
								v.sort = sort;
								blocks.push(v);
								sortlist.push({
									section_block_id : v.section_block_id ,
									theme_section_id : v.theme_section_id
								});
								sort++;
							}
						});
					});
					scope.blocks=blocks;
					scope.UpdateSort("block",sortlist);
					scope.$apply();
				}
			});
			element.disableSelection();
		}
	};
});
App.directive('colorpicker', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			element.colorpicker({
				color: element.val(),
				defaultPalette: 'web',
				history: false,
				hideButton: true,
			});
		}
	};
});
App.directive('openfilemanager', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'AE',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			var beforchoose = function(val) {
				var type_action = element.attr("data-action");
				if (type_action == "background-image") {
					if (scope.support_key == "theme") {
						scope.theme.style["background-image"] = 'url(' + val[0].path + ')';
					} else if (scope.support_key == "section") {
						scope.section.style["background-image"] = 'url(' + val[0].path + ')';
					};
				}
				if (type_action == "sound") {
					var newsound = val[0];
					newsound.active = 1;
					newsound.start = 0;
					scope.theme.sound = newsound;
					scope.theme.sound_file = val[0].id;
				}
				if (type_action == "theme_thumb") {
					scope.theme.thumb_url = val[0].thumb;
					scope.theme.thumb = val[0].id;
				}
				if (type_action == "effect") {
					scope.theme.effect = 1;
					scope.theme.effect_file.thumb = val[0].thumb;
					scope.theme.effect_file.path  = val[0].path;
					scope.theme.effect_media_id   = val[0].id;
				}
				scope.$apply();
			}
			var before = function() {
				this.query.max_file = element.attr("data-max");
				this.query.type_file = element.attr("data-type");
				var ext_filter = element.attr("data-exe");
				if (ext_filter) {
					this.query.ext_filter = ext_filter;
				}
				var length_medias = $(".modal #content-list .info-item").length;
				if (length_medias >= this.query.max_file && this.query.max_file > 1) {
					alert("Vui lòng chọn tối đa " + this.query.max_file + " file");
					return false;
				}
				return true;
			}
			element.Scfilemanagers({
				base_url: AppAccess,
				before: before,
				beforchoose: beforchoose,
				after: function() {
					//$("body").addClass("modal-open");
				}
			});
		}
	};
});
App.directive('openmanageformeta', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			var beforchoose = function(val) {
				var _this = this;
				if (val != null) {
					$.each(val, function(k, v) {
						v.media_id = v.id;
						v.id = 0;
						v.block_part_id    = scope.part.block_part_id;
						v.meta_key         = "value_media";
						v.section_block_id = scope.part.section_block_id;
						v.theme_section_id = scope.part.theme_section_id;
						if(_this.query.max_file > 1){
							scope.part.metas.push(v);
						}else{
							v.id = scope.part.metas[0].id;
							scope.part.metas[0] = (v);
							return false;
						}
					});		
				}
				scope.$apply();
			}
			var before = function() {
				$("#modal-filemanager").on("hidden.bs.modal",function(){
		            if(scope.support_key == "block"){
		           		$("body").addClass("modal-open");
		            }
		        });
				var length_medias = (scope.metas.length);
				if(element.attr("data-max") > 1){
					this.query.max_file = parseInt(element.attr("data-max")) - length_medias;
				}else{
					this.query.max_file = 1;
				}
				this.query.type_file = element.attr("data-type");
				var ext_filter = element.attr("data-exe");
				if (ext_filter) {
					this.query.ext_filter = ext_filter;
				}
				if (length_medias >= this.query.max_file && this.query.max_file > 1) {
					alert("Vui lòng chọn tối đa " + this.query.max_file + " file");
					return false;
				}
				return true;
			}
			element.Scfilemanagers({
				base_url: AppAccess,
				before: before,
				beforchoose: beforchoose,
			});
		}
	};
});
App.directive('sliderbootstrap', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'AEC',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			var unit = element.attr("data-unit");
			setTimeout(function() {
				element.sliderbootstrap({
					formatter: function(value) {
						return value + unit;
					}
				});
			}, 100);
		}
	};
});
App.directive('datetime', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			try {
				element.datetimepicker('destroy');
			} catch (e) {}
			setTimeout(function() {
				element.datetimepicker({
					format: 'd/m/Y H:i',
					formatDate: 'd/m/Y H:i',
				});
			}, 20);
		}
	}
});
App.directive('day', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			try {
				element.datetimepicker('destroy');
			} catch (e) {}
			setTimeout(function() {
				element.datetimepicker({
					timepicker: false,
					format: 'd/m/Y',
					formatDate: 'd/m/Y',
				});
			}, 20);
		}
	}
});
App.directive('month', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			try {
				element.datetimepicker('destroy');
			} catch (e) {}
			setTimeout(function() {
				element.datetimepicker({
					timepicker: false,
					format: 'm',
					formatDate: 'm',
					viewMode: "months"
				});
			}, 20);
		}
	}
});
App.directive('year', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		template :'<option ng-repeat="year in years" value="{{year}}">{{year}}</option>',
		//The link function is responsible for registering DOM listeners as well as dating the DOM.
	}
});
App.directive('hours', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			try {
				element.datetimepicker('destroy');
			} catch (e) {}
			setTimeout(function() {
				element.datetimepicker({
					datepicker: false,
					format: 'H:i',
					formatDate: 'H:i'
				});
			}, 20);
		}
	}
});
App.directive('mapsorganizing',['$compile', function($compile) {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		replace: false,
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			this.index      = parseInt(element.closest("section").attr("data-index"));
			this.mapdiv     = element[0];
			this.geocoder   = new google.maps.Geocoder();
			this.map        = new google.maps.Map(this.mapdiv, {
				zoom: 16,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			this.markers    = [];
			var section     = scope.sections[this.index];
			var _this    = this;
			_this.bounds = new google.maps.LatLngBounds();
			try{
				$.each(section.blocks,function(){
					if(this.id == section.default_block){
						$.each(this.parts,function(){
							if(this.name == "map"){
								var meta         = this.metas[0];
								var value        = meta.value;
								meta.position    = JSON.parse(value.replace(/\'/g, '"'));
								meta.map         = _this.map;
								meta.geocoder    = _this.geocoder;
								meta.infowindow  = new google.maps.InfoWindow();
								meta.markerPoint = new google.maps.Marker(meta);
								_this.markers.push(meta.markerPoint);
								_this.bounds.extend(meta.markerPoint.getPosition());
								meta.map.setCenter(meta.position);
							}
						})
					}
				});	
				_this.map.fitBounds(_this.bounds);
				setTimeout(function() {
					google.maps.event.trigger(_this.map, "resize");
				}, 200);	
			}catch(e){
				console.log(e);
			}
			scope.sections[this.index].reload = function(){
				_this.bounds = new google.maps.LatLngBounds();
				for (var i = 0; i < _this.markers.length; i++) {
		          _this.markers[i].setMap(null);
		        }
				$.each(this.blocks,function(){
					if(this.id == section.default_block){
						$.each(this.parts,function(){
							if(this.name == "map"){
								var meta         = this.metas[0];
								var value        = meta.value;
								meta.position    = JSON.parse(value.replace(/\'/g, '"'));
								meta.map         = _this.map;
								meta.geocoder    = _this.geocoder;
								meta.infowindow  = new google.maps.InfoWindow();
								meta.markerPoint = new google.maps.Marker(meta);
								_this.bounds.extend(meta.markerPoint.getPosition());
							}
						})
					}
				});
				_this.map.fitBounds(_this.bounds);	
			}		
		}
	}
}]);
App.directive('defaultblock',['$compile', function($compile) {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		replace: false,
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {	
			element.ready(function() {
				setTimeout(function(){
					var index  = element.closest("section").attr("data-index");
					var layout = element.attr("data-layout");
					var section = scope.sections[index];
					var window_W = $("html").outerWidth();
					var window_H = $("html").outerWidth();
					if(section.layout_show_block == "grid"){
						var index = 1;
						$.each(element.find("block"),function(key,value){
							if(index % section.ncolum_block == 0 ){
								$(this).after('<div class="row break-clolums"><div/>');
							}
							index++;
						});
					}
					if(section.layout_show_block == "slider"){
						try {
							element.find(".default-blocks").destroySlider();
						}catch(e){
							                		
						}
						var pager;
						var controls ;
						var item = element.attr("data-item");
						var w    = element.closest(".wrapper-section").outerWidth();
						var lenght_item  = element.find("block").length;
						item = parseInt(item);
						if(lenght_item > item)  item;
						else item = lenght_item;
						if(window_W < 1025) {
							pager = true ; 
							controls = false;
							if(item < 3) item = item;
							else item = 3;
						}
						else {
							pager = false;
							controls = true;
						}
						if(window_W < 769) {
							if(item < 2) item = item;
							else item = 2;
						}
						if(window_W < 421) {
							item = 1;
							pager = true;
							controls = false ;
						}
						element.find(".default-blocks").bxSlider({
							minSlides  : item,
							maxSlides  : item,
							slideWidth : w/item,
							pager      : pager,
							controls   : controls,
							auto       : false,
							infiniteLoop: false,
							autoStart: false,
							slideMargin : 15
						});
						setTimeout(function(){
							$(window).trigger('resize');
						},300);
					}
					if(section.class_name == "section-organizing-points"){
						element.parents(".wrapper-section").append('<div class="box-add"><mapsorganizing data-index="'+index+'"></mapsorganizing></div>');
						$compile(element.parents(".wrapper-section").find(".box-add").contents())(scope);
					}
				},1000);	
			});	
		}
	}
}]);
App.directive('section',['$compile', function($compile) {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			setTimeout(function() {
				if(element.hasClass("section-count-down")){
					this.index = parseInt(element.attr("data-index"));
					this.section = scope.sections[this.index];
					var time = element.find(".block-count-down metadatas metadata").attr("data-value");
					var datimeElement = element.find(".block-count-down metadatas metadata");
					var b_key = parseInt(datimeElement.closest("block").attr("data-index"));
					var p_key = parseInt(datimeElement.closest("part").attr("data-index"));
					var m_key = parseInt(datimeElement.attr("data-index"));
					try{
						try{
							element.find("#content-section .wrapper-section .block-count-down .wrapper-block #countdown").countdown('destroy');
						}catch(e){}
						this.section.blocks[b_key].parts[p_key].metas[m_key].reload = function(){
							time = element.find(".block-count-down metadatas metadata").attr("data-value");
							var t = time.toDate("dd/mm/yyyy hh:ii");
							var datetime = new Date(t);
							element.find("#content-section .wrapper-section .block-count-down .wrapper-block #countdown").countdown(datetime, function(event) {
								var month = event.strftime('%-m');
								var year = event.strftime('%-y');
								var string = "";
								if(parseInt(year) > 0) string += event.strftime('<div class="item"><span class="number">%-y</span><span class="text">Năm</span></div>');
								if(parseInt(month) > 0)
									string += event.strftime('<div class="item"><span class="number">%-m</span><span class="text">Tháng</span></div>');
							    string += event.strftime(''
								    + '<div class="item"><span class="number">%-n</span> <span class="text">Ngày</span></div>'
								    + '<div class="item"><span class="number">%H</span> <span class="text">Giờ</span></div>'
								    + '<div class="item"><span class="number">%M</span> <span class="text">Phút</span></div>'
								    + '<div class="item"><span class="number">%S</span> <span class="text">Giây</span></div>'
							    ); 
							    var $this = $(this).html(string); 
							});
						}
					}catch(e){}
					var html = '<div ng-if="mode > 0" id ="countdown"></div>';
					var t = time.toDate("dd/mm/yyyy hh:ii");
					var datetime = new Date(t);
					console.log(datetime);
					element.find("#content-section .wrapper-section .block-count-down .wrapper-block").append(html);
					element.find("#content-section .wrapper-section .block-count-down .wrapper-block #countdown").countdown(datetime, function(event) {
						var month = event.strftime('%-m');
						var year = event.strftime('%-y');
						var string = "";
						if(parseInt(year) > 0) string += event.strftime('<div class="item"><span class="number">%-y</span><span class="text">Năm</span></div>');
						if(parseInt(month) > 0)
							string += event.strftime('<div class="item"><span class="number">%m</span><span class="text">Tháng</span></div>');
						    string += event.strftime(''
							    + '<div class="item"><span class="number">%-n</span> <span class="text">Ngày</span></div>'
							    + '<div class="item"><span class="number">%H</span> <span class="text">Giờ</span></div>'
							    + '<div class="item"><span class="number">%M</span> <span class="text">Phút</span></div>'
							    + '<div class="item"><span class="number">%S</span> <span class="text">Giây</span></div>'
						    ); 
					    var $this = $(this).html(string); 
					});
				}		
			}, 20);
		}
	}
}]);
App.directive('uploads', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			element.click(function(){
				var type = element.attr("data-type");
				var max = element.attr("data-max");
				var action = element.attr("data-action");
				var current = null;
				if(parseInt(max) > 1){
					current = scope.uploads;
				}else{
					current = scope.upload;
				}
				current.attr("accept",type+"/*");
				current.attr("data-max",max);
				current.attr("data-action",action);
				current.trigger("click");
				var index = element.parents("data-index");
			});
		}
	}
});
function tinymce_updateCharCounter(el, len) {
    $('#' + el.id).prev().find('.char_count').text(len + '/' + el.settings.max_chars);
}
function tinymce_getContentLength() {
    return tinymce.get(tinymce.activeEditor.id).contentDocument.body.innerText.length;
}
App.directive('editor', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			var _this = this;
			try{
				$("#" + element.attr("id")).tinymce().remove();
			}catch(e){
				
			}
			setTimeout(function() {
				_this.maxchar    = parseInt(element.attr("data-length"));
				_this.current    = $("#" + element.attr("id") );
				_this.idCurrent  = "#"+element.attr("id");
				_this.oldContent = _this.current.val();
				_this.css = "";
				_this.height  = 250;
				_this.height  = _this.maxchar == 100 ? 70 : 250;
				_this.editor  = tinymce.init({
					selector  : _this.idCurrent,
					max_chars : _this.maxchar, 
					setup: function (ed) {
				        var allowedKeys = [20,16,17,9,8, 37, 38, 39, 40, 46];  // backspace, delete and cursor keys
				        ed.on('KeyDown', function (e) {
				        	if (allowedKeys.indexOf(e.keyCode) == -1){
					        	if((tinymce_getContentLength() ) > this.settings.max_chars - 1){
					        		e.stopPropagation();
					        		e.preventDefault();
					        		return false;
					        	}
					        }
					        $("#"+this.id).val( tinyMCE.activeEditor.getContent() );
				            $("#"+this.id).trigger("change");
				            _this.oldContent = tinyMCE.activeEditor.getContent();	
				        	tinymce_updateCharCounter(this, tinymce_getContentLength());      
				        });
				        ed.on('KeyUp', function (e) {
				        	$("#"+this.id).val( tinyMCE.activeEditor.getContent() );
				            $("#"+this.id).trigger("change");	
				            _this.oldContent = tinyMCE.activeEditor.getContent();
				        	tinymce_updateCharCounter(this, tinymce_getContentLength());
				        });
				        ed.on('change', function (e) {
				        	$("#"+this.id).val( tinyMCE.activeEditor.getContent() );
				            $("#"+this.id).trigger("change");
				            _this.oldContent = tinyMCE.activeEditor.getContent();	
				            tinymce_updateCharCounter(this, tinymce_getContentLength());
				        });
				        ed.on('Undo', function (e) {
				        	$("#"+this.id).val( tinyMCE.activeEditor.getContent() );
				            $("#"+this.id).trigger("change");
				            _this.oldContent = tinyMCE.activeEditor.getContent();	
				            tinymce_updateCharCounter(this, tinymce_getContentLength());
					    });
					    ed.on('Redo', function (e) {
				        	$("#"+this.id).val( tinyMCE.activeEditor.getContent() );
				            $("#"+this.id).trigger("change");
				            _this.oldContent = tinyMCE.activeEditor.getContent();	
				            tinymce_updateCharCounter(this, tinymce_getContentLength());
					    });
					    ed.on('Paste', function (e) {
					    	var _thisNote = this;
					    	_this.oldContent = tinyMCE.activeEditor.getContent();
					    	setTimeout(function(){
					    		if((tinymce_getContentLength() ) > _thisNote.settings.max_chars){
					        		tinyMCE.activeEditor.undoManager.undo(); 
					                alert ("Vui lòng nhập nhiều nhất " +_thisNote.settings.max_chars+ " kí tự" );
					        	}
					    	},300);
					    });
				    },
				    init_instance_callback: function () { // initialize counter div
				        $('#' + this.id).prev().append('<div class="char_count" style="text-align:right"></div>');
				        tinymce_updateCharCounter(this, tinymce_getContentLength());
				    },
					menubar: false,
					content_css : scope.theme.style_url +',' + AppAccessSkin + 'skins/css/editor-style.css' ,
					content_style: _this.css,
					plugins: [
						'textcolor',
						'code',
						'colorpicker',
						'advlist autolink lists link image charmap print preview anchor',
					],   
					contextmenu : false , 
					toolbar: 'fontsizeselect fontselect | bold italic | forecolor alignleft aligncenter alignright alignjustify | outdent indent | link | code',
					font_formats:_ScriptThemeCongif_.fonts,
					fontsize_formats : scope.font_size.trim(),
					mode : "exact",
					height: _this.height,
				});
			}, 20);
		}
	}
});
App.directive('effictelent', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			var thumb = scope.theme.effect_file.thumb ? scope.theme.effect_file.thumb : "http://weddingguu.xyz/uploads/source/imgeffect/start-59eef88a17c0f.png";
			var minSize = scope.theme.effect_file.minsize ? scope.theme.effect_file.minsize : 10;
			var maxSize = scope.theme.effect_file.maxsize ? scope.theme.effect_file.maxsize : 40;
			var newOn = scope.theme.effect_file.onnew ? scope.theme.effect_file.onnew : 800;
			$.fn.snow({
				element : element,
                minSize : parseInt(minSize),
                maxSize : parseInt(maxSize),
                newOn   : parseInt(newOn),
                flakeColor : '#fff',
                html: '<img src="'+thumb+'">'
            });
		}
	}
});
App.directive("p", function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			if(element.text() == null || element.text().trim() == "") element.remove();
		}
	}
});
String.prototype.replaceAll = function(search, replacement) {
	var target = this;
	return target.split(search).join(replacement);
}
String.prototype.toDate = function(format){
  var normalized      = this.replace(/[^a-zA-Z0-9]/g, '-');
  var normalizedFormat= format.toLowerCase().replace(/[^a-zA-Z0-9]/g, '-');
  var formatItems     = normalizedFormat.split('-');
  var dateItems       = normalized.split('-');
  var monthIndex      = formatItems.indexOf("mm");
  var dayIndex        = formatItems.indexOf("dd");
  var yearIndex       = formatItems.indexOf("yyyy");
  var hourIndex       = formatItems.indexOf("hh");
  var minutesIndex    = formatItems.indexOf("ii");
  var secondsIndex    = formatItems.indexOf("ss");
  var today = new Date();
  var year  = yearIndex>-1  ? dateItems[yearIndex]    : today.getFullYear();
  var month = monthIndex>-1 ? dateItems[monthIndex]-1 : today.getMonth()-1;
  var day   = dayIndex>-1   ? dateItems[dayIndex]     : today.getDate();
  var hour    = hourIndex>-1      ? dateItems[hourIndex]    : today.getHours();
  var minute  = minutesIndex>-1   ? dateItems[minutesIndex] : today.getMinutes();
  var second  = secondsIndex>-1   ? dateItems[secondsIndex] : today.getSeconds();
  return new Date(year,month,day,hour,minute,second);
};