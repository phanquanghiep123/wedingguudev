
var geolocation = {
  lat: 21.028511,
  lng: 105.804817
};
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function (position) {
    geolocation = {
      lat: position.coords.latitude,
      lng: position.coords.longitude
    };
  });
}
var App = angular.module('ThemeApp', ["ngMap"]);
var zindex = 2000;
App.config(['$qProvider', ($qProvider) => {
	$qProvider.errorOnUnhandledRejections(false);
}]);
App.config(['$httpProvider', ($httpProvider) => {
	$httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
	$httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
	$httpProvider.interceptors.push(['$q', function ($q) {
		return {
			request: function (config) {
				if (config.data && typeof config.data === 'object') {
					config.data = $.param(config.data);
				}
				return config || $q.when(config);
			}
		};
	}]);
}]); 
App.controller("PageController", ($scope, $http, $compile) => {
	$("#page_theme").show();
	$scope.defaultContent = 1900;
	$scope.callserver = 0;
	$scope.oldsection = {
		id: 0
	};
	$scope.review = 0;
	$scope.snow = null;
	$scope.scaleWidth = 0;
	$scope.audio_play = 0;
	$scope.upload = $("#box-upload #upload");
	$scope.uploads = $("#box-upload #uploads");
	$scope.theme = {};
	$scope.oldFunction = null;
	$scope.oldFunction1 = null;
	$scope.theme.id = ThemeID;
	$scope.theme.ramkey = Ramkey;
	$scope.theme.effect = 0;
	$scope.theme.effect_file = {
		minsize: 10,
		maxsize: 40,
		onnew: '800'
	};
	$scope.save = true;
	$scope.image_effects;
	$scope.theme.effect_media_id = 0;
	$scope.theme.effect_play = 0;
	$scope.theme.sound_play = 0;
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
	$scope.theme.sound = {};
	$scope.tabsound = 0;
	$scope.backgrounds = [];
	$scope.fonts = [];
	$scope.taggetTab = 0;
	$scope.item = {};
	$scope.scaleScreen = 1;
	var min = 1990;
	var today = new Date();
	$scope._month_ = today.getMonth() + 1;
	$scope._day_ = today.getDate();
	$scope._year_ = today.getFullYear();
	$scope._hours_ = today.getHours();
	$scope._defaultday_ = $scope._day_ + '/' + $scope._month_ + "/" + $scope._year_;
	var max = (new Date()).getFullYear();
	$scope.years = [];
	for (var i = min; i <= max; i++) {
		$scope.years.push(i);
	}
	var tag_audio = new Audio();
	var currentAction = false;
	$scope.support_key = "theme";
	var current_key = 0;
	var stringAllfronts = _ScriptThemeCongif_.setting_fonts + _ScriptThemeCongif_.fonts;
	var argFonts = stringAllfronts.split(";");
	var newargFonts = [];
	var ContenWidth = $("#content").innerWidth();
	var ContenHeight     = $(window).innerHeight();
	$scope.Screenheight  = $("html").innerHeight();
	$scope.WinDowScreenheight  = $("html").height();
	$scope.ScreenWidth         = $("html").innerWidth();
	$scope.scaleScreen   = ContenWidth/$scope.ScreenWidth;
	$scope.OnloadIframe  = false;
	$.each(argFonts, function ($key, $value) {
		try {
			if ($value.trim() != "undefined"); {
				var arg = $value.split("=");
				if (arg.length > 1 && typeof (arg[0]) != undefined && typeof (arg[1]) != undefined) {
					newargFonts.push(arg);
				}
			}
		} catch (error) {

		}
	});
	$scope.AllFontFamily = newargFonts;
	$scope.background_repeat = [{
			value: "repeat",
			label: "Lặp lại",
		},
		{
			value: "repeat-x",
			label: "Lặp lại trục ngang"
		},
		{
			value: "repeat-y",
			label: "Lặp lại trục dọc"
		},
		{
			value: "no-repeat",
			label: "Không lặp lại"
		}
	];
	$scope.background_size = [{
			value: "auto",
			label: "Tự động",
		},
		{
			value: "cover",
			label: "Bao phủ",
		},
		{
			value: "contain",
			label: "Chứa đựng",
		},
	];
	$scope.backgroundType = [{
		name: "Sử dụng ảnh mẫu",
		"id": "1"
	}];
	$scope.background_position = [
		{
			value: "left top",
			label: "Bên trái phía trên",
		},
		{
			value: "left center",
			label: "Bên trái canh giữa",
		},
		{
			value: "left bottom",
			label: "Bên trái phía dưới",
		},
		{
			value: "right top",
			label: "Bên phải phía trên",
		},
		{
			value: "right center",
			label: "Bên phải canh giữa",
		},
		{
			value: "right bottom",
			label: "Bên phải phía dưới",
		},
		{
			value: "center center",
			label: "Trung tâm",
		},
		{
			value: "top center",
			label: "Canh giữa phía trên",
		},
		{
			value: "bottom center",
			label: "Canh giữa phía dưới",
		}
	];
	$scope.background_attachment = [
		{
			value: "auto",
			label: "Tự động",
		},
		{
			value: "scroll",
			label: "Cuộn theo",
		},
		{
			value: "fixed",
			label: "Cố định",
		}
	];
	$scope.is_changeSectionStyle = false;
	//sidebar.
	$scope.actionschange = [
		{
			id: 0,
			value: "adjustment view-page",
			name: "Tùy chỉnh",
			active: 1
		},
		{
			id: 1,
			value: "view-page",
			name: "Xem trang",
			active: 0
		}
	];
	var ArgScreen  =
	[
		{
			size  : 1920,
			height : 940,
			label: " < 1921px (pc)",
			active : 0 
		},
		{
			size : 1366,
			height : 768,
			label: " < 1367px (laptop)",
			active : 0 
		},
		{
			size : 1024,
			height : 768,
			label: " < 1025px (tablet ngang)",
			active : 0 
		},
		{
			size : 768,
			height : 1024,
			label: " < 769px (tablet dọc)",
			active : 0 
		},
		
		{
			size : 412,
			height : 734,
			label: " < 413px (mobile dọc)",
			active : 0 
		},
		{
			size : 375,
			height : 734,
			label: " < 376px (mobile dọc)",
			active : 0 
		},
		{
			size : 361,
			height : 734,
			label: " < 361px (mobile dọc)",
			active : 0 
		},
		{
			size : 320,
			height : 568,
			label: " < 321px (mobile dọc)",
			active : 0 
		},
		{
			size : 734,
			height : 375,
			label: " < 734px (mobile ngang)",
			active : 0 
		},
		{
			size : 568,
			height : 320,
			label: " < 568px (mobile ngang)",
			active : 0 
		}
		
	];
	$scope.screens = [
		{
			size : $scope.ScreenWidth,
			label: " hiện tại " + $scope.ScreenWidth + 'px',
			active : 1 
		}
	];
	$.each(ArgScreen,function(key,val){
		if(val.size != $scope.ScreenWidth){
			$scope.screens.push(val);
		}
	});
    $scope.currentScreen = $scope.screens[0];
	$scope.menus = [
		{
			name: "Chế chỉnh sửa",
			id: "page-change",
			controller: "SidebarChange",
			icon: "fa fa-windows"
			},
	    { 
			name : "Màn hình",
			id : "page-screen",
			controller: "SidebarScreen",
			icon: "fa fa fa-tablet"
		},
		{
			name: "Nền trang",
			id: "page-background",
			controller: "SidebarBackground",
			icon: "fa fa-picture-o"
		},
		{
			name: "Phông chữ",
			id: "page-font",
			controller: "SidebarFont",
			icon: "fa fa-fonticons"
		},
		{
			name: "Nhạc nền",
			id: "page-sound",
			controller: "SidebarSound",
			icon: "fa fa-music"
		},
		{
			name: "Hiệu ứng",
			id: "page-effect",
			controller: "SidebarEffect",
			icon: 'fa fa-snowflake-o'
		},
		{
			name: "Sắp xếp",
			id: "sort-section",
			controller: "SortSection",
			icon: "fa fa-refresh"
		},
		{
			name: "Chọn style file",
			id: "page-style",
			controller: "SidebarParts",
			icon: 'fa fa-folder-open'
		},
		{
			name: "Thông tin giao diện",
			id: "page-info",
			controller: "SidebarParts",
			icon: "fa fa-info-circle"
		}
	];
	$scope.notEmit   = false; 
	$scope.font_size = "";
	for (var i = 10; i < 100; i++) {
		$scope.font_size += i + "px ";
	}
	//get pramater_server 
	
	$scope.$watch('theme', function () {
		try {				
			if($scope.callserver == 1)
				$scope.Iframe.$apply();
		}catch(e){}
		
		return false;
	}, true);
	$scope.$watch('theme.font', function () {
		if ($scope.callserver == 1 && $scope.theme.font != null && typeof $scope.theme.font.name != "undefined") {
			$scope.theme.style["font-family"] = $scope.theme.font.name;
			$scope.theme.font_file = $scope.theme.font.id;
		}
		return false;
	}, true);
	$scope.$watch('mode',function(){
		try {				
			if($scope.callserver == 1)
				$scope.Iframe.$apply();
		}catch(e){}
		return false;
	});
	$scope.$watch('theme.sound', function () {
		if ($scope.callserver == 1 && $scope.theme.sound == null) tag_audio.pause();
		if ($scope.callserver == 1 && $scope.theme.sound != null) $scope.theme.sound_file = $scope.theme.sound.id;
		else $scope.theme.sound_file = 0;
		return false;
	}, true);
	$scope.$watch('section', function (newValue, oldValue) {
		try {
			if($scope.callserver == 1)
				if($scope.notEmit == false) {
					$scope.Iframe.$apply();
				}
				else 
					$scope.notEmit = true;
			}catch(e){}
	}, true);
	$scope.$watch('section.ncolum_block', function (newValue, oldValue) {
		if($scope.callserver == 1)
			if(newValue != oldValue)
				if($scope.notEmit == false)
					$scope.Iframe.$apply();
	}, true);
	$scope.$watch('section.ncolum_show_block', function (newValue, oldValue) {
		if($scope.callserver == 1)
			if(newValue != oldValue)
				if($scope.notEmit == false){
					if ($scope.section == null) return false;
					if ($scope.oldsection.id == $scope.section.id) {
						try {
							$scope.section.more = $scope.section.ncolum_show_block;
							$scope.Iframe.$apply();
						} catch (e) { }
					}
					$scope.Iframe.$apply();
				}
	}, true);
	$scope.$watch('section.more', function (newValue, oldValue) {
		if($scope.callserver == 1)
			if(newValue != oldValue)
				$scope.Iframe.$apply();
		return false;
	}, true);
	$scope.$watch("theme.effect_play", function () {
		if ($scope.theme.effect_play != 1) {
			try {
				$.fn.snow({
					start: false
				});
			} catch (err) {}
		}
	});
	$scope.$watch('currentScreen', function (newValue, oldValue) {
		if(newValue.size != oldValue.size)
		$scope.changeScreen();
		return false;
	}, true);
	String.prototype.replaceAll = function (search, replacement) {
		var target = this;
		return target.split(search).join(replacement);
	}
	String.prototype.toDate = function (format) {
		var normalized = this.replace(/[^a-zA-Z0-9]/g, '-');
		var normalizedFormat = format.toLowerCase().replace(/[^a-zA-Z0-9]/g, '-');
		var formatItems = normalizedFormat.split('-');
		var dateItems = normalized.split('-');
		var monthIndex = formatItems.indexOf("mm");
		var dayIndex = formatItems.indexOf("dd");
		var yearIndex = formatItems.indexOf("yyyy");
		var hourIndex = formatItems.indexOf("hh");
		var minutesIndex = formatItems.indexOf("ii");
		var secondsIndex = formatItems.indexOf("ss");
		var today = new Date();
		var year = yearIndex > -1 ? dateItems[yearIndex] : today.getFullYear();
		var month = monthIndex > -1 ? dateItems[monthIndex] - 1 : today.getMonth() - 1;
		var day = dayIndex > -1 ? dateItems[dayIndex] : today.getDate();
		var hour = hourIndex > -1 ? dateItems[hourIndex] : today.getHours();
		var minute = minutesIndex > -1 ? dateItems[minutesIndex] : today.getMinutes();
		var second = secondsIndex > -1 ? dateItems[secondsIndex] : today.getSeconds();
		return new Date(year, month, day, hour, minute, second);
	};
	$scope.loadding = function($element) {
		$element.append('<div class="loadding_ajax"><div class="load_ajax"></div></div>')
	}
	$scope.removeloadding = function($element) {
		$element.find(".loadding_ajax").remove();
	}
	$scope.loaddPage = function () {
		$("body").append('<div class="loadding_ajax"><div class="load_ajax"></div></div>');
	}
	$scope.removeloaddPage = function () {
		$("body > .loadding_ajax").remove();
	}
	$scope.GotoSection = function (section) {
		$('section.active').removeClass("active");
		$('section[ramkey=' + $scope.section.ramkey + ']').addClass("active");
		try {
			$('html').animate({
				scrollTop: $('section[ramkey=' + $scope.section.ramkey + ']').offset().top - 22
			}, 1000);
		} catch (r) {}
	}
	$scope.iframeLoadedCallBack = function(){
		$scope.OnloadIframe = true;
		return true;
	}
	$scope.setScreen = function(screen){
		$scope.currentScreen = screen;
		return false;
	}
	$scope.changeScreen = function(){ 
		$.each($scope.screens,function(){
			this.active = 0;
		});
		if($scope.currentScreen.size > ContenWidth || $scope.currentScreen.height > ContenHeight)
		{
			if($scope.currentScreen.size > ContenWidth && $scope.currentScreen.size > $scope.currentScreen.height){
				$scope.scaleScreen = ContenWidth/$scope.currentScreen.size;
			}else if($scope.currentScreen.size < ContenWidth && $scope.currentScreen.size > $scope.currentScreen.height){
				$scope.scaleScreen = $scope.currentScreen.size/ContenWidth;
			}else if($scope.currentScreen.height > ContenHeight && $scope.currentScreen.size < $scope.currentScreen.height){
				$scope.scaleScreen  = ContenHeight/$scope.currentScreen.height;
			}else if($scope.currentScreen.size > $scope.currentScreen.height){
				$scope.scaleScreen = $scope.currentScreen.size/ContenWidth;
			}else{
				$scope.scaleScreen = 1;
			}	
		}else{
			$scope.scaleScreen = 1;
		}
		
		$scope.reloadPage();
		return false;

	}
	$scope.Changeffect = function () {
		if ($scope.theme.effect != 1) $scope.theme.effect = 1;
		else {
			$scope.theme.effect = 0;
			$scope.theme.effect_play = 0;
		}
	}
	$scope.changeShowHiddenSection = function () {
		if ($scope.section.show_title != 1) $scope.section.show_title = 1;
		else $scope.section.show_title = 0;
	}
	$scope.changeWidthSection = function () {
		if ($scope.section.is_full != 1) $scope.section.is_full = 1;
		else $scope.section.is_full = 0;
	}
	$scope.ChangeRunSound = function () {
		if ($scope.theme.sound_play != 1) $scope.theme.sound_play = 1;
		else $scope.theme.sound_play = 0;
	}
	$scope.ChangeActive = function () {
		if ($scope.theme.is_active != 1) $scope.theme.is_active = 1;
		else $scope.theme.is_active = 0;
	}
	
	$scope.ToggleSidaber = function ($event) {
		$("#sidebar").toggleClass("open");
		if ($scope.support_key == "section") $scope.save_section();
		return false;
	}
	$scope.toDate = function($string,$format) {
		if($string != undefined)
			return $string.toDate($format);
	}

	$scope.reloadPage = function(){
		$scope.loadding($("#content"));
		$http({
			method: "POST",
			responseType: "json",
			data: {
				id : $scope.theme.id,
				allowScreen : $scope.currentScreen.size,
			},
			url: AppAccessCotroller + "themes/reloadwidth/" + $scope.theme.id
		}).then(function(response) {
			if(response.data.status == "success"){
				$scope.sections = response.data.sections;
				$scope.Iframe.$apply();	
			}else{
				if(response.data.redirect != "undefined"){
					//window.location.href = response.data.redirect;
				}
			}
			$scope.removeloadding($("#content"));

		}, function(error) {
			$scope.removeloadding($("#content"));
			//location.reload();
		});
	}
	$scope.initPage = function () {
		document.getElementById("iframe-content").addEventListener("load", function() {
		  $scope.OnloadIframe = true;
		});
		if ($scope.callserver == 0) {
			$scope.loaddPage();
			//get section
			$http({
				method: "POST",
				responseType: "json",
				data: {
					id: $scope.theme.id,
                    allowScreen : $scope.currentScreen.size
				},
				url: AppAccessCotroller + "themes/get_section/" + $scope.theme.id
			}).then(function (response) {
				$scope.sections = response.data.sections;
				$scope.SVsections = response.data.sectionsv;
				$scope.theme = Object.assign($scope.theme, response.data.theme);
				if($scope.theme.effect_file == null){
					$scope.theme.effect_file = {};
				}
				var inval = setInterval(()=> {
					if($scope.OnloadIframe == true){
						$scope.Iframe = document.getElementById("iframe-content").contentWindow.angular.element("#body-iframe").scope();
						$scope.$apply(function() {
							$scope.Iframe.parentWindow = $scope;
							$scope.Iframe.$apply();
							$("#content").css("opacity",1);
						});
						$scope.callserver = 1;
						$scope.removeloaddPage();
						$("#page_theme").css("opacity",1);
						clearInterval(inval);
					} 	
				},100);
			
			}, function (error) {
				console.log(error);
				//location.reload();
			});
			//!get section;
			$http({
				method: "POST",
				responseType: "json",
				url: AppAccessCotroller + "themes/get_pramater_server"
			}).then(function (response) {
				$scope.SVsections = response.data.sections;
				$scope.SVblocks = response.data.blocks;
				$scope.SVparts = response.data.parts;
			}, function (error) {});
			//!get pramater_server 
			//get sounds 
			$http({
				method: "POST",
				responseType: "json",
				url: AppAccessCotroller + "themes/get_groups_backgrounds_sounds"
			}).then(function (response) {
				$scope.group_backgrounds = response.data.backgrounds;
				$scope.group_sounds = response.data.sounds;
				$scope.image_effects = response.data.effects;
			}, function (error) {
				location.reload();
			});
			//!get sounds
		}
	}
	$scope.initPage();
	$scope.CallActions = function () {
		if (this.action.key_id == "add") {
			$scope.BlockAdd(this.$parent.block, this.$parent.$parent.section);
		} else if (this.action.key_id == "edit") {
			$scope.BlockEdit(this.$parent.block, this.$parent.$parent.section)
		} else if (this.action.key_id == "delete") {
			$scope.BlockDelete(this.$parent.$parent.$index)
		}
	}
	$scope.DeleteMeta = function (index) {
		this.$parent.$parent.part.metas.splice(index, 1);
	}
	$scope.InitBlockAction = function ($type) {
		$.each(this.block.actions, function () {
			if (this.key_id == $type && (this.active == 1 || this.active == "1")) {
				return true;
			}
		});
		return false;
	}
	$scope.checkaction = function () {
		if ($scope.actionChangeCurrent = this.action.value) {
			this.action.check = true;
		}
	}
	$scope.ClosechangeSectionStyle = function () {
		$("#sidebar-chang-style-section").removeClass("open");
		try {
			$scope.oldFunction();
		} catch (e) {}
		return false;
	}
	$scope.ClosechangeSectionSetting = function () {
		$("#sidebar-change-setting-title-section").removeClass("open");
		$scope.save = false;
		try {
			$scope.oldFunction();
		} catch (e) {}
		$scope.notEmit = true;
		return false;
	}

	$scope.hoverInBlock = function () {
		this.block.active = 1;
	}
	$scope.hoverOutBlock = function () {
		this.block.active = 0;
	}
	$scope.getContentmenu = function (item = null) {
		var _this = item != null ? item : this.menu;
		$scope.support_key = "theme";
		$scope.action_name = _this.name;
		if (_this.id == "sort-section") {
			$scope.taggetTab = 1;
			return false;
		}
		if (typeof _this.template != "undefined") {
			$scope.action_body = _this.template;
			_this.load = 0;
			$("#sidebar-actions").css("z-index", zindex);
			zindex++;
			$("#sidebar-actions").addClass("open");
			$scope.oldFunction = function () {
				$scope.getContentmenu(_this);
			};
			return false;
		}
		_this.load = 1;
		$http({
			method: "POST",
			responseType: "text",
			data: {
				template: _this.id,
				theme_id: $scope.theme.id
			},
			url: AppAccessCotroller + "themes/get_template_by_sidebar"
		}).then(function (response) {
			$(".content-actions").removeClass("open");
			_this.template = $scope.action_body = response.data;
			_this.load = 0;
			$("#sidebar-actions").css("z-index", zindex);
			zindex++;
			$("#sidebar-actions").addClass("open");
			$scope.oldFunction = function () {
				$scope.getContentmenu(_this);
			};
		}, function (error) {
			_this.load = 0;
			window.location.href = AppAccessCotroller + "/themes/edit/" + $scope.theme.id;
		});
		return false;
	}
	$scope.getBackgrounds = function (group) {
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
	$scope.soundStartStop = function () {
		tag_audio.pause();
		$scope.theme.sound.start = 0;
		$.each($scope.sounds, function () {
			this.start = 0;
		})
		$scope.audio_play = 0;
		return true;
	}
	$scope.initBackground = function (background) {
		if ($scope.theme.background != null) {
			if ($scope.theme.background.id == background.id) {
				background.active = 1;
			}
		}
	}
	$scope.getSounds = function (group) {
		$scope.single_name = group.name;
		$scope.sounds = group.sounds;
		group.load = 1;
		$scope.single_body = "<ul class=\"nav-list-items list_category sound_lists\">\
			<li ng-init=\"InitSound(sound)\" ng-repeat=\"sound in sounds\" class=\"item\" id=\"{{sound.id}}\">\
				{{sound.name}} <div class=\"action\" src=\"#\" ng-src=\"{{sound.path}}\">\
					<span ng-class=\"(sound.start == 1) ?'fa fa-pause-circle':'fa fa-play-circle '\" class=\"\" ng-click=\"StartStop(sound,$event)\" id=\"start_stop\"></span>\
					<span ng-class=\"(sound.active == 1) ? 'fa fa-check-circle-o' :'fa fa-circle-thin'\" ng-click=\"ChosseSounds(sound)\"  class=\"\"></span>\
				</div>\
			</li>\
		</ul>";
		$(".content-actions").removeClass("open");
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		group.load = 0;
		return false;
	}
	$scope.InitSound = function (sound) {
		if ($scope.theme.sound != null) {
			if ($scope.theme.sound.id == sound.id) {
				sound.active = 1;
			}
		}
	}
	$scope.AddNewBlock = function () {
		$scope.loaddPage();
		$http({
			method: "POST",
			responseType: "json",
			data: {
				theme_section_id: $scope.section.theme_section_id,
				section_id: $scope.section.id,
				sort: $scope.section.blocks.length,
				block_id: $scope.section.default_block,
        allowScreen : $scope.currentScreen.size,
			},
			url: AppAccessCotroller + "themes/addblockdefault"
		}).then(function (response) {
			$scope.block = response.data;
			$scope.section.blocks.push($scope.block);
			$scope.BlockEdit($scope.block, $scope.section);
			try {
				$scope.section.reload();
			} catch (e) {}
			$scope.removeloaddPage();
		}, function (error) {
			$scope.removeloaddPage();
			window.location.href = AppAccessCotroller + "/themes/edit/" + $scope.theme.id;
		});
	}
	$scope.AddItem = function ($type = null) {
		if ($type != null) $scope.support_key = $type;
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
		$scope.oldFunction = null;
		try{
			$scope.$apply();
		}catch(e){}
		
	}
	$scope.PartAddNow = function (svpart) {
		svpart.load = 1;
		$http({
			method: "POST",
			responseType: "json",
			data: {
				part: svpart,
				block_id: $scope.block.id,
				sort: $scope.block.parts.length,
				section_block_id: $scope.block.section_block_id,
				theme_section_id: $scope.section.theme_section_id
			},
			url: AppAccessCotroller + "themes/addpart"
		}).then(function (response) {
			$scope.part = (response.data);
			$scope.parts.push(response.data);
			svpart.load = 0;
		}, function (error) {
			svpart.load = 0;
		});
	}
	$scope.IsList = function (part) {
		if (part.name.trim() == "list images") return true;
		return false;
	}
	$scope.SectionAddNow = function (svsection) {
		svsection.load = 1;
		$http({
			method: "POST",
			responseType: "json",
			data: {
				svsection: svsection,
				ramkey: $scope.theme.ramkey,
				sort: $scope.sections.length,
				theme_id: $scope.theme.id,
                allowScreen : $scope.currentScreen.size
			},
			url: AppAccessCotroller + "themes/addsection"
		}).then(function (response) {
			$scope.section = (response.data);
			$scope.sections.push(response.data);
			svsection.load = 0;
			setTimeout(function () {
				if ($scope.section != null && $scope.support_key == "section") {
					$('section.active').removeClass("active");
					$('section[ramkey=' + $scope.section.ramkey + ']').addClass("active");
					try {
						$('html').animate({
							scrollTop: $('section[ramkey=' + $scope.section.ramkey + ']').offset().top - 22
						}, 400);
					} catch (r) {}
				}
			}, 300);
			$scope.Iframe.$apply();
		}, function (error) {
			//svsection.load = 0;
			//window.location.href = AppAccessCotroller + "/themes/edit/" + $scope.theme.id;
		});
	}
	$scope.BlockAddNow = function (svblock) {
		svblock.load = 1;
		$scope.support_key == "block";
		$http({
			method: "POST",
			responseType: "json",
			data: {
				svblock: svblock,
				section_id: $scope.section.id,
				sort: $scope.section.blocks.length,
				theme_section_id : $scope.section.theme_section_id,
				allowScreen : $scope.currentScreen.size
			},
			url: AppAccessCotroller + "themes/addblock"
		}).then(function (response) {
			$scope.block = (response.data);
			$scope.blocks.push(response.data);
			svblock.load = 0;
			$scope.BlockEdit($scope.block, $scope.section);
			$scope.section.init();
			try{
				$scope.section.reload();
			}catch(e){

			}
			setTimeout(function () {
				try {
					$('html').animate({
						scrollTop: $('block[ramkey=' + $scope.block.ramkey + ']').offset().top
					}, 400);
					$scope.block.active = 1
				} catch (r) {}
				//$scope.support_key == "section";
			}, 300);
			$scope.ToBlock();
		}, function (error) {
			svblock.load = 0;
			//window.location.href = AppAccessCotroller + "/themes/edit/" + $scope.theme.id;
		});
	}
	$scope.ChangeSackgroundSection = function () {
		$(".content-actions").removeClass("open");
		$("#sidebar-chang-style-section").css("z-index", zindex);
		zindex++;
		$("#sidebar-chang-style-section").addClass("open");
		$scope.is_changeSectionStyle = true;
	}
	$scope.SettingTitle = function () {
		$scope.notEmit = false;
		$(".content-actions").removeClass("open");
		$("#sidebar-change-setting-title-section").css("z-index", zindex);
		zindex++;
		$("#sidebar-change-setting-title-section").addClass("open");
		$scope.is_changeSectionStyle = true;
	}
	$scope.SettingLayout = function () {
		$(".content-actions").removeClass("open");
		$("#sidebar-change-setting-layout-section").css("z-index", zindex);
		zindex++;
		$("#sidebar-change-setting-layout-section").addClass("open");
		$scope.is_changeSectionStyle = true;
	}
	$scope.RemoveSound = function () {
		$.each($scope.sounds, function () {
			this.active = 0;
		});
		$scope.theme.sound = false;
	}
	$scope.Review = function () {
		$scope.review = 1;
		$scope.loaddPage();
		$scope.Public($("save-box-right"), 1);
	}
	$scope.StartStop = function (sound, $event) {
		$event.stopPropagation();
		$.each($scope.sounds, function () {
			if (sound.id != this.id) {
				this.start = 0;
			}
		});
		if (sound.start == 1) {
			tag_audio.pause();
			sound.start = 0;
			$scope.audio_play = 0;
		} else {
			tag_audio.src = sound.path;
			tag_audio.play();
			sound.start = 1;
			$scope.audio_play = 1;
		}
		return false;
	}
	$scope.ChosseSounds = function (sound) {
		$.each($scope.sounds, function () {
			if (sound.id != this.id) {
				this.active = 0;
			}
		});
		sound.active = !sound.active;
		if (sound.active == 1) {
			$scope.theme.sound = sound;
			$scope.theme.sound_file = sound.media_id;
		} else {
			$scope.theme.sound = null;
			$scope.theme.sound_file = 0;
		}
		$scope.theme.sound_example = 0;
		return false;
	}
	$scope.getActionType = function (type) {
		$scope.single_name = type.name;
		type.load = 1;
		if (type.id == 0) {
			$scope.single_body = "<ul class=\"nav-list-items list_category\"><li openfilemanager href=\"javascript:;\" class=\"ui-button-text\" data-action=\"background-image\" data-type=\"image\" data-max=\"1\" id=\"openFilemanager\"> Mở thư viện file</li><li uploads data-max=\"1\" data-type=\"image\" data-action=\"background-image\">Tải ảnh lên</li> </ul>";
		} else {
			$scope.single_body = "<ul class=\"nav-list-items list_category\"><li ng-class=\"(group.load == 1) ? loadding:''\" ng-repeat=\"group in group_backgrounds\" ng-click=\"getBackgrounds(group)\" class=\"item\" id=\"{{group.id}}\">{{group.name}}</li></ul>";
		}
		$(".content-actions").removeClass("open");
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		type.load = 0;
		$scope.oldFunction1 = function () {
			$scope.getActionType(type);
		};
		return false;
	}
	$scope.OpenExampleEffect = function () {
		$scope.single_name = "Ảnh mẫu hiệu ứng";
		$scope.single_body = "<ul class=\"nav-list-items list_image ng-scope\"><li ng-init=\"initImageEffect(image_effect)\" ng-class=\"(image_effect.active == 1) ? 'active' :''\" ng-repeat=\"image_effect in image_effects\" ng-click=\"ChosseImageEffect(image_effect)\" class=\"item\" id=\"11\"><img src=\"#\" ng-src=\"{{image_effect.thumb}}\"></li></ul>";
		$(".content-actions").removeClass("open");
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		$scope.oldFunction1 = function () {
			$scope.OpenExampleEffect();
		}
		return false;
	}
	$scope.ChosseImageEffect = function (image_effect) {
		$.each($scope.image_effects, function () {
			this.active = 0;
		});
		$scope.theme.effect = 1;
		$scope.theme.effect_file.path = image_effect.path;
		$scope.theme.effect_file.thumb = image_effect.thumb;
		$scope.theme.effect_media_id = image_effect.id;
		image_effect.active = 1;
	}
	$scope.ChangeEffectFile = function () {
		$scope.support_key = "theme";
		$scope.single_name = "Chọn ảnh hiệu ứng";
		$scope.single_body = "<ul class=\"nav-list-items list_category\"><li openfilemanager href=\"javascript:;\" class=\"ui-button-text\" data-action=\"effect\" data-type=\"image\" data-max=\"1\" id=\"openFilemanager\"> Mở thư viện file</li><li uploads data-max=\"1\" data-type=\"image\" data-action=\"effect\">Tải ảnh lên</li> </ul>";
		$(".content-actions").removeClass("open");
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		return false;
	}
	$scope.ChosseBackground = function (background) {
		if ($scope.support_key == "theme") {
			$scope.theme.style["background-image"] = "url('" + background.thumb + "')";
		} else if ($scope.support_key == "section") {
			$scope.section.style["background-image"] = "url('" + background.thumb + "')";
		}
		$.each($scope.backgrounds, function () {
			this.active = 0;
		});
		background.active = 1;
		return false;
	}
	$scope.RemoveBg = function ($v) {
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
	$scope.changmode = function (action) {
		$.each($scope.actionschange, function () {
			this.active = 0;
		});
		$scope.mode = action.id;
		$.each($scope.sections, function () {
			try {
				this.reload();
			} catch (e) {}
		});
		action.active = 1;
		$scope.mode_class = action.value;
		console.log(action);
		$scope.Iframe.$apply();
		return false;
	}
	$scope.Ftabbackgroundimage = function ($v) {
		$scope.tabbackgroundimage = $v;
		return false;
	}
	$scope.CloseActions = function () {
		$("#sidebar-actions").removeClass("open");
		return false;
	}
	$scope.CloseSingle = function () {
		$("#sidebar-single").removeClass("open");
		try {
			$scope.oldFunction();
		} catch (e) {}
		return false
	}
	$scope.CloseChosse = function () {
		$("#sidebar-chosse").removeClass("open");
		try {
			$scope.oldFunction1();
		} catch (e) {
			try {
				$scope.oldFunction();
				$scope.oldFunction = null;
			} catch (e) {

			}
		}
		return false;
	}
	$scope.ToSection = function (section) {
		$scope.taggetTab = 0;
		$("#sidebar-section").css("z-index", zindex);
		zindex++;
		$("#sidebar-section").addClass("open");
		$scope.support_key = "section";
		$scope.section = section;
		$scope.blocks = section.blocks;
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
	$scope.MoveBlockDefault = function (section) {
		$scope.support_key = "section";
		$scope.section = this.section;
		$scope.blocks = this.section.blocks;
		$(".content-actions").removeClass("open");
		$("#sidebar-order-block").css("z-index", zindex);
		zindex++;
		$("#sidebar-order-block").addClass("open");
		return false;
	}
	$scope.CloseOrderBlock = function () {
		$scope.support_key = "theme";
		$("#sidebar-order-block").removeClass("open");
		return false;
	}
	$scope.ToBlock = function (block) {
		$scope.support_key = "block";
		this.block.active = 1;
		$scope.block = this.block;
		setTimeout(function () {
			try {
				$('html').animate({
					scrollTop: $('block[ramkey=' + $scope.block.ramkey + ']').offset().top - 22
				}, 400);
			} catch (r) {}
		}, 300)

		$scope.BlockEdit(this.block, this.$parent.section);
		return false;
	}
	$scope.MetaShow = (part,$show = 0) => {
		//meta show
		if(part == false) return;
		var html_show = part.html_show;
		var list_show = part.list_show;
		html_show = html_show.replace("{{value}}", list_show);
		var stringR = '';
		if (part.metas.length > 0) {
			if (part.metas[0].media_id != 0 && part.metas[0].meta_key == "value_media") {
				stringR = html_show.replace("{{value}}", '{{(AppAccess + part.metas[0].medium)}}').replace("{{media_id}}", "{{part.metas[0].media_id}}");
			} else {
				if (part.name == "content") {
					if ($show == 0) {
						var text = part.metas[0].value;
						jtext = $(text);
						var stringText = "";
						var content = $("<div></div>");
						if(jtext.find('span').length > 1){
							$.each(jtext.find("span"), function (key, val) {
								var stringspan = $(this).text();
								stringText += stringspan;
								if (stringText.length >= 280) {
									stringspan = stringspan.substring(0, 280);
									$(this).html(stringspan);
									content.append($(this).parent());
									return false;
								} else {
									content.append($(this).parent());
								}
							});
						}else{
							var stringspan = jtext.text();
							stringText = stringspan;
							if (stringText.length >= 280) {
								stringspan = stringspan.substring(0, 280);
								jtext.html(stringspan);
								content.append(jtext);
							} else {
								content.append(jtext);
							}
						}
						
						jtext.html(content.html());
						stringR = jtext.wrap("<div></div>").parent().html();
						stringR = html_show.replace("{{value}}", stringR);
					} else {
						stringR = html_show.replace("{{value}}", part.metas[0].value);
					}
				} else {
					stringR = html_show.replace("{{value}}", part.metas[0].value);
				}

			}
		}
		return stringR;
	}
	$scope.Show_Title = function (val) {
		if (val == 1 || $scope.mode == 0) return true;
		else return false;
	}
	$scope.MovingBlock = function(section){
		$scope.notEmit     = true;
		$scope.support_key = "section";
		$scope.section     = section;
		$scope.$apply();
		$("#modal-sort-block").modal();
		return false;
	}
	$scope.blockShow = function (section, block) {
		if ($scope.mode == 2) return true;
		if (block.id == section.default_block) {
			return false;
		} else return true;
	}
	$scope.SectionEdit = function (section, save = true) {
		$(".content-actions").removeClass("open");
		$scope.save_section();
		$scope.support_key = "section";
		$scope.section = section;
		$scope.blocks = section.blocks;
		$scope.taggetTab = 0;
		$("#sidebar-section").css("z-index", zindex);
		zindex++;
		$("#sidebar-section").addClass("open");
		setTimeout(function () {
			$scope.$apply();
			setTimeout(function () {
				$("#sidebar").addClass("open");
			},400);
		}, 100);
		$scope.notEmit = false;
		$scope.oldFunction = function () {
			$scope.SectionEdit(section);
		}
		return false;
	}
	$scope.SectionDelete = function (section) {
		$scope.notEmit = true;
		$scope.section = section;
		$scope.support_key = 'section';
		$("#modal-delete-item").modal();
		return false;
	}
	$scope.Deletetheme = function ($index) {
		$scope.support_key = 'theme';
		$("#modal-delete-item").modal();
		return false;
	}
	$scope.SectionAdd = function (section) {
		$scope.support_key = "section";
		section.order  = true;
		$scope.section = section;
		$scope.blocks  = $scope.section.blocks;
		$scope.notEmit = true;
		$scope.AddItem();
		return false;
	}
	$scope.BlockEdit = function (block, section) {
		$scope.notEmit     = true;
		$scope.support_key = "block";
		$scope.block       = block;
		$scope.parts       = block.parts;
		$scope.section     = section;
		setTimeout(function(){
			$scope.$apply();
			$("#modal-edit-block").modal();
		},50);
		return false;
	}
	$scope.BlockDelete = function (block, section) {	
		$scope.notEmit = true;
		$.each($scope.sections ,function($key,$val){
			if($val.ramkey == section.ramkey){
				$scope.section = $val;
				return false;
			}
		});
		$scope.block = block;
		section.order = true;
		$scope.support_key = 'block';	
		setTimeout(function(){
			$scope.$apply();
			$("#modal-delete-item").modal();
		},100);
		return false;
	}
	$scope.BlockAdd = function (block, section) {
		$scope.notEmit = true;
		$scope.support_key = "block";
		$scope.block = block;
		$scope.parts = block.parts;
		$scope.section = section;
		$scope.AddItem();
		return false;
	}
	$scope.FormEdit = function (meta) {
		var html_edit = this.$parent.part.html_edit;
		var form_edit = html_edit.replace("{{value}}", "");
		if (meta["meta_key"] == "value_text") {
			var s = $('<div>' + form_edit + '</div>');
			s.find('[name="value_text"]').attr("ng-model", "meta.value");
			s.find('[name="value_text"]').attr("id", meta.ramkey);
		} else {
			return form_edit;
		}
		return s.html();
	}
	$scope.FormEditNull = function () {
		var html_edit = this.$parent.part.html_edit;
		return html_edit;
	}
	$scope.ValueForm  = function (meta) {
		var list_show = this.$parent.part.list_show;
		var html_show = this.$parent.part.html_show;
		list_show     = html_show.replace("{{value}}", list_show)
		$scope.part   = this.$parent.part
		$scope.metas  = $scope.part.metas;
		var form_edit = "";
		if (meta["meta_key"] != "value_text") {
			if (meta["meta_key"] == "value_media") {
				form_edit = list_show.replace("{{value}}", "{{meta.medium}}").replace("{{media_id}}", "{{meta.media_id}}");
				form_edit = $("<div>" + form_edit + "</div>");
				form_edit.find(".delete-item").attr("ng-click", "DeleteMeta($index)");
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
	$scope.PartEdit = function (part) {
		$scope.part  = part;
		$scope.metas = $scope.part.metas;
		$scope.support_key = "part";
		$("#modal-edit-part").modal();
		return false;
	}
	$scope.DeleteItem = function () {
		var data = null;
		var $e = $("#modal-delete-item .btn-warning");
		$scope.loadding($e);
		if ($scope.support_key == "section") {
			try {
				data = {
					theme_section_id: $scope.section.theme_section_id
				};
				$.each($scope.sections,function($key,$val){
					if(this.ramkey == $scope.section.ramkey){
						$scope.sections.splice($key, 1);
						return false;
					}
				});
				setTimeout(function(){
					$scope.Iframe.$apply();
				},100);
			} catch (e) {
				return false;
			}
		} else if ($scope.support_key == "block") {
			try {
				data = {
					theme_section_id: $scope.block.theme_section_id,
					section_block_id: $scope.block.section_block_id
				};
				$.each($scope.section.blocks,function($key,$val){
					if($scope.block.ramkey == $val.ramkey){
						$scope.section.blocks.splice($key, 1);
						return false;
					}
				});
				setTimeout(function(){
					$scope.Iframe.$apply();
				},100);
			} catch (e) {}
		} else if ($scope.support_key == "part") {
			try {
				data = {
					block_part_id: $scope.part.block_part_id,
					theme_section_id: $scope.part.theme_section_id,
					section_block_id: $scope.part.section_block_id
				};
				$scope.parts.splice(current_key, 1);
				setTimeout(function(){
					$scope.Iframe.$apply();
				},100);
			} catch (e) {}
		} else if ($scope.support_key == "theme") {
			$http({
				method: "POST",
				responseType: "json",
				data: {
					id: $scope.theme.id
				},
				url  : AppAccessCotroller + "themes/themes/deleteitem/" + $scope.support_key,
			}).then(function (response) {
				$scope.removeloadding($e);
				$("#modal-delete-item").modal("hide");
				if (response.data.status == "success") {
					window.location.href = response.redirect;
				} else {
					window.location.href = "/appthemes/edit/" + $scope.theme.slug;
				}
			}, function (error) {
				$scope.removeloadding($e);
				window.location.href = "/appthemes/edit/" + $scope.theme.slug;
			});
			setTimeout(function(){
				$scope.Iframe.$apply();
			},100);
			return false;
		}
		if (data != null) {
			$http({
				method: "POST",
				responseType: "json",
				data: {
					item: data,
					allowScreen : $scope.currentScreen.size
				},
				url: AppAccessCotroller + "themes/deleteitem/" + $scope.support_key,
			}).then(function (response) {
				$scope.removeloadding($e);
				$("#modal-delete-item").modal("hide");
			}, function (error) {
				$scope.removeloadding($e);
				//window.location.href = AppAccessCotroller + "/themes/edit/" + $scope.theme.id;
			});
		}
		if ($scope.support_key == "section") $scope.support_key = "theme";
		
	}
	$scope.PartDelete = function ($index, parts) {
		current_key = $index;
		$scope.support_key = 'part';
		$scope.parts = parts;
		$scope.part = this.part;
		$("#modal-delete-item").modal();
		return false;
	}
	$scope.Public = function ($e = null, openreview = 0) {
		if ($e == null) {
			$e = $(".save-box-left");
		}
		$scope.loadding($e);
		try {
			if ($scope.support_key == "section")
				$scope.save_section();
		} catch (e) {}
		var dataTheme = {
			id: $scope.theme.id,
			name: $scope.theme.name,
			description: $scope.theme.description,
			thumb: $scope.theme.thumb,
			font_file: $scope.theme.font_file,
			folder: $scope.theme.folder,
			sound_file: $scope.theme.sound_file,
			size_title: $scope.theme.size_title,
			color_title: $scope.theme.color_title,
			color_title: $scope.theme.color_title,
			effect: $scope.theme.effect,
			effect_file: $scope.theme.effect_file,
			effect_media_id: $scope.theme.effect_media_id,
			public: $scope.theme.public,
			status: $scope.theme.status,
			style: $scope.theme.style,
			sound_play: $scope.theme.sound_play,
			sound_example: $scope.theme.sound_example,
			is_active: $scope.theme.is_active
		}
		$http({
			method: "POST",
			responseType: "json",
			data: dataTheme,
			url: AppAccessCotroller + "themes/save_theme/",
		}).then(function (response) {
			setTimeout(function () {
				if (openreview == 1) $("#modal-review").modal();
			}, 300);
			$scope.removeloadding($e);
		}, function (error) {
			$scope.removeloadding($e);
			window.location.href = AppAccessCotroller + "themes/edit/" + $scope.theme.id;
		});
		$scope.notEmit = true;
	}
	$scope.save_block = function () {
		if ($scope.support_key == "block") {
			$scope.support_key == "section";
			var parts = [];
			var metas = [];
			$scope.loadding($("#content"));
			$.each($scope.block.parts, function (key, val) {
				metas = [];
				$.each(this.metas, function () {
					metas.push({
						id: this.id,
						value: this.value,
						media_id: this.media_id,
						section_block_id: this.section_block_id,
						meta_key: this.meta_key,
						theme_section_id: this.theme_section_id,
						block_part_id: this.block_part_id,
						ramkey: this.ramkey
					});
					try {
						this.reload();
					} catch (e) {}
				});
				parts.push({
					actions: this.actions,
					class_name: this.class_name,
					ncolum: this.ncolum,
					block_part_id: this.block_part_id,
					section_block_id: this.section_block_id,
					theme_section_id: this.theme_section_id,
					metas: metas,
					sort: key,
					allowScreen : $scope.currentScreen.size
				});
			});
			$http({
				method: "POST",
				responseType: "json",
				data: {
					actions: $scope.block.actions,
					class_name: $scope.block.class_name,
					sort: $scope.block.sort,
					ncolum: $scope.block.ncolum,
					section_block_id: $scope.block.section_block_id,
					theme_section_id: $scope.block.theme_section_id,
					parts: parts,
					allowScreen : $scope.currentScreen.size
				},
				url: AppAccessCotroller + "themes/save_block/",
			}).then(function (response) {
				$scope.support_key == "section";
				$scope.removeloadding($("#content"));
			}, function (error) {
				window.location.href = AppAccessCotroller + "themes/edit/" + $scope.theme.id;
			});
		}
	}
	$scope.save_section = function () {
		if ($scope.support_key == "section") {
			if ($scope.save == true) {
				$scope.loaddPage();
				$http({
					method: "POST",
					responseType: "json",
					data: {
						theme_section_id: $scope.section.theme_section_id,
						actions: $scope.section.actions,
						class_name: $scope.section.class_name,
						name: $scope.section.name,
						sort: $scope.section.sort,
						show_title: $scope.section.show_title,
						default_block: $scope.section.default_block,
						ncolum_show_block: $scope.section.ncolum_show_block,
						ncolum_block: $scope.section.ncolum_block,
						is_full: $scope.section.is_full,
						layout_show_block: $scope.section.layout_show_block,
						style: $scope.section.style,
						title_color: $scope.section.title_color,
						title_family: $scope.section.title_family,
						title_size: $scope.section.title_size,
						allowScreen : $scope.currentScreen.size
					},
					url: AppAccessCotroller + "themes/save_section/",
				}).then(function (response) {
					$scope.removeloaddPage();
					$scope.support_key == "theme";
				}, function (error) {
					//window.location.href = AppAccessCotroller + "themes/edit/" + $scope.theme.id;
				});
			} else {
				$scope.save = true;
			}

		}
	}
	$scope.RemoveEffectFile = function () {
		$scope.theme.effect_file.thumb = null;
	}
	$scope.CloseSection = function () {
		$scope.support_key == "section";
		$scope.save_section();
		$scope.section = null;
		$("#sidebar-section").removeClass("open");
		$scope.support_key = "theme";
		$scope.taggetTab = 0;
		$scope.oldsection = {
			id: 0
		};
		return false;
	}
	$scope.UpdateSort = function ($type = "section", $list = []) {
		$scope.loaddPage();
		$http({
			method: "POST",
			responseType: "json",
			data: {
				list: $list
			},
			url: AppAccessCotroller + "themes/updatesort/" + $type,
		}).then(function (response) {
			$scope.removeloaddPage();
		}, function (error) {
			window.location.href = AppAccessCotroller + "themes/edit/" + $scope.theme.id;
		});
	}
	$scope.MoreSection = function (section) {
		section.more += parseInt(section.ncolum_show_block);
		try {
			section.defaultblock();
		} catch (e) {

		}
		return true;
	}
	$scope.ActionSection = function (section) {
		var section_action = "";
		var Actionadd = Actiondelete = Actionedit = ActionMove = ActionMore = "";
		$.each(section.actions, function () {
			if (this.key_id == "edit") {
				section_action += '<li><a ng-click="parentWindow.SectionEdit(section)" href="javascript:;" id="edit-action"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>';
			}

			if (this.key_id == "delete") {
				section_action += '<li><a ng-click="parentWindow.SectionDelete(section)" href="javascript:;" id="delete-action"><i class="fa fa-trash" aria-hidden="true"></i></a></li>';
			}
		});
		if (section.default_block != 0) {
			section_action += '<li><a ng-click="parentWindow.SectionAdd(section)" href="javascript:;" id="add-action"><i class="fa fa-plus-square" aria-hidden="true"></i></a></li>';
			section_action += '<li><a ng-click="parentWindow.MoveBlockDefault(section)" href="javascript:;"><i class="fa fa-arrows" aria-hidden="true"></i></a></li>';
		}
		return section_action;
	};
	$scope.ClosechangeSectionStyle = function () {
		$("#sidebar-chang-style-section").removeClass("open");
		try {
			$scope.oldFunction();
		} catch (e) {}
		return false;
	}
	$scope.ActionBlock = function (section) {
		var block = this.block;
		var block_action = "<li><a ng-click=\"parentWindow.BlockEdit(block,section)\" href=\"javascript:;\" id=\"edit-block\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a></li>\
		<li><a ng-click=\"parentWindow.BlockAdd(block,section)\" href=\"javascript:;\" id=\"add-part\"><i class=\"fa fa-plus-square\" aria-hidden=\"true\"></i></a></li>\
		<li><a ng-click=\"parentWindow.BlockDelete(block,section)\" href=\"javascript:;\" id=\"delete-block\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a></li>";
		return block_action;
	}
	$scope.Upload = function (_this) {
		var formData = new FormData();
		$.each(_this.files, function (k, v) {
			formData.append('files[]', v, v.name);
		});
		var type_action = $(_this).attr("data-action");
		$scope.loaddPage();
		$.ajax({
			url: AppAccess + "filemanager/uploadflash/",
			data: formData,
			type: 'POST',
			dataType: "json",
			contentType: false,
			processData: false,
			success: function (e) {
				if (e.status == "success") {
					$.each(e.response, function (k, v) {
						if ($scope.support_key == "block") {
							v.media_id = v.id;
							v.id = $scope.part.metas[0];
							v.block_part_id = $scope.part.block_part_id;
							v.meta_key = "value_media";
							v.section_block_id = $scope.part.section_block_id;
							v.theme_section_id = $scope.part.theme_section_id;
							$scope.part.metas[0] = (v);
						} else if ($scope.support_key == "theme") {
							if (type_action == "background-image") {
								$scope.theme.style['background-image'] = 'url(' + v.full + ')';
							} else if (type_action == "sound") {
								var newsound = v;
								newsound.active = 1;
								newsound.start = 0;
								$scope.theme.sound = newsound;
								$scope.theme.sound_file = newsound.media_id;
								$scope.theme.sound_example = 1;
							} else if (type_action == "effect") {
								$scope.theme.effect = 1;
								$scope.theme.effect_file.path = v.full;
								$scope.theme.effect_file.thumb = v.thumb;
								$scope.theme.effect_media_id = v.id;
							} else if (type_action == "theme_thumb") {
								$scope.theme.thumb_url = v.thumb;
								$scope.theme.thumb = v.id;
							}
						} else if ($scope.support_key == "section") {
							$scope.section.style["background-image"] = 'url(' + v.full + ')';
						}
						return false;
					});
					$scope.$apply();
				}
				$scope.removeloaddPage();
			},
			error: function (e) {
				$scope.removeloaddPage();
				window.location.href = AppAccessCotroller + "themes/edit/" + $scope.theme.id;
			}
		});
	}
	$scope.Uploads = function (_this) {
		var formData = new FormData();
		var length = $scope.part.metas.length;
		var max = parseInt($(_this).attr("data-max"));
		if (max - length < _this.files.length) {
			alert("Vui lòng chọn tối đa " + (max - length) + " tập tin");
			return false;
		}
		$.each(_this.files, function (k, v) {
			formData.append('files[]', v, v.name);
		});
		$scope.loaddPage();
		$.ajax({
			url: AppAccessCotroller + "/filemanager/uploadflash/",
			data: formData,
			type: 'POST',
			dataType: "json",
			contentType: false,
			processData: false,
			success: function (e) {
				if (e.status == "success") {
					$.each(e.response, function (k, v) {
						if ($scope.support_key == "block") {
							v.media_id = v.id;
							v.id = 0;
							v.block_part_id = $scope.part.block_part_id;
							v.meta_key = "value_media";
							v.section_block_id = $scope.part.section_block_id;
							v.theme_section_id = $scope.part.theme_section_id;
							$scope.part.metas.push(v);
						}
					});
					$scope.$apply();
				}
				$scope.removeloaddPage();
			},
			error: function (e) {
				$scope.removeloaddPage();
				window.location.href = AppAccessCotroller + "/themes/edit/" + $scope.theme.id;
			}
		});
	}
	$scope.reloadSection = function() {
	    try {
			var blocks_on = [];
			var blocks_off = [];
			var onload = 0;
			var more = parseInt($scope.section.ncolum_show_block);
			for (var i = 0; i < $scope.section.blocks.length; i++) {
				$scope.section.blocks[i].$index = i;
				$scope.section.blocks[i].active = 0;
				if ($scope.section.blocks[i].id == $scope.section.default_block) {
					blocks_off.push($scope.section.blocks[i]);
				} else {
					blocks_on.push($scope.section.blocks[i]);
				}
			}
			$scope.section.blocks_off = blocks_off;
			$scope.section.blocks_on  = blocks_on;
			$scope.Iframe.$apply();
	    } 
	    catch (e) {
			return false;
	    }
	    return true;
	}
	$scope.save_part = function () {
		if ($scope.support_key == "part") {
			$scope.loaddPage();
			try {
				if ($("#modal-edit-part textarea[ng-model='meta.value']").length > 0) {
					var content = $("#modal-edit-part textarea[ng-model='meta.value']").val();
					$scope.part.metas[0].value = content;
				}
			} catch (e) {

			}
			$http({
				method: "POST",
				responseType: "json",
				data: {
					actions: $scope.part.actions,
					class_name: $scope.part.class_name,
					ncolum: $scope.part.ncolum,
					block_part_id: $scope.part.block_part_id,
					section_block_id: $scope.part.section_block_id,
					theme_section_id: $scope.part.theme_section_id,
					metas: $scope.part.metas,
					sort: $scope.part.sort,
				},
				url: AppAccessCotroller + "themes/save_part/",
			}).then(function (response) {
				$scope.removeloaddPage();
			}, function (error) {
				console.log(error);
				$scope.removeloaddPage();
			});
		}
	}
	$('#modal-edit-block').on('hidden.bs.modal', function () {
		$scope.support_key == "block";
		$scope.Iframe.$apply();
		$scope.save_block();
		$scope.notEmit = true;
		$scope.block.active = 0;
		$scope.support_key == "section";
	});
	$('#modal-review').on('show.bs.modal', function () {
		$scope.removeloaddPage();
	});
	$('#modal-review').on('hidden.bs.modal', function () {
		$scope.review = 0;
		$scope.$apply();
	});
	$('#modal-edit-part').on('hidden.bs.modal', function () {
		$scope.save_part();
		$scope.support_key == "section";
	});
	$('#modal-edit-block').on('shown.bs.modal', function () {
		$scope.support_key == "block";
	});
	$('.modal').on('show.bs.modal', function () {
		zindex++;
		$(this).css("z-index",zindex);
	});
	$('.modal').on('shown.bs.modal', function () {
		$.each($(this).find("input[sliderbootstrap]"), function () {
			$(this).sliderbootstrap("setValue", $(this).val());
		});
	});

	
	
	$scope.getposition = function (block) {
		var string = "";
		$.each(block.parts, function () {
			if (this.name == "map") {
				var meta = this.metas[0];
				var value = meta.value;
				value = JSON.parse(value.replace(/\'/g, '"'));
				string = [value.lat, value.lng];
				return false;
			}
		});
		return string;
	}
	
}).filter('trustHtml', function ($sce) {
	return function (html) {
		return $sce.trustAsHtml(html);
	}
});
App.directive('compile', ['$compile', function ($compile) {
	return function (scope, element, attrs) {
		scope.$watch(
			function (scope) {
				return scope.$eval(attrs.compile);
			},
			function (value) {
				element.html(value);
				$compile(element.contents())(scope);
			}
		);
	};
}]);
App.directive('blocks', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			element.sortable({
				connectWith: "parent",
				handle: "#move-action",
				items :"block",
				cursor: "move",
				revert: true,
				stop: function (event, ui) {
					var parent = ui.item.parent();
					var blocks = [];
					var sort = 0;
					var item = ui.item.scope();
					scope.blocks = item.$parent.section.blocks;
					var sortlist = [];
					$.each(parent.find("block"), function (k, v) {
						var ramkey = $(this).attr("ramkey");
						$.each(scope.blocks, function (k, v) {
							if (ramkey == v.ramkey) {
								v.sort = sort;
								blocks.push(v);
								sortlist.push({
									section_block_id: v.section_block_id,
									theme_section_id: v.theme_section_id
								});
								sort++;
							}
						});
					});
					scope.section = item.$parent.section;
					scope.blocks  = blocks;
					scope.section.blocks = scope.blocks;
					scope.reloadSection(scope.section);
					scope.UpdateSort("block", sortlist);
					scope.$apply();
				}
			});
			element.disableSelection();
		}
	};
});

App.directive('sectionsmenu', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			element.sortable({
				connectWith: "parent",
				cursor: "move",
				handle: "#move-action",
				revert: true,
				stop: function (event, ui) {
					var sections = [];
					var sortlist = [];
					scope.sections.order = true;
					angular.forEach(angular.element("#sections-setting ul[sectionsmenu] li"), function (value, key) {
						var ramkey = angular.element(value).attr("ramkey");
						var sort = 0;
						$.each(scope.sections, function (key, val) {
							if (val.ramkey == ramkey) {
								val.sort = sort;
								sections.push(val);
								sortlist.push({
									theme_section_id: val.theme_section_id
								});
								sort++;
							}
						});
					});
					scope.sections = sections;
					scope.UpdateSort("section", sortlist);
					$.each(scope.sections, function () {
						try {
							this.reload();
						} catch (e) {}
					});
					scope.$apply();
					scope.Iframe.$apply();
				}
			});
			element.disableSelection();
		}
	};
});
App.directive('sortablemeta', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'C',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			element.sortable({
				connectWith: "parent",
				cursor: "move",
				handle: '.is_list',
				revert: true,
				placeholder: "ui-state-highlight",
				stop: function (event, ui) {
					var parent = ui.item.parent();
					var metas = [];
					var item = ui.item.scope();
					var sortlist = [];
					var sort = 0;
					$.each(parent.find(">li"), function (k, v) {
						var ramkey = $(this).attr("ramkey");
						$.each(item.$parent.$parent.part.metas, function (k, v) {
							if (ramkey == v.ramkey) {
								v.sort = sort;
								metas.push(v);
								sortlist.push({
									meta_id: v.id,
									section_block_id: v.section_block_id,
									theme_section_id: v.theme_section_id
								});
								sort++;
							}
						});
					});
					item.$parent.$parent.part.metas = metas;
					scope.UpdateSort("meta", sortlist);
					try {
						scope.$apply();
					} catch (e) {
						console.log(e)
					}

				}
			});
			element.disableSelection();
		}
	};
});
App.directive('blocksmenu', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			element.sortable({
				connectWith: "parent",
				cursor: "move",
				handle: "#move-action-new",
				revert: true,
				stop: function (event, ui) {
					scope.section.order = true;
					var parent = ui.item.parent();
					var blocks = [];
					var sort = 0;
					var item = ui.item.scope();
					var sortlist = [];
					$.each(element.find("> li"), function (k, v) {
						var ramkey = $(this).attr("ramkey");
						$.each(scope.blocks, function (k, v) {
							if (ramkey == v.ramkey) {
								v.sort = sort;
								blocks.push(v);
								sortlist.push({
									section_block_id: v.section_block_id,
									theme_section_id: v.theme_section_id
								});
								sort++;
							}
						});
					});
					scope.blocks = blocks;
					scope.section.blocks = blocks;
					scope.UpdateSort("block", sortlist);
					scope.$apply();
				}
			});
			element.disableSelection();
		}
	};
});
App.directive('colorpicker', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			element.colorpicker({
				color: element.val(),
				defaultPalette: 'web',
				history: false,
				hideButton: true,
			});
		}
	};
});
App.directive('openfilemanager', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'AE',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			var beforchoose = function (val) {
				var type_action = element.attr("data-action");
				if (type_action == "background-image") {
					if (scope.support_key == "theme") {
						try {
							scope.theme.style["background-image"] = 'url(' + val[0].full + ')';
						} catch (e) {
							scope.theme.style = {};
							scope.theme.style["background-image"] = 'url(' + val[0].full + ')';
						}

					} else if (scope.support_key == "section") {
						try {
							scope.section.style["background-image"] = 'url(' + val[0].path + ')';
						} catch (e) {
							scope.section.style = {};
							scope.section.style["background-image"] = 'url(' + val[0].path + ')';
						}

					};
				}
				if (type_action == "sound") {
					var newsound = val[0];
					newsound.active = 1;
					newsound.start = 0;
					scope.theme.sound = newsound;
					scope.theme.sound_file = val[0].id;
					scope.theme.sound_example = 1;
				}
				if (type_action == "theme_thumb") {
					scope.theme.thumb_url = val[0].thumb;
					scope.theme.thumb = val[0].id;
				}
				if (type_action == "style_url") {
					console.log(val[0]);
					scope.theme.style_url = val[0].path + 'style.css';
					scope.theme.script_url = val[0].path + 'main.js';
					scope.theme.folder = val[0].id;
				}
				if (type_action == "effect") {
					scope.theme.effect = 1;
					scope.theme.effect_file.thumb = val[0].thumb;
					scope.theme.effect_file.path = val[0].full;
					scope.theme.effect_media_id = val[0].id;
				}
				scope.$apply();
				scope.Iframe.$apply();

			}
			var before = function () {
				$("#modal-filemanager").on("show.bs.modal", function () {
					zindex++;
					$(this).css("z-index",zindex);
				});
				this.query.max_file = element.attr("data-max");
				this.query.type_file = element.attr("data-type");
				var ext_filter = element.attr("data-exe");
				if (ext_filter) {
					this.query.ext_filter = ext_filter;
				}
				var length_medias = $(".modal #content-list .info-item").length;
				if (length_medias >= this.query.max_file && this.query.max_file > 1) {
					alert("Vui lòng chọn tối đa " + this.query.max_file + " tập tin");
					return false;
				}
				return true;
			}
			element.Scfilemanagers({
				base_url: AppAccess,
				before: before,
				beforchoose: beforchoose
			});
		}
	};
});
App.directive('openmanageformeta', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			var beforchoose = function (val) {
				var _this = this;
				if (val != null) {
					$.each(val, function (k, v) {
						v.media_id = v.id;
						v.id = 0;
						v.block_part_id = scope.part.block_part_id;
						v.meta_key = "value_media";
						v.section_block_id = scope.part.section_block_id;
						v.theme_section_id = scope.part.theme_section_id;
						if (_this.query.max_file > 1) {
							scope.part.metas.push(v);
						} else {
							v.id = scope.part.metas[0].id;
							scope.part.metas[0] = (v);
							return false;
						}
					});
				}
				scope.$apply();
			}
			var before = function () {
				$("#modal-filemanager").on("show.bs.modal", function () {
					zindex++;
					$(this).css("z-index",zindex);
				});
				$("#modal-filemanager").on("hidden.bs.modal", function () {
					if (scope.support_key == "block") {
						$("body").addClass("modal-open");
					}
				});
				var length_medias = (scope.part.metas.length);
				if (element.attr("data-max") > 1) {
					this.query.max_file = parseInt(element.attr("data-max")) - length_medias;
				} else {
					this.query.max_file = 1;
				}
				this.query.type_file = element.attr("data-type");
				var ext_filter = element.attr("data-exe");
				if (ext_filter) {
					this.query.ext_filter = ext_filter;
				}
				if (length_medias >= this.query.max_file && this.query.max_file > 1) {
					alert("Vui lòng chọn tối đa " + this.query.max_file + " tập tin");
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
App.directive('sliderbootstrap', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'AEC',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			var unit = element.attr("data-unit");
			setTimeout(function () {
				element.sliderbootstrap({
					formatter: function (value) {
						return value + unit;
					}
				});
			}, 100);
		}
	};
});
App.directive('datetime', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			try {
				element.datetimepicker('destroy');
			} catch (e) {}
			setTimeout(function () {
				element.datetimepicker({
					format: 'd/m/Y H:i',
					formatDate: 'd/m/Y H:i',
					minDate: scope._defaultday_
				});
			}, 20);
		}
	}
});
App.directive('day', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			try {
				element.datetimepicker('destroy');
			} catch (e) {}
			setTimeout(function () {
				element.datetimepicker({
					timepicker: false,
					format: 'd/m/Y',
					formatDate: 'd/m/Y',
				});
			}, 20);
		}
	}
});
App.directive('month', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			try {
				element.datetimepicker('destroy');
			} catch (e) {}
			setTimeout(function () {
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
App.directive('year', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		template: '<option ng-repeat="year in years" value="{{year}}">{{year}}</option>',
		//The link function is responsible for registering DOM listeners as well as dating the DOM.
	}
});
App.directive('hours', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			try {
				element.datetimepicker('destroy');
			} catch (e) {}
			setTimeout(function () {
				element.datetimepicker({
					datepicker: false,
					format: 'H:i',
					formatDate: 'H:i'
				});
			}, 20);
		}
	}
});

App.directive('section', ['$compile', function ($compile) {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			setTimeout(function () {
				if (element.hasClass("section-count-down")) {
					this.index = parseInt(element.attr("data-index"));
					this.section = scope.sections[this.index];
					var time = element.find(".block-count-down metadatas metadata").attr("data-value");
					var datimeElement = element.find(".block-count-down metadatas metadata");
					var b_key = parseInt(datimeElement.closest("block").attr("data-index"));
					var p_key = parseInt(datimeElement.closest("part").attr("data-index"));
					var m_key = parseInt(datimeElement.attr("data-index"));
					try {
						try {
							element.find("#content-section .wrapper-section .block-count-down .wrapper-block #countdown").countdown('destroy');
						} catch (e) {}
						this.section.blocks[b_key].parts[p_key].metas[m_key].reload = function () {
							time = element.find(".block-count-down metadatas metadata").attr("data-value");
							var t = time.toDate("dd/mm/yyyy hh:ii");
							var datetime = new Date(t);
							element.find("#content-section .wrapper-section .block-count-down .wrapper-block #countdown").countdown(datetime, function (event) {
								var month = event.strftime('%-m');
								var year = event.strftime('%-y');
								var string = "";
								if (parseInt(year) > 0) string += event.strftime('<div class="item"><span class="number">%-y</span><span class="text">Năm</span></div>');
								if (parseInt(month) > 0)
									string += event.strftime('<div class="item"><span class="number">%-m</span><span class="text">Tháng</span></div>');
								string += event.strftime('' +
									'<div class="item"><span class="number">%-n</span> <span class="text">Ngày</span></div>' +
									'<div class="item"><span class="number">%H</span> <span class="text">Giờ</span></div>' +
									'<div class="item"><span class="number">%M</span> <span class="text">Phút</span></div>' +
									'<div class="item"><span class="number">%S</span> <span class="text">Giây</span></div>'
								);
								var $this = $(this).html(string);
							});
						}
					} catch (e) {}
					var html = '<div ng-if="mode > 0" id ="countdown"></div>';
					var t = time.toDate("dd/mm/yyyy hh:ii");
					var datetime = new Date(t);
					element.find("#content-section .wrapper-section .block-count-down .wrapper-block").append(html);
					element.find("#content-section .wrapper-section .block-count-down .wrapper-block #countdown").countdown(datetime, function (event) {
						var month = event.strftime('%-m');
						var year = event.strftime('%-y');
						var string = "";
						if (parseInt(year) > 0) string += event.strftime('<div class="item"><span class="number">%-y</span><span class="text">Năm</span></div>');
						if (parseInt(month) > 0)
							string += event.strftime('<div class="item"><span class="number">%m</span><span class="text">Tháng</span></div>');
						string += event.strftime('' +
							'<div class="item"><span class="number">%-n</span> <span class="text">Ngày</span></div>' +
							'<div class="item"><span class="number">%H</span> <span class="text">Giờ</span></div>' +
							'<div class="item"><span class="number">%M</span> <span class="text">Phút</span></div>' +
							'<div class="item"><span class="number">%S</span> <span class="text">Giây</span></div>'
						);
						var $this = $(this).html(string);
					});
				}

			}, 20);
		}
	}
}]);
App.directive('uploads', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			element.click(function () {
				var type = element.attr("data-type");
				var max = element.attr("data-max");
				var action = element.attr("data-action");
				var current = null;
				if (parseInt(max) > 1) {
					current = scope.uploads;
				} else {
					current = scope.upload;
				}
				current.attr("accept", type + "/*");
				current.attr("data-max", max);
				current.attr("data-action", action);
				current.trigger("click");
				var index = element.parents("data-index");
			});
		}
	}
});
App.directive('parts', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			element.find("> div").sortable({
				connectWith: "parent",
				handle: "#move-action-part",
				cursor: "move",
				revert: true,
				stop: function (event, ui) {
					var parent = ui.item.parent();
					var parts = [];
					var sort = 0;
					var item = ui.item.scope();
					scope.parts = item.$parent.block.parts;
					var sortlist = [];
					$.each(parent.find("part"), function (k, v) {
						var ramkey = $(this).attr("ramkey");
						$.each(scope.parts, function (k, v) {
							if (ramkey == v.ramkey) {
								v.sort = sort;
								parts.push(v);
								sortlist.push({
									block_part_id: v.block_part_id,
									section_block_id: v.section_block_id,
									theme_section_id: v.theme_section_id
								});
								sort++;
							}
						});
					});
					scope.parts = parts;
					scope.block.parts = parts;
					scope.UpdateSort("part", sortlist);
					scope.$apply();
				}
			});
			element.disableSelection();
		}
	};
});
App.directive('metadata', ['$window', function ($window) {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		tempale: '',
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			angular.element($window).bind('resize', function () {
				if ($window.innerWidth > 768) {
					scope.scaleWidth = scope.defaultContent / $window.innerWidth;
					$.each(element.find("span"), function () {
						var f = ($(this).css("font-size"));
						f = f.replace("px");
						f = parseInt(f);
						if (f >= 40) {
							f = f / scope.scaleWidth;
							$(this).css("font-size", f + "px");
						}
					});
				}
			});
		}
	}
}]);

function tinymce_updateCharCounter(el, len) {
	$('#' + el.id).prev().find('.char_count').text(len + '/' + el.settings.max_chars);
}

function tinymce_getContentLength() {
	return tinymce.get(tinymce.activeEditor.id).contentDocument.body.innerText.length;
}
App.directive('editor', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			var _this = this;
			try {
				element.tinymce().remove();
			} catch (e) {

			}
			setTimeout(function () {
				_this.maxchar = parseInt(element.attr("data-length"));
				_this.current = $("#" + element.attr("id"));
				_this.idCurrent = "#" + element.attr("id");
				_this.oldContent = _this.current.val();
				_this.css = "";
				_this.height = 250;
				_this.height = _this.maxchar == 100 ? 70 : 250;
				_this.editor = tinymce.init({
					selector: _this.idCurrent,
					max_chars: _this.maxchar,
					valid_elements: "p[style],span[style],strong,b,i,em,a[href|target=_blank]",
					setup: function (ed) {
						var allowedKeys = [20, 16, 17, 9, 8, 37, 38, 39, 40, 46]; // backspace, delete and cursor keys
						ed.on('KeyDown', function (e) {
							if (allowedKeys.indexOf(e.keyCode) == -1) {
								if ((tinymce_getContentLength()) > this.settings.max_chars - 1) {
									e.stopPropagation();
									e.preventDefault();
									return false;
								}
							}
							$("#" + this.id).val(tinyMCE.activeEditor.getContent());
							$("#" + this.id).trigger("change");
							_this.oldContent = tinyMCE.activeEditor.getContent();
							tinymce_updateCharCounter(this, tinymce_getContentLength());
						});
						ed.on('KeyUp', function (e) {
							$("#" + this.id).val(tinyMCE.activeEditor.getContent());
							$("#" + this.id).trigger("change");
							_this.oldContent = tinyMCE.activeEditor.getContent();
							tinymce_updateCharCounter(this, tinymce_getContentLength());
						});
						ed.on('change', function (e) {
							$("#" + this.id).val(tinyMCE.activeEditor.getContent());
							$("#" + this.id).trigger("change");
							_this.oldContent = tinyMCE.activeEditor.getContent();
							tinymce_updateCharCounter(this, tinymce_getContentLength());
						});
						ed.on('Undo', function (e) {
							$("#" + this.id).val(tinyMCE.activeEditor.getContent());
							$("#" + this.id).trigger("change");
							_this.oldContent = tinyMCE.activeEditor.getContent();
							tinymce_updateCharCounter(this, tinymce_getContentLength());
						});
						ed.on('Redo', function (e) {
							$("#" + this.id).val(tinyMCE.activeEditor.getContent());
							$("#" + this.id).trigger("change");
							_this.oldContent = tinyMCE.activeEditor.getContent();
							tinymce_updateCharCounter(this, tinymce_getContentLength());
						});
						ed.on('Paste', function (e) {
							var _thisNote = this;
							_this.oldContent = tinyMCE.activeEditor.getContent();
							setTimeout(function () {
								if ((tinymce_getContentLength()) > _thisNote.settings.max_chars) {
									tinyMCE.activeEditor.undoManager.undo();
									alert("Vui lòng nhập nhiều nhất " + _thisNote.settings.max_chars + " kí tự");
								}
							}, 300);
						});
					},
					init_instance_callback: function () { // initialize counter div
						$('#' + this.id).prev().append('<div class="char_count" style="text-align:right"></div>');
						tinymce_updateCharCounter(this, tinymce_getContentLength());
					},
					menubar: false,
					content_css: scope.theme.style_url + ',' + AppAccessSkin + 'skins/css/editor-style.css',
					content_style: _this.css,
					plugins: [
						'textcolor',
						'code',
						'colorpicker',
						'lineheight',
						'advlist autolink lists link image charmap print preview anchor ',
					],
					contextmenu: false,
					toolbar: 'fontsizeselect fontselect | bold italic | lineheightselect | forecolor alignleft aligncenter alignright alignjustify | link | code',
					font_formats: _ScriptThemeCongif_.fonts + _ScriptThemeCongif_.setting_fonts,
					fontsize_formats: scope.font_size.trim(),
					lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 30pt 32pt 34pt 36pt",
					mode: "exact",
					height: _this.height,
				});
			}, 100);
		}
	}
});
App.directive('effictelent', function () {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function (scope, element, attrs) {
			var thumb = scope.theme.effect_file.thumb ? scope.theme.effect_file.thumb : "/uploads/source/imgeffect/start-59eef88a17c0f.png";
			var minSize = scope.theme.effect_file.minsize ? scope.theme.effect_file.minsize : 10;
			var maxSize = scope.theme.effect_file.maxsize ? scope.theme.effect_file.maxsize : 40;
			var newOn = scope.theme.effect_file.onnew ? scope.theme.effect_file.onnew : 800;
			$.fn.snow({
				element: element,
				minSize: parseInt(minSize),
				maxSize: parseInt(maxSize),
				newOn: parseInt(newOn),
				flakeColor: '#fff',
				html: '<img src="' + thumb + '">'
			});
		}
	}
});
 
