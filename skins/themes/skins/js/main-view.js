window.onload = userAgentDetect;
function userAgentDetect() {
  if(window.navigator.userAgent.match(/Mobile/i)
  || window.navigator.userAgent.match(/iPhone/i)
  || window.navigator.userAgent.match(/iPod/i)
  || window.navigator.userAgent.match(/IEMobile/i)
  || window.navigator.userAgent.match(/Windows Phone/i)
  || window.navigator.userAgent.match(/Android/i)
  || window.navigator.userAgent.match(/BlackBerry/i)
  || window.navigator.userAgent.match(/webOS/i)) {
    document.body.className += ' mobile';
  }
  else if(window.navigator.userAgent.match(/Tablet/i)
  || window.navigator.userAgent.match(/iPad/i)
  || window.navigator.userAgent.match(/Nexus 7/i)
  || window.navigator.userAgent.match(/Nexus 10/i)
  || window.navigator.userAgent.match(/KFAPWI/i)) {
    document.body.className = ' mobile';
  } 
}
(function () {
	var geolocation = {
		lat: 21.028511,
		lng: 105.804817
	};
	var window_W = $("html").width();
	var window_H = $("html").height();
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {
			geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
		});
	}

	function loadding($element) {
		$element.append('<div class="loadding_ajax"><div class="load_ajax"></div></div>')
	}

	function removeloadding($element) {
		$element.find(".loadding_ajax").remove();
	}
	var App = angular.module('ThemeApp', ["ngMap"]);
	App.config(['$qProvider', function ($qProvider) {
		$qProvider.errorOnUnhandledRejections(false);
	}]);
	App.config(['$httpProvider', function ($httpProvider) {
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
	App.controller("PageController", function ($scope, $http) {
		$("#view-page").hide();
		$scope.callserver = 0;
		$scope.readerViewHtml = "";
		$scope.user_id = typeof User_id == "undefined" ? 0 : User_id;
		$scope.snow = null;
		$scope.upload = $("#box-upload #upload");
		$scope.uploads = $("#box-upload #uploads");
		$scope.theme = {};
		$scope.oldFunction = null;
		$scope.theme.id = ThemeID;
		$scope.theme.ramkey = Ramkey;
		$scope.theme.effect = 0;
		$scope.theme.effect_file = {
			minsize: 10,
			maxsize: 40,
			onnew: '800'
		};
		var today = new Date();
		$scope._month_ = today.getMonth() + 1;
		$scope._day_ = today.getDate();
		$scope._year_ = today.getFullYear();
		$scope._hours_ = today.getHours();
		$scope.readerViewHtml = null;
		$scope.theme.effect_media_id = 0;
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
		$scope.Onload = false;
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
		$scope.ScreenWidth = screen.width;
		$scope.ScreenHeight = screen.height;
		var tag_audio = new Audio();
		tag_audio.loop = true;
		tag_audio.muted = false;
		tag_audio.autoplay = false;
		$scope.AppAccess = AppAccess;
		$scope.support_key = "theme";
		$scope.background_repeat = ["repeat", "repeat-x", "repeat-y", "no-repeat", "initial", "inherit"];
		$scope.background_size = ["auto", "cover", "contain", "initial", "inherit"];
		$scope.background_position = ["left top", "left center", "left bottom", "right top", "right center", "right bottom", "center top", "center center",
			"center bottom"
		];
		$scope.screens = [
		    {
				size : $scope.ScreenWidth,
				label: " hiện tại " + $scope.ScreenWidth + 'px',
				height : $scope.ScreenHeight,
				active : 1 
			}
		];

		$scope.currentScreen = $scope.screens[0];
		$scope.ScreenSection = {};
		$scope.ScreenSection[$scope.currentScreen.size] = null;
		$scope.ScreenSection[$scope.currentScreen.height] = null;
		$scope.background_attachment = ["scroll", "fixed", "local", "initial", "inherit"];
		$scope.is_changeSectionStyle = false;
		$scope.$watch('theme.font', function () {
			try {
				$scope.theme.style["font-family"] = $scope.theme.font.name;
				$scope.theme.font_file = $scope.theme.font.id;
			} catch (e) {}

		}, true);
		$scope.$watch('theme.sound', function () {
			if ($scope.theme.sound == null) tag_audio.pause();
			if ($scope.theme.sound != null) $scope.theme.sound_file = $scope.theme.sound.id;
			else $scope.theme.sound_file = 0;
		}, true);
		$scope.oldW = $scope.currentScreen.size;
		$scope.$watch('theme.sound_play', function () {
			if ($scope.theme.sound) {
				if ($scope.theme.sound_play == 1) {
					tag_audio.src = AppAccess + $scope.theme.sound.path;
					tag_audio.load();
					tag_audio.oncanplaythrough = function(){
						var inval = setInterval(()=> {
							if(tag_audio.paused){
								try{
									const playPromise = tag_audio.play();
									if (playPromise !== null){
									    playPromise.catch(() => { tag_audio.play(); })
									}
								}catch(e){
									
								}
								
							}else{
								clearInterval(inval);
							}
							
						},100);
					}
				} else {
					tag_audio.pause();
				}
			}

		}, true);
		$scope.onloadStyle = function(){
			$scope.Onload = true;
		}
		$scope.soundStartStop = function () {
			$scope.theme.sound_play = !$scope.theme.sound_play;
			return true;
		}
		//get pramater_server 
		$scope.loaddPage = function () {
			$("body").append('<div class="loadding_ajax loadding_ajax-body"><div class="load_ajax"></div></div>');
		}
		$scope.removeloaddPage = function () {
			$("body .loadding_ajax-body").remove();
		}
		$scope.MoreSection = function (section) {
			section.more += parseInt(section.ncolum_show_block);
			return true;
		}
		$scope.CreateBlockGroup = function () {
			this.section.blocks_on = [];
			this.section.blocks_off = [];
			this.section.onload = 0;
			this.section.more = parseInt(this.section.ncolum_show_block);
			for (var i = 0; i < this.section.blocks.length; i++) {
				this.section.blocks[i].$index = i;
				this.section.blocks[i].active = 0;
				if (this.section.blocks[i].id == this.section.default_block) {
					this.section.blocks_off.push(this.section.blocks[i]);
				} else {
					this.section.blocks_on.push(this.section.blocks[i]);
				}
			}
			return true;
		}
		$scope.initPage = function () {
			$scope.loaddPage();
			if ($scope.callserver == 0) {
				//get section
				$http({
					method: "POST",
					data: {
						id: $scope.theme.id,
						allowScreen : $scope.currentScreen.size,
						is_create: 2
					},
					url: AppAccessCotroller + "appthemes/get_data/" + $scope.theme.id
				}).then(function (response) {
					if(response.data.redirect == 1){
						document.location.href = response.data.redirect_URL;
						return false;
					}
					try {
						$scope.sections = response.data.sections;
						$scope.ScreenSection[$scope.currentScreen.size] = response.data.sections;
					} catch (e) {

					}
					$scope.theme = Object.assign($scope.theme, response.data.theme);
					if ($scope.theme.effect_file == null) {
						$scope.theme.effect_file = {};
					}
					$scope.theme.effect_play = $scope.theme.effect;
					var inval = setInterval(()=> {
						if($scope.Onload == true){	
							setTimeout(function(){
								$("#page_theme").css("opacity",1);
								$scope.removeloaddPage();
							},200);
							clearInterval(inval);
							$scope.callserver = 1;
						} 	
					},10);
					$http({
						method: "POST",
						data: {
							id: $scope.theme.id,
							allowScreen : $scope.currentScreen.height,
							is_create: 2
						},
						url: AppAccessCotroller + "appthemes/get_allow_screen/" + $scope.theme.id
					}).then(function (response) {
						$scope.ScreenSection[$scope.currentScreen.height] = response.data.sections;
					})
				}, function (error) {
					//location.reload();
				});
				$(document).on("click", "body", function () {
					if ($("#icon-cog-section").hasClass("active")) {
						$("body #icon-cog-section").trigger("click");
					}
				});
				$(document).on("click", "body #icon-cog-section", function (e) {
					$(this).toggleClass("active");
					$("#sidebar.priview-sidebar").toggleClass("open");
					e.stopPropagation();
					return false;
				});

				$(document).on("click", "body #sidebar #nav-menu #scrollbars", function (e) {
					e.stopPropagation();
					return false;
				});
			}
			
		}
		$scope.initPage();
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
		$scope.IsList = function (part) {
			if (part.name.trim() == "list images") return true;
			return false;
		}

		$scope.StartStop = function (sound, $event) {
			$event.stopPropagation();
			$.each($scope.sounds, function () {
				if (sound.id != this.id) {
					this.start = 0;
				}
			});
			if (sound.start == 1) {
				$scope.SoundSource(0, null);
				sound.start = 0;
			} else {
				tag_audio.src = sound.path;
				$scope.SoundSource(1, AppAccessCotroller + sound.path);
				sound.start = 1;
			}
			return false;
		}
		$scope.SoundSource = null;
		$scope.ToSection = function () {
			$scope.section = this.section;
			$.each($scope.sections, function () {
				this.active = 0;
			});
			$scope.section.active = 1;
			$scope.blocks = this.section.blocks;
			try {
				$('html').animate({
					scrollTop: $('section[ramkey=' + $scope.section.ramkey + ']').offset().top - 22
				}, 400);
			} catch (r) {}
			return false;
		}

		//content.
		$scope.MetaShow = function ($part = null ,$show = 0) {
			//meta show
			var part = this.part;
			var html_show = part.html_show;
			var list_show = part.list_show;
			html_show = html_show.replace("{{value}}", list_show);
			var stringR = '';
			if (part.metas.length > 0) {
				if (part.metas[0].media_id != 0 && part.metas[0].meta_key == "value_media") {
					stringR = html_show.replace("{{value}}", '{{part.metas[0].medium}}').replace("{{media_id}}", "{{part.metas[0].media_id}}");
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
		$scope.blockShow = function (section, block) {
			if (block.id == section.default_block) {
				return false;
			} else return true;
		}
		$scope.MoreBlock = function (block) {
			$("#modal-view-block").modal();
			return false;
		}
		$scope.ViewBlock = function (block) {
			$scope.block = block;
			if ($scope.block.class_name == "block-album") {
				var slider = '<waterfalls></waterfalls>';
				$scope.block.more = slider;
				$("#content-album-slider").modal();
			} else if ($scope.block.class_name == "block-groom" || $scope.block.class_name == "block-bridesmaid") {
				$("#modal-view-block").modal();
			} else {
				$("#modal-view-block").modal();
			}
			return false;
		}
		$scope.Submit = function (block) {
			$scope.block = this.$parent.$parent.block;
			$scope.section = this.$parent.$parent.$parent.section;
			$scope.blocks = $scope.section.blocks;
			$scope.parts = $scope.section.parts;
			$scope.metas = $scope.section.metas;
			if ($scope.block.class_name.trim() == "block-form-guestbook") {
				if (Privew) return Privew;
				var next = true;
				var name = $(".section-wish .block-form-guestbook .value_text input#input_content").val();
				var content = $(".section-wish .block-form-guestbook textarea").val();
				if (name.trim() == '') {
					next = false;
					$(".section-wish .block-form-guestbook .value_text input#input_content").addClass("error");
				}
				if (content.trim() == '') {
					next = false;
					$(".section-wish .block-form-guestbook textarea").addClass("error");
				}
				if (next == true) {
					$http({
						method: "POST",
						responseType: "json",
						data: {
							name: name,
							content: content,
							theme_id: $scope.theme.id,
							theme_section_id: $scope.section.theme_section_id,
							parent_id: $scope.theme.clone_id,
							section_id: $scope.section.id,
							sort: $scope.section.blocks.length,
							block_id: $scope.section.default_block
						},
						url: AppAccessCotroller + "appthemes/guestbook"
					}).then(function (response) {
						$scope.section.blocks.push(response.data);
						$scope.section.blocks_off.push(response.data);
						$(".section-wish .block-form-guestbook .value_text input#input_content").val('');
						$(".section-wish .block-form-guestbook textarea").val('');
					}, function (error) {
						location.reload();
					});
				}
			}
		}
		$('#content-album-slider').on('hidden.bs.modal', function () {
			$scope.block.more = '';
		});
		$('#modal-edit-block').on('shown.bs.modal', function () {
			$scope.support_key == "block";
		});
		$scope.$watch("theme.effect_play", function () {
			if ($scope.theme.effect_play != 1) {
				try {
					$.fn.snow({
						start: false
					});
				} catch (err) {}
			}
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
		$scope.toDate = function($string,$format) {
			if($string != undefined)
				return $string.toDate($format);
		}
		$scope.SetZoom = function (map, blocks) {
			if(blocks.length > 1){
				var bounds = new google.maps.LatLngBounds();
				$.each(blocks, function () {
					$.each(this.parts, function () {
						if (this.name == "map") {
							var meta = this.metas[0];
							var value = meta.value;
							value = JSON.parse(value.replace(/\'/g, '"'));
							var latlng = new google.maps.LatLng(value.lat, value.lng);
							bounds.extend(latlng);
						}
					});
				});
				map.setCenter(bounds.getCenter());
				map.fitBounds(bounds);
			}else{
				$.each(blocks[0].parts, function () {
					if (this.name == "map") {
						var meta = this.metas[0];
						var value = meta.value;
						value = JSON.parse(value.replace(/\'/g, '"'));
						var latlng = new google.maps.LatLng(value.lat, value.lng);
						map.setCenter(latlng);
					}
				});
				map.setZoom(16);  	
			}
			
			setTimeout(function () {
				google.maps.event.trigger(map, "resize");
			}, 500);
		}
		$scope.checkfireworks = function (section){
			if(section.is_effect == 0 || section.is_effect =="0") return false;
			if(section.everyday_effect == 1 || section.everyday_effect == "1") return true;
			if(section.from_day_effect) {
				var from = section.from_day_effect.split("/")
				var f = new Date(from[2], from[1] - 1, from[0])
				var d = new Date();
				if(f <= d) return true;
			}
			return false;
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
	App.directive('partmap', function () {
		return {
			restrict: 'A',
			template: '<ng-map zoom="8" map-initialized="initializedMap(map)" style="height:500px"><marker position="{{block.position}}"></marker></ng-map>',
			replace: false,
			//The link function is responsible for registering DOM listeners as well as updating the DOM.
			link: function (scope, element, attrs) {
				scope.initializedMap = function (map) {
					try{
			      		var position = new google.maps.LatLng(scope.block.position[0],scope.block.position[1]);
			      		map.setCenter(position);
			      	}catch(e){

			      	}
					setTimeout(function () {
						google.maps.event.trigger(map, "resize");
					}, 1000);
				}

			}
		};
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
	          var time = element.find(".block-count-down metadatas metadata").attr("data-value");
	          var datimeElement = element.find(".block-count-down metadatas metadata");
	          var b_key = parseInt(datimeElement.closest("block").attr("data-index"));
	          var p_key = parseInt(datimeElement.closest("part").attr("data-index"));
	          var m_key = parseInt(datimeElement.attr("data-index"));
	          try {
	            try {
	              element.find("#content-section .wrapper-section .block-count-down .wrapper-block #countdown").countdown('destroy');
	            } catch (e) {}
	            scope.section.defaultblock = function () {
	              time = element.find(".block-count-down metadatas metadata").attr("data-value");
	              var t = scope.toDate(time,"dd/mm/yyyy hh:ii");
	              var datetime = new Date(t);
	              element.find("#content-section .wrapper-section .block-count-down .wrapper-block #countdown").countdown(datetime, function (event) {
	                var month = event.strftime('%-m');
	                var year = event.strftime('%-y');
	                var string = "";
	                if (parseInt(year) > 0) string += event.strftime('<div class="item"><p class="number">%-y</p><p class="text">Năm</p></div>');
	                if (parseInt(month) > 0)
	                  string += event.strftime('<div class="item"><p class="number">%-m</span><span class="text">Tháng</span></div>');
	                string += event.strftime('' +
	                  '<div class="item"><p class="number">%-n</p> <p class="text">Ngày</p></div>' +
	                  '<div class="item"><p class="number">%H</p> <p class="text">Giờ</p></div>' +
	                  '<div class="item"><p class="number">%M</p> <p class="text">Phút</p></div>' +
	                  '<div class="item"><p class="number">%S</p> <p class="text">Giây</p></div>'
	                );
	                var $this = $(this).html(string);
	              });
	            }
	          } catch (e) {}
	          var html = '<div ng-if="mode > 0" id ="countdown"></div>';
	          var t = scope.toDate(time,"dd/mm/yyyy hh:ii");
	          var datetime = new Date(t);
	          element.find("#content-section .wrapper-section .block-count-down .wrapper-block").append(html);
	          element.find("#content-section .wrapper-section .block-count-down .wrapper-block #countdown").countdown(datetime, function (event) {
	            var month = event.strftime('%-m');
	            var year = event.strftime('%-y');
	            var string = "";
	            if (parseInt(year) > 0) string += event.strftime('<div class="item"><p class="number">%-y</p><p class="text">Năm</p></div>');
	            if (parseInt(month) > 0)
	              string += event.strftime('<div class="item"><p class="number">%m</p><p class="text">Tháng</p></div>');
	              string += event.strftime('' +
	                '<div class="item"><p class="number">%-n</span> <p class="text">Ngày</p></div>' +
	                '<div class="item"><p class="number">%H</span> <p class="text">Giờ</p></div>' +
	                '<div class="item"><p class="number">%M</span> <p class="text">Phút</p></div>' +
	                '<div class="item"><p class="number">%S</span> <p class="text">Giây</p></div>'
	              );
	            var $this = $(this).html(string);
	          });
	        }

	      }, 20);
	    }
	  }
	}]);
	App.directive('auto', ['$compile', function ($compile) {
	  return {
	    restrict: 'E',
	    template: '<div class="default-blocks" ng-class="section.blocks_off.length == 1 ? \'cented_block\' : \'\'">\
	            <block ng-if="(($index + 1) <= section.ncolum_show_block) || (($index + 1) <= section.more)" ng-class="[{true :\'not-edit\'}[block.actions.length == 0],{true : \'active\'}[block.active == 1]]" ng-repeat="block in section.blocks_off" class="col-md-{{12/section.ncolum_block}} col-lg-{{12/section.ncolum_block}} col-sm-{{12/section.ncolum_block}} col-xs-{{12/section.ncolum_block}} block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
	                  <div class="wrapper-block">\
	                    <parts class="list-parts">\
	                      <div class="row">\
	                        <part ng-if="part.metas.length > 0" ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} {{part.name}} {{part.name}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
	                          <metadatas class="{{part.name}}" data-is="{{part.name}}">\
	                            <metadata ng-attr-data-value="{{(part.metas[0].meta_key != \'value_media\') ? part.metas[0].value : part.metas[0].medium}}" data-value="" class="{{part.metas[0].meta_key}}" compile="MetaShow(part)" ng-attr-data-index="0" data-index></metadata>\
	                          </metadatas>\
	                        </part>\
	                      </div>\
	                    </parts>\
                      <div class="more-block" ng-if="section.class_name != \'section-wish\'"><a class="btn btn-more" ng-click="ViewBlock(block)">Xem thêm</a></div>\
	                  </div>\
	              </block>\
	              <ul ng-if="section.more < section.blocks_off.length"  class="menu-block-view">\
	                	<li class="more-block">\
	          				<a class="btn btn-more" ng-click="MoreSection(section)" href="javascript:;"><i class="fa fa-arrow-down" aria-hidden="true"></i> Xem thêm</a>\
	          			</li>\
	      			</ul>\
	            </div>',
	    link: function (scope, element, attrs) {
	      element.addClass("loading");
	      scope.section.reload = function () {
	        element.addClass("loading");
	        element.removeClass("loading");
	        element.parent().css("min-height", "auto");
	        return this;
	      }
	      setTimeout(function () {
	        scope.section.reload();
	      }, 500)
	    }
	  }
	}]);
  App.directive('grid', ['$compile', function ($compile) {
	  return {
	    restrict: 'E',
	    template: '<div class="default-blocks" ng-class="section.blocks_off.length == 1 ? \'cented_block\' : \'\'">\
	            	<block ng-click="ViewBlock(block)" ng-if="(($index + 1) <= section.ncolum_show_block) || (($index + 1) <= section.more)" ng-class="[{true : \'active\'}[block.active == 1]]" ng-repeat="block in section.blocks_off" class="col-md-{{12/section.ncolum_block}} col-lg-{{12/section.ncolum_block}} col-sm-{{12/section.ncolum_block}} col-xs-{{12/section.ncolum_block}}  block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
	                  <div class="wrapper-block">\
	                    <parts class="list-parts">\
	                      <div class="row">\
	                        <part ng-if="part.metas.length > 0" ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} {{part.name}} {{part.name}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
	                          <metadatas class="{{part.name}}" data-is="{{part.name}}">\
	                            <metadata ng-attr-data-value="{{(part.metas[0].meta_key != \'value_media\') ? part.metas[0].value : part.metas[0].medium}}" data-value="" class="{{part.metas[0].meta_key}}" compile="MetaShow(part)" ng-attr-data-index="0" data-index></metadata>\
	                          </metadatas>\
	                        </part>\
	                      </div>\
	                    </parts>\
                      <div ng-if="section.class_name != \'section-albums-wedding\'" class="more-block"><a class="btn btn-more" ng-click="ViewBlock(block)">Xem thêm</a></div>\
	                  </div>\
	              	</block>\
	            	<ul ng-if="section.more < section.blocks_off.length"  class="menu-block-view">\
	                	<li class="more-block">\
	          				<a class="btn btn-more" ng-click="MoreSection(section)" href="javascript:;"><i class="fa fa-arrow-down" aria-hidden="true"></i> Xem thêm</a>\
	          			</li>\
	      			</ul>\
	            </div>',
	    link: function (scope, element, attrs) {
	      scope.section.reload = function () {
	        element.addClass("loading");
	        element.parent().css("height", element.outerHeight() + "px");
	        var index = 1;
	        $.each(element.find("block"), function (key, value) {
	          if (index % scope.section.ncolum_block == 0) {
	            $(this).after('<div class="row break-clolums"><div/>');
	          }
	          index++;
	        });
	        element.removeClass("loading");
	        element.parent().css("height", "auto");
	        return this;
	      }
	      setTimeout(function () {
	        scope.section.reload();
	      }, 500);
	    }
	  }
	}]);
	App.directive('slider', ['$compile', function ($compile) {
	  return {
	    restrict: 'E',
	    template: '<div class="default-blocks" ng-class="section.blocks_off.length == 1 ? \'cented_block\' : \'\'">\
      <block ng-click="ViewBlock(block)" ng-class="[{true : \'active\'}[block.active == 1]]" ng-repeat="block in section.blocks_off" class="col-md-{{12/section.ncolum_block}} col-lg-{{12/section.ncolum_block}} col-sm-{{12/section.ncolum_block}} col-xs-{{12/section.ncolum_block}} block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
	        <div class="wrapper-block">\
	          <parts class="list-parts">\
	          <div class="row">\
	            <part ng-if="part.metas.length > 0" ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} {{part.name}} {{part.name}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
	            <metadatas class="{{part.name}}" data-is="{{part.name}}">\
	              <metadata ng-attr-data-value="{{(part.metas[0].meta_key != \'value_media\') ? part.metas[0].value : part.metas[0].medium}}" data-value="" class="{{part.metas[0].meta_key}}" compile="MetaShow(part)" ng-attr-data-index="0" data-index></metadata>\
	            </metadatas>\
	            </part>\
	          </div>\
	          </parts>\
	        </div>\
	      </block>\
	    </div>',
	    link: function (scope, element, attrs) {
	      scope.section.reload = function () {
	        try {
	          element.find(".default-blocks").destroySlider();
	        } catch (e) {}
	        var window_W = $("html").outerWidth();
	        var window_H = $("html").outerHeight();
	        var pager;
	        var controls;
	        var item = this.ncolum_block;
	        var w = element.find(".default-blocks").outerWidth();
	        var lenght_item = element.find(".default-blocks block").length;
	        item = parseInt(item);
	        if (window_W < 1025) {
	          pager = true;
	          controls = false;
	        } else {
	          pager = false;
	          controls = true;
	        }
	        if (window_W < 769) {
	        }
	        if (window_W < 421) {
	          pager = false;
	          controls = true;
	        }
	        var slider = element.find(".default-blocks").bxSlider({
	          minSlides: item,
	          maxSlides: item,
	          slideWidth: w / item,
	          pager: false,
	          controls: true,
	          auto: false,
	          infiniteLoop: false,
	          autoStart: false,
	          slideMargin: 15,
	          onSliderLoad: function () {
	            element.parent().css("height", element.outerHeight() + "px");
	            setTimeout(function () {
	              element.removeClass("loading");
	              element.parent().css("height", "auto");
	            }, 200); 
	          }

	        });
	        return this;
	      }
	      element.addClass("loading");
	      setTimeout(function () {
	        scope.section.reload();
	        scope.section.onload = 1;
	      }, 500);
	    }
	  }
	}]);
	App.directive('defaultblock', ['$compile', function ($compile) {
	  return {
	    // A = attribute, E = Element, C = Class and M = HTML Comment
	    restrict: 'E',
	    replace: false,
	    //The link function is responsible for registering DOM listeners as well as updating the DOM.
	    link: function (scope, element, attrs) {
	      scope.section.defaultblock = function () {
	        if (this.layout_show_block != null) {
	          element.html('<' + this.layout_show_block + ' section="section"></' + this.layout_show_block + '>');
	          $compile(element.contents())(scope);
	        } else {
	          element.html('<auto section="section"></auto>');
	          $compile(element.contents())(scope);
	        }
	        return this;
	      }
	      if (scope.section.class_name == "section-organizing-points") {
	        $.each(scope.section.blocks_off, function () {
	          this.position = scope.getposition(this);
	        })
	        element.parents(".wrapper-section").append('<div class="box-add"><mapsorganizing section="section"></mapsorganizing></div>');
	        $compile(element.parents(".wrapper-section").find(".box-add").contents())(scope);
	      }
	      scope.section.defaultblock();
	    }
	  }
	}]);
	App.directive('mapsorganizing', ['$compile', function ($compile) {
	  return {
	    // A = attribute, E = Element, C = Class and M = HTML Comment
	    restrict: 'E',
	    template: '<ng-map style="height:600px" map-initialized="SetZoom(map,section.blocks_off)"><marker position="{{block.position}}" ng-repeat="block in section.blocks_off"></marker></ng-map>',
	    link: function (scope, element, attrs) {

	    }
	  }
	}]);
	App.directive('effictelent', function () {
		return {
			// A = attribute, E = Element, C = Class and M = HTML Comment
			restrict: 'E',
			//The link function is responsible for registering DOM listeners as well as updating the DOM.
			link: function (scope, element, attrs) {
				var thumb = scope.theme.effect_file.thumb ? scope.theme.effect_file.thumb : AppAccess + "/uploads/source/imgeffect/start-59eef88a17c0f.png";
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
	App.directive('fireworks', function () {
		return {
			// A = attribute, E = Element, C = Class and M = HTML Comment
			restrict: 'E',
			//The link function is responsible for registering DOM listeners as well as updating the DOM.
			link: function (scope, element, attrs) {
				setTimeout(function () {
					var h = element.parent().height();
					element.css({
						width: '100%',
						position: "absolute",
						bottom: 0,
						left: 0,
						right: 0,
						top: 0
					});
					element.fireworks();
				}, 400);
			}
		}
	});
	App.directive('waterfalls', function () {
		return {
			// A = attribute, E = Element, C = Class and M = HTML Comment
			restrict: 'E',
			//The link function is responsible for registering DOM listeners as well as updating the DOM.
			link: function (scope, element, attrs) {
				scope.$watch("block", function (newValue, oldValue) {
					var html = "<ul id=\"waterfall\">";
					$.each(scope.block.parts, function (key, val) {
						$.each(this.metas, function () {
							if (this.meta_key == "value_media") {
								html += '<li><div><a class="fancybox-thumb" href="' + this.path + '" data-fancybox="fancybox-thumb"><img src="' + this.thumb + '"></a></div></li>';
							}
						});
					});
					html += "</ul>";
					element.html(html);
					element.find('#waterfall').NewWaterfall({
						width: 360,
						delay: 100,
					});
					element.find("#waterfall .fancybox-thumb[data-fancybox]").fancybox({
						loop: true,
						thumbs: {
							autoStart: true,
							hideOnClose: true
						},
						buttons: [
							'slideShow',
							'fullScreen',
							'thumbs',
							'share',
							'zoom',
							'download',
							'close'
						]
					});
				});
			}
		}
	});
	App.directive("p", function () {
		return {
			restrict: 'E',
			link: function (scope, element, attrs) {
				if (element.text() == null || element.text().trim() == "") element.remove();
			}
		}
	});
	App.directive('styleOnload',function(){
		return {
		    scope: {
		        callBack: '&styleOnload'
		    },
		    link: function(scope, element, attrs){
		        element.on('load', function(){
		            return scope.callBack();
		        })
		    }
		}
	});
	App.directive('pageresize', ['$window', function ($window) {
    return {
        link: link,
        restrict: 'A'           
    };
    function link(scope, element, attrs){
       angular.element($window).bind('resize', function(){
            var w = $window.innerWidth;
            var c = $window.innerWidth - scope.currentScreen.size ;
            if(c < 0){
            	c *= -1; 
            }
            var c2 = window.innerWidth - scope.currentScreen.height;
            if(c2 < 0){
            	c2 *= -1;
            }
            if(c > c2){
            	w = scope.currentScreen.height;
            }else{
            	w = scope.currentScreen.size;
            }
            if(scope.oldW != w){
            	if(scope.ScreenSection[w] != undefined){
			    	scope.sections = scope.ScreenSection[w];
			    	scope.$apply();
			    } 
			    scope.oldW = w;
            }
		    
       });    
    }    
 }]);
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
})();