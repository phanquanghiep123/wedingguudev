var geolocation = {
	lat: 21.028511,
	lng: 105.804817
};
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
	var key_update = 0;
	var callserver = 0;
	$scope.theme = {};
	$scope.theme.id = ThemeID;
	$scope.theme.ramkey = Ramkey;
	$scope.mode_class = "view-page";
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
	$scope.mode = 1;
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
	var tag_audio = new Audio();
	var currentAction = false;
	$scope.support_key = "theme";
	var zindex = 100;
	var current_key = 0;
	$scope.background_repeat = ["repeat", "repeat-x", "repeat-y", "no-repeat", "initial", "inherit"];
	$scope.background_size = ["auto", "cover", "contain", "initial", "inherit"];
	$scope.backgroundType = [{
		name: "Chọn ảnh",
		"id": "0"
	}, {
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
	$scope.$watch('theme.sound', function() {
		if ($scope.theme.sound == null) {
			tag_audio.pause();
		}
		if($scope.theme.sound != null)
			$scope.theme.sound_file = $scope.theme.sound.media_id;
	}, true);
	//sidebar.
	$scope.actionschange = [{
			id: 0,
			value: "colonnade",
			name: "Bố cục",
			active: 0
		},
		/*{
			id: 1,
			value: "adjustment view-page",
			name: "Tuy chỉnh",
			active: 0
		},*/
		{
			id: 1,
			value: "view-page",
			name: "Xem trang",
			active: 1
		}
	]
	$scope.menus = [{
			name: "Chế chỉnh sửa",
			id: "page-change",
			controller: "SidebarChange"
		},
		{
			name: "Nền trang",
			id: "page-background",
			controller: "SidebarBackground"
		},
		{
			name: "Phông chữ",
			id: "page-font",
			controller: "SidebarFont"
		},
		{
			name: "Nhạc nền",
			id: "page-sound",
			controller: "SidebarSound"
		},
		{
			name: "Hiệu ứng",
			id: "page-effect",
			controller: "SidebarEffect"
		},
		{
			name: "Chọn style file",
			id: "page-style",
			controller: "SidebarParts"
		},
		{
			name: "Thông tin theme",
			id: "page-info",
			controller: "SidebarParts"
		}
	];
	//get pramater_server 
	$scope.initPage = function(){
		if(callserver == 0){
			console.log("---initPage-----");
			$http({
				method         : "POST",
				responseType   : "json",
				url: AppAccessCotroller + "themes/themes/get_pramater_server"
			}).then(function(response) {
				$scope.SVsections = response.data.sections;
				$scope.SVblocks   = response.data.blocks;
				$scope.SVparts    = response.data.parts;
				console.log("ok");
			}, function(error) {
				console.log(error);
			});
			//!get pramater_server 
			//get sounds 
			$http({
				method         : "POST",
				responseType   : "json",
				url: AppAccessCotroller + "themes/themes/get_groups_backgrounds_sounds"
			}).then(function(response) {
				$scope.group_backgrounds = response.data.backgrounds;
				$scope.group_sounds = response.data.sounds;
				console.log("ok");
			}, function(error) {
				console.log(error);
			});
			//!get sounds 
			//get font 
			$http({
				method       : "POST",
				responseType : "json",
				url: AppAccessCotroller + "themes/themes/get_fonts"
			}).then(function(response) {
				$scope.fonts = response.data;
				console.log("ok");
			}, function(error) {
				console.log(error);
			});	
			//!get font 
			//get section
			$http({
				method: "POST",
				responseType: "json",
				data: {id : $scope.theme.id},
				url: AppAccessCotroller + "themes/themes/get_section/" + $scope.theme.id
			}).then(function(response) {
				$scope.sections = response.data.sections;
				$scope.theme = response.data.theme;
				console.log("ok");
			}, function(error) {
				console.log(error);
				location.reload();
			});
			//!get section;
			console.log("!---initPage-----");
		}
		callserver = 1;	
	}
	$scope.initPage();	
	callserver = 1;
	$scope.blockShow = function(section){
		if($scope.mode == 0) return true;
		if(this.block.id == section.default_block){
			return false;
		} 
		else return true;
	}
	$scope.checkaction = function() {
		if ($scope.actionChangeCurrent = this.action.value) {
			this.action.check = true;
		}
	}
	$scope.getContentmenu = function(item) {
		$scope.support_key = "theme";
		$scope.action_name = item.name;
		item.load = 1;
		$http({
			method: "POST",
			responseType : "text",
			data: {
				template: item.id,
				theme_id: $scope.theme.id
			},
			url: AppAccessCotroller + "themes/themes/get_template_by_sidebar"
		}).then(function(response) {
			$scope.action_body = response.data;
			item.load = 0;
			$("#sidebar-actions").css("z-index", zindex);
			zindex++;
			$("#sidebar-actions").addClass("open");
		}, function(error) {
			console.log(error);
			item.load = 0;
		});
		return false;
	}
	$scope.getBackgrounds = function(group) {
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
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		group.load = 0;
		return false;
	}
	$scope.AddItem = function() {
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
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
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
				theme_id    : $scope.theme.id
			},
			url: AppAccessCotroller + "themes/themes/addsection"
		}).then(function(response) {
			console.log(response.data);
			$scope.section = (response.data);
			$scope.sections.push(response.data);
			svsection.load = 0;
		}, function(error) {
			console.log(error);
			svsection.load = 0;
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
			url: AppAccessCotroller + "themes/themes/addblock"
		}).then(function(response) {	
			$scope.block = (response.data);
			$scope.blocks.push(response.data);
			try {
				$('html').animate({
					scrollTop: $('block[ramkey=' + $scope.block.ramkey + ']').offset().top 
				}, 400);	
			} catch (r) {}
			svblock.load = 0;
			setTimeout(function(){
				$scope.support_key == "section";
			},500);
		}, function(error) {
			svblock.load = 0;
		});
	}
	$scope.PartAddNow = function(svpart) {
		svpart.load = 1;
		$http({
			method: "POST",
			responseType : "json",
			data: {
				part             : svpart,
				block_id         : $scope.block.id,
				sort             : $scope.block.parts.length,
				section_block_id : $scope.block.section_block_id,
				theme_section_id : $scope.section.theme_section_id
			},
			url: AppAccessCotroller + "themes/themes/addpart"
		}).then(function(response) {
			$scope.part = (response.data); 
			$scope.parts.push(response.data);
			svpart.load = 0;
		}, function(error) {
			console.log(error);
			svpart.load = 0;
		});
	}
	$scope.ChangeSackgroundSection = function() {
		$("#sidebar-chang-style-section").css("z-index", zindex);
		zindex++;
		$scope.is_changeSectionStyle = true;
	}
	$scope.RemoveSound = function() {
		$.each($scope.sounds, function() {
			this.active = 0;
		});
		$scope.theme.sound = false;
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
			$scope.single_body = "<ul class=\"nav-list-items list_category\"><li openfilemanager href=\"javascript:;\" class=\"ui-button-text\" data-action=\"background-image\" data-type=\"image\" data-max=\"1\" id=\"openFilemanager\"> Mở thư viện file</li><li uploadfile>Tải ảnh lên</li> </ul>";
		} else {
			$scope.single_body ="<ul class=\"nav-list-items list_category\"><li ng-class=\"(group.load == 1) ? loadding:''\" ng-repeat=\"group in group_backgrounds\" ng-click=\"getBackgrounds(group)\" class=\"item\" id=\"{{group.id}}\">{{group.name}}</li></ul>";
		}
		$("#sidebar-single").css("z-index", zindex);
		zindex++;
		$("#sidebar-single").addClass("open");
		type.load = 0;
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
		action.active = 1;
		$scope.mode_class = action.value;
	}
	$scope.Ftabbackgroundimage = function($v) {
		$scope.tabbackgroundimage = $v;
	}
	$scope.CloseActions = function() {
		$("#sidebar-actions").removeClass("open");
	}
	$scope.CloseSingle = function() {
		$("#sidebar-single").removeClass("open");
	}
	$scope.CloseChosse = function() {
		$("#sidebar-chosse").removeClass("open");
		return false;
	}
	$scope.ToSection = function() {
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
	$scope.ToBlock = function(block) {
		$scope.support_key = "block";
		$scope.block = this.block;
		$scope.BlockEdit(this.block, this.$parent.section);
		return false;
	}
	
	$scope.ConvertStype = function(){
		if($scope.mode != 0){
			var style = "";
			$.each(this.section.style,function(k,v){
				if(v != null)
				{
					style += (k +" : " + v + ";") ;
				}
			});
			return style;
		}else{
			return '';
		}
	}
	
	//content.
	
	$scope.MetaShow = function(meta, part) {
		//meta show
		var show_html = part.html_show;
		var list_show = part.list_show;
		var stringR;
		if (meta.media_id != 0 && meta.meta_key =="value_media") {
			stringR = list_show.replace("{{value}}", AppAccess + meta.thumb).replace("{{media_id}}", "{{meta.media_id}}");
		} else {
			meta.value = $("<div>" + meta.value + "</div>");
			meta.value = meta.value.html();
			stringR = list_show.replace("{{value}}", meta.value);
		}
		show_html = stringR;
		meta.show = show_html;
		return stringR;
	}
	$scope.Show_Title = function(val) {
		if (val == 1 || $scope.mode == 0) return true;
		else return false;
	}
	$scope.SectionEdit = function(section) {
		$("#sidebar-section").removeClass("open");
		$scope.support_key = "section";
		$scope.section = section;
		$scope.blocks = section.blocks;
		$scope.taggetTab = 0;
		$("#sidebar-section").css("z-index", zindex);
		zindex++;
		$("#sidebar-section").addClass("open");
		return false;
	}
	$scope.SectionDelete = function($index) {
		current_key  = $index;
		$scope.section = this.section;
		$scope.support_key = 'section';
		$("#modal-delete-item").modal();
		return false;
	}
	$scope.SectionAdd = function(section) {
		$scope.support_key = "section";
		$scope.section = section;
		$scope.blocks = section.blocks;
		$scope.AddItem();
		return false;
	}
	$scope.BlockEdit = function(block, section) {
		$scope.support_key = "block";
		$scope.block = block;
		$scope.parts = block.parts;
		$scope.section = section;
		console.log($scope.block);
		$("#modal-edit-block").modal();
		return false;
	}
	$scope.BlockDelete = function($index, blocks) {
		$scope.blocks = blocks;
		$scope.block = this.block;
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
		var html_edit = $scope.part.html_edit;
		var form_edit = html_edit.replace("{{value}}", "");
		if (meta["meta_key"] == "value_text") {
			var s = $('<div>' + form_edit + '</div>');
			s.find('[name="value_text"]').attr("ng-model", "meta.value");
		} else {
			return form_edit;
		}
		return s.html();
	}
	$scope.ValueForm = function(meta) {
		var list_show = $scope.part.list_show;
		var form_edit;
		if (meta["meta_key"] != "value_text") {
			if (meta["meta_key"] == "value_media") {
				form_edit = list_show.replace("{{value}}", "{{meta.thumb}}").replace("{{media_id}}", "{{meta.media_id}}");
			} else if (meta["meta_key"] == "map_point") {
				form_edit = list_show.replace("{{value}}", "");
				var s = $('<div>' + form_edit + '</div>');
				s.find('[name^="map_point"]').attr("ng-model", "meta.value");
				form_edit = s.html();
			}
		}
		return form_edit;
	}
	$scope.PartEdit = function(part) {
		$scope.part = part;
		$scope.metas = $scope.part.metas;
		$scope.support_key = "part";
		$("#modal-edit-part").modal();
		return false;
	}
	$scope.DeleteItem = function ($index){
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
		}else if($scope.support_key == "part"){
			data  = {
				block_part_id    : $scope.part.block_part_id,
				theme_section_id : $scope.part.theme_section_id,
				section_block_id : $scope.part.section_block_id
			};
			$scope.parts.splice(current_key, 1);
		}
		if(data != null){
			console.log(data);
			$http({
				method : "POST",
				responseType : "json",
				data : {item : data},
				url  : AppAccessCotroller + "themes/themes/deleteitem/" + $scope.support_key,
			}).then(function(response) {
				removeloadding($e);
				console.log(response);
				$("#modal-delete-item").modal("hide");
			}, function(error) {
				removeloadding($e);
				console.log(error);
				//$scope.Public($e);
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
	$scope.binevent = function(marker, map, infowindow, geocoder) {
		marker.addListener('click', function() {
			var _this = this;
			infowindow.close();
			geocoder.geocode({
				'latLng': {
					lat: this.position.lat(),
					lng: this.position.lng()
				}
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results.length > 0) {
						infowindow.setContent(results[0].formatted_address);
					} else {
						infowindow.setContent("Not found");
					}
					infowindow.open(map, _this);
				}
			});
			if (_this.getAnimation() !== null) {
				_this.setAnimation(null);
			} else {
				_this.setAnimation(google.maps.Animation.BOUNCE);
			}
			map.setCenter({
				lat: _this.position.lat(),
				lng: _this.position.lng()
			});
		});
		marker.addListener('dragend', function(event) {
			var latlng = {
				lat: event.latLng.lat(),
				lng: event.latLng.lng()
			}
			var index = this.index_meta;
			var meta = $scope.metas[index];
			if (meta) {
				$scope.metas[index].value = JSON.stringify(latlng);
			}
			var _this = this;
			infowindow.close();
			geocoder.geocode({
				'latLng': latlng
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results.length > 0) {
						infowindow.setContent(results[0].formatted_address);
					} else {
						infowindow.setContent("Not found");
					}
					infowindow.open(map, _this);
				}
			});
		});
	}
	
	$scope.Public = function ($e = null){
		if($e == null){
			$e = $(".save-box-left");
		}
		loadding($e);
		$http({
			method : "POST",
			responseType : "json",
			data : {
				id 			: $scope.theme.id,
				name 		: $scope.theme.name,
				description : $scope.theme.description,
				thumb 		: $scope.theme.thumb,
				font_file   : $scope.theme.font_file,
				folder      : $scope.theme.folder,
				sound_file  : $scope.theme.sound_file,
				size_title  : $scope.theme.size_title,
				color_title : $scope.theme.color_title,
				color_title : $scope.theme.color_title,
				public      : $scope.theme.public,
				style       : $scope.theme.style,
			},
			url  : AppAccessCotroller + "themes/themes/save_theme/",
		}).then(function(response) {
			removeloadding($e);
			console.log("ok");
		}, function(error) {
			removeloadding($e);
			console.log(error);
		});
	}	
	$scope.save_part = function(){
		if($scope.support_key == "part"){
			console.log($scope.part);
			try{
				if($("#modal-edit-part textarea[ng-model='meta.value']").length > 0){
					var content = $("#modal-edit-part textarea[ng-model='meta.value']").val();
					$scope.part.metas[0].value = content;
				}	
			}catch(e){

			}
			$http({
				method: "POST",
				responseType: "json",
				data: {
					actions          : $scope.part.actions,
					class_name       : $scope.part.class_name,
					ncolum           : $scope.part.ncolum,
					block_part_id    : $scope.part.block_part_id,
					section_block_id : $scope.part.section_block_id,
					theme_section_id : $scope.part.theme_section_id,
					metas            : $scope.part.metas,
					sort             : $scope.part.sort,
				},
				url  : AppAccessCotroller + "themes/themes/save_part/",
			}).then(function(response) {
				console.log("ok");
			}, function(error) {
				console.log(error);
				//$scope.save_part();
			});
		}
	}
	$scope.save_block = function(){
		if($scope.support_key == "block"){
			console.log( $scope.block);
			$http({
				method: "POST",
				responseType: "json",
				data: {
					actions          : $scope.block.actions,
					class_name       : $scope.block.class_name,
					ncolum           : $scope.block.ncolum,
					section_block_id : $scope.block.section_block_id,
					theme_section_id : $scope.block.theme_section_id
				},
				url  : AppAccessCotroller + "themes/themes/save_block/",
			}).then(function(response) {
				console.log(response.data);
				console.log("ok");
			}, function(error) {
				console.log(error);
				//$scope.save_block();
			});
		}
	}
	$scope.save_section = function(){
		if($scope.support_key == "section"){
			console.log($scope.section);
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
				url  : AppAccessCotroller + "themes/themes/save_section/",
			}).then(function(response) {
				console.log("ok");
			}, function(error) {
				console.log(error);
			});	
		}
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
		console.log($list);
		$http({
			method: "POST",
			responseType: "json",
			data : {list : $list},
			url  : AppAccessCotroller + "themes/themes/updatesort/" + $type,
		}).then(function(response) {
			console.log("ok");
		}, function(error) {
			console.log(error);
		});
	}
	$('#modal-edit-block').on('hidden.bs.modal', function () {
		$scope.save_block();
		$scope.support_key == "section";
	});
	$('.modal').on('shown.bs.modal', function () {
		$.each($(this).find("input[sliderbootstrap]"),function(){
			$(this).sliderbootstrap("setValue",$(this).val());
		});
	});
	$('#modal-edit-part').on('hidden.bs.modal', function () {
		$scope.save_part();
		$scope.support_key == "section";
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
App.directive('parts', function() {
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
					var parts = [];
					var sort = 0;
					var item = ui.item.scope();
					scope.parts = item.$parent.block.parts;
					var sortlist = [];
					$.each(parent.find("part"), function(k, v) {
						var ramkey = $(this).attr("ramkey");
						$.each(scope.parts, function(k, v) {
							if (ramkey == v.ramkey) {
								v.sort = sort;
								parts.push(v);
								sortlist.push({
									block_part_id    : v.block_part_id,
									section_block_id : v.section_block_id ,
									theme_section_id : v.theme_section_id
								});
								sort++;
							}
						});
					});
					scope.parts = parts;
					scope.block.parts = parts;
					scope.UpdateSort("part",sortlist);
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
			markers = [];
			var mapdiv = element[0];
			var multiple = parseInt(element.attr("max-map")) > 1 ? 1 : 0;
			var infowindow = new google.maps.InfoWindow();
			google.maps.event.addListener(infowindow, 'closeclick', function() {
				$.each(markers, function(k, v) {
					try {
						if (infowindow.position.lat() == v.position.lat() && infowindow.position.lng() == v.position.lng()) {
							v.setMap(null);
							markers.splice(k, 1);
							return false;
						}
					} catch (e) {}
				});
			});
			var geocoder = new google.maps.Geocoder();
			element.parent().parent().prepend(
				'<div class="form-group"><input type="text" name="class_name" class="form-control" id="search-places" value="" placeholder="Enter the place you want to find"></div>'
			);
			var search = element.parent().parent().find("#search-places")[0];
			var geocoder = new google.maps.Geocoder();
			var map = new google.maps.Map(mapdiv, {
				zoom: 6,
			});
			var marker = new google.maps.Marker({
				position: geolocation,
				map: map,
				visible: false,
				draggable: true
			});
			if (multiple == 1) {
				$.each(scope.metas, function(k, v) {
					var vold = v.value.replace(/\'/g, '"');
					try {
						var obj = JSON.parse(vold);
						var mk = new google.maps.Marker({
							position: obj,
							map: map,
							visible: true,
							draggable: true
						});
						mk.index_meta = k;
						scope.binevent(mk, map, infowindow, geocoder);
						markers.push(mk);
					} catch (e) {
						console.log(e);
					}
				});
			} else {
				var vold = scope.meta.value.replace(/\'/g, '"');
				try {
					var obj = JSON.parse(vold);
					marker.index_meta = 0;
					marker.setPosition(obj);
					marker.setVisible(true);
					map.setCenter(obj);
					scope.binevent(marker, map, infowindow, geocoder);
					markers.push(marker);
				} catch (e) {console.log(e);}
			}
			setTimeout(function() {
				google.maps.event.trigger(map, "resize");
				map.setCenter(geolocation);
			}, 200);
			var autocomplete = new google.maps.places.Autocomplete(search, {
				types: ['geocode']
			});
			autocomplete.bindTo('bounds', map);
			map.addListener('click', function(event) {
				var length = scope.metas.length;
				infowindow.close();
				if (multiple == 1) {
					var mk = new google.maps.Marker({
						map: map,
						position: event.latLng,
						visible: true,
						draggable: true,
						index_meta: length
					});
					scope.metas.push({
						block_part_id: scope.part.block_part_id,
						created_at: null,
						dir_folder: null,
						extension: null,
						folder_id: null,
						full: null,
						id: 0,
						is_delete: null,
						is_root: null,
						large: null,
						media_id: null,
						medium: null,
						member_id: null,
						meta_key: "map_point",
						name: null,
						path: null,
						path_folder: null,
						section_block_id: scope.part.section_block_id,
						size: null,
						small: null,
						status: null,
						theme_section_id: scope.part.theme_section_id,
						thumb: null,
						type_id: null,
						updated_at: null,
						value: JSON.stringify(event.latLng)
					});
					map.setCenter(event.latLng);
					geocoder.geocode({
						'latLng': event.latLng
					}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							if (results.length > 0) {
								infowindow.setContent(results[0].formatted_address);
							} else {
								infowindow.setContent("Not found");
							}
							infowindow.open(map, mk);
						}
					});
					markers.push(mk);
					scope.binevent(mk, map, infowindow, geocoder);
				} else {
					marker.setPosition(event.latLng);
					marker.setVisible(true);
					geocoder.geocode({
						'latLng': event.latLng
					}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							if (results.length > 0) {
								infowindow.setContent(results[0].formatted_address);
							} else {
								infowindow.setContent("Not found");
							}
							infowindow.open(map, marker);
						}
					});
					if (markers.length == 0) {
						markers.push(marker);
					}
					scope.binevent(marker, map, infowindow, geocoder);
				}
			});
			autocomplete.addListener('place_changed', function() {
				infowindow.close();
				var place = autocomplete.getPlace();
				if (!place.geometry) {
					window.alert("No details available for input: '" + place.name + "'");
					return;
				}
				if (place.geometry.viewport) {
					map.fitBounds(place.geometry.viewport);
				} else {
					map.setCenter(place.geometry.location);
				}
				infowindow.setContent(place.formatted_address);
				if (multiple == 1) {
					var length = scope.metas.length;
					var mk = new google.maps.Marker({
						map: map,
						position: place.geometry.location,
						visible: true,
						draggable: true,
						index_meta: length
					});
					scope.metas.push({
						block_part_id: scope.part.block_part_id,
						created_at: null,
						dir_folder: null,
						extension: null,
						folder_id: null,
						full: null,
						id: 0,
						is_delete: null,
						is_root: null,
						large: null,
						media_id: null,
						medium: null,
						member_id: null,
						meta_key: "map_point",
						name: null,
						path: null,
						path_folder: null,
						section_block_id: scope.part.section_block_id,
						size: null,
						small: null,
						status: null,
						theme_section_id: scope.part.theme_section_id,
						thumb: null,
						type_id: null,
						updated_at: null,
						value: JSON.stringify(event.latLng)
					});
					scope.binevent(mk, map, infowindow, geocoder);
					markers.push(mk);
					infowindow.open(map, mk);
				} else {
					marker.setPosition(place.geometry.location);
					marker.setVisible(true);
					if (markers.length == 0) {
						markers.push(markers);
					}
					infowindow.open(map, marker);
				}
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
					scope.$apply();
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
					var blocks = [];
					var sortlist = [];
					angular.forEach(angular.element("#section-blocks ul[blocksmenu] li"), function(value, key) {
						var ramkey = angular.element(value).attr("ramkey");
						var sort = 0;
						$.each(scope.section.blocks, function(key, val) {
							if (val.ramkey == ramkey) {
								val.sort = sort;
								blocks.push(val);
								sortlist.push({
									section_block_id : val.section_block_id ,
									theme_section_id : val.theme_section_id
								});
								sort++;
							}
						});
					});
					scope.section.blocks = blocks;
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
					scope.theme.sound_file = newsound.media_id;
				}
				if (type_action == "theme_thumb") {
					scope.theme.thumb_url = val[0].thumb;
					scope.theme.thumb = val[0].id;
				}
				if (type_action == "style_url") {
					scope.theme.style_url  = val[0].path + 'style.css';
					scope.theme.folder     = val[0].id;
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
					alert("Please select up to " + this.query.max_file + " media file");
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
				var metas = [];
				if (val != null) {
					$.each(val, function(k, v) {
						v.media_id = v.id;
						v.id = 0;
						var meta = v;
						meta.block_part_id    = scope.part.block_part_id;
						meta.meta_key         = "value_media";
						meta.section_block_id = scope.part.section_block_id;
						meta.theme_section_id = scope.part.theme_section_id;
						metas.push(meta);
					});
					scope.metas = metas;
					scope.part.metas = scope.metas;
					scope.PartEdit(scope.part);
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
					alert("Please select up to " + this.query.max_file + " media file");
					return false;
				}
				return true;
			}
			element.Scfilemanagers({
				base_url: AppAccess,
				before: before,
				beforchoose: beforchoose,
				after: function() {
					$("body").addClass("modal-open");
				}
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
App.directive('editer', function() {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'A',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			try {
				element.tinymce().remove();
			} catch (e) {}
			setTimeout(function() {
				element.tinymce({
					height: 300,
					menubar: false,
					plugins: [
						'advlist autolink lists link image charmap print preview anchor',
						'searchreplace visualblocks code fullscreen',
						'insertdatetime media table contextmenu paste code'
					],
					toolbar: ' styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				});
			}, 20);
		}
	}
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
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			try {
				element.datetimepicker('destroy');
			} catch (e) {}
			setTimeout(function() {
				element.datetimepicker({
					timepicker: false,
					format: 'Y',
					formatDate: 'Y',
					viewMode: "years",
					minViewMode: "years"
				});
			}, 20);
		}
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
App.directive('defaultblock',  ['$compile', function($compile) {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		scope: {
			slideit: '='
		},
		 replace: false,
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {	
			try {
				element.reloadSlider();
			}catch(e){
				element.ready(function() {
					setTimeout(function(){
						var type = element.attr("data-type");
						if(type == "section-the-groom-meber" || type == "section-the-bridesmaid-member" || type == "section-albums-wedding"){
							var item = element.attr("data-item");
							var lenght_item  = element.find("block").length;
							item = parseInt(item);
							//element.find("block").css({width : 100/item + "%" });
							if (lenght_item < item){item = lenght_item;}
							element.bxSlider({
								minSlides  : item,
								maxSlides  : item,
								slideWidth : 1175/item,
								pager      : false,
								controls   : true,
								auto       : true,
								infiniteLoop: true,
								autoStart: true
							});
							
						}
					},200);	
				});                    		
			}
		}
	}
}]);
App.directive('section', ['$compile', function($compile) {
	return {
		// A = attribute, E = Element, C = Class and M = HTML Comment
		restrict: 'E',
		//The link function is responsible for registering DOM listeners as well as updating the DOM.
		link: function(scope, element, attrs) {
			setTimeout(function() {
				if(element.hasClass("section-count-down")){
					var time = element.find(".block-daytime metadata").attr("data-value");
					var html = '<div ng-if="mode > 0" id ="countdown"></div>';
					var t = time.toDate("dd/mm/yyyy hh:ii");
					var datetime = new Date(t);
					element.find("#content-section .wrapper-section .block-daytime .wrapper-block").append(html);
					element.find("#content-section .wrapper-section .block-daytime .wrapper-block #countdown").countdown(datetime, function(event) {
						var month = event.strftime('%-m');
						var year = event.strftime('%-y');
						var string = "";
						if(parseInt(year) > 0) string += event.strftime('<div class="item"><span class="number">%-y</span><span class="text">Năm</span></div>');
						if(parseInt(month) > 0)
							string += event.strftime('<div class="item"><span class="number">%-m</span><span class="text">Tháng</span></div>');
					    string += event.strftime(''
						    + '<div class="item"><span class="number">%-d</span> <span class="text">Ngày</span></div>'
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
String.prototype.replaceAll = function(search, replacement) {
	var target = this;
	return target.split(search).join(replacement);
}
String.prototype.toDate = function(format)
{
  var normalized      = this.replace(/[^a-zA-Z0-9]/g, '-');
  var normalizedFormat= format.toLowerCase().replace(/[^a-zA-Z0-9]/g, '-');
  var formatItems     = normalizedFormat.split('-');
  var dateItems       = normalized.split('-');
  var monthIndex  = formatItems.indexOf("mm");
  var dayIndex    = formatItems.indexOf("dd");
  var yearIndex   = formatItems.indexOf("yyyy");
  var hourIndex     = formatItems.indexOf("hh");
  var minutesIndex  = formatItems.indexOf("ii");
  var secondsIndex  = formatItems.indexOf("ss");
  var today = new Date();
  var year  = yearIndex>-1  ? dateItems[yearIndex]    : today.getFullYear();
  var month = monthIndex>-1 ? dateItems[monthIndex]-1 : today.getMonth()-1;
  var day   = dayIndex>-1   ? dateItems[dayIndex]     : today.getDate();
  var hour    = hourIndex>-1      ? dateItems[hourIndex]    : today.getHours();
  var minute  = minutesIndex>-1   ? dateItems[minutesIndex] : today.getMinutes();
  var second  = secondsIndex>-1   ? dateItems[secondsIndex] : today.getSeconds();
  return new Date(year,month,day,hour,minute,second);
};
//envent jquery