App.directive('iframeOnload',function(){
	return {
	    scope: {
	        callBack: '&iframeOnload'
	    },
	    link: function(scope, element, attrs){
	        element.on('load', function(){
	            return scope.callBack();
	        })
	    }
	}
});
App.directive('partmap', function () {
  return {
    restrict: 'A',
    template: `<ng-map zoom="8" map-initialized="initializedMap(map)" style="height:500px">
    			<marker on-dragend="getCurrentLocation(marker)" draggable="true" position="{{block.position}}"></marker>
    		</ng-map>`,
    replace: false,
    //The link function is responsible for registering DOM listeners as well as updating the DOM.
    link: function (scope, element, attrs) {
      scope.getCurrentLocation = function (marker) {
        scope.part.metas[0].value = "{'lat' : " + marker.latLng.lat() + ",'lng' : " + marker.latLng.lng() + "}";
        scope.block.position = [marker.latLng.lat(), marker.latLng.lng()];
        scope.$apply();
      }
      scope.initializedMap = function (map) {
      	try{
      		var position = new google.maps.LatLng(scope.block.position[0],scope.block.position[1]);
      		map.setCenter(position);
      	}catch(e){

      	}
        setTimeout(function () {
          google.maps.event.trigger(map, "resize");
        }, 1000);
        element.prepend('<div class="form-group"><input type="text" name="class_name" class="form-control" id="search-places" value="" placeholder="Enter the place you want to find"></div>');
        var search = element.find("#search-places")[0];
        var autocomplete = new google.maps.places.Autocomplete(search, {
          types: ['geocode']
        });
        autocomplete.bindTo('bounds', map);
        autocomplete.addListener('place_changed', function () {
          var place = this.getPlace();
          if (!place.geometry) {
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }
          if (place.geometry.viewport) {
            scope.map.fitBounds(place.geometry.viewport);
          } else {
            scope.map.setCenter(place.geometry.location);
          }
          scope.part.metas[0].value = JSON.stringify(place.geometry.location);
          scope.block.position = [place.geometry.location.lat(), place.geometry.location.lng()];
          scope.$apply();
        });
      }
    }
  };
});