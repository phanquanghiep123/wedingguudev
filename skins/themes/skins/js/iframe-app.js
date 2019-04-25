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
$(document).on('mouseenter','.section-item block:not(.not-edit)', function (event) {
   $(this).find(".wrapper-block").append("<div class=\"hover-box\"></div>");
   $(this).find(".wrapper-block .hover-box").addClass("active");
}).on('mouseleave','.section-item block:not(.not-edit)',  function(){
   $(this).find(".wrapper-block .hover-box").remove();
});

$(document).on('mouseenter','#support_section.menu-action', function (event) {
  $(this).closest(".section-item").addClass("active");
}).on('mouseleave','#support_section.menu-action',  function(){
  $(this).closest(".section-item").removeClass("active");
});
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
var App = angular.module('ThemeAppIframe', ["ngMap"]);
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
App.controller("PageIframeController", function ($scope, $http, $compile) {
  $scope.parentWindow = {};
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
  $scope.$watch('parentWindow.section',(newValue, oldValue) => {
    if($scope.parentWindow != null){
      try{
        if($scope.parentWindow.section != null){
          if(newValue.ramkey == oldValue.ramkey){
            try{
              if(typeof newValue.defaultblock  != undefined)
                newValue.defaultblock();
              else if(typeof oldValue.defaultblock  != undefined)
                oldValue.defaultblock();
            }catch(e){
            } 
          }
        }
      }catch(e){
      } 
    }
  }, true);

  $scope.$watch('parentWindow.section.blocks', function (newValue, oldValue) {
    if ($scope.parentWindow.section == null) return false;
    if (newValue != null && oldValue != null) {
      if ((newValue.length != oldValue.length) || $scope.parentWindow.section.order == true) {
        $scope.parentWindow.section.order == false;
        var blocks_on = [];
        var blocks_off = [];
        $scope.parentWindow.section.more = parseInt($scope.parentWindow.section.ncolum_show_block);
        for (var i = 0; i < $scope.parentWindow.section.blocks.length; i++) {
          $scope.parentWindow.section.blocks[i].$index = i;
          if ($scope.parentWindow.section.blocks[i].id == $scope.parentWindow.section.default_block) {
            blocks_off.push($scope.parentWindow.section.blocks[i]);
          } else {
            blocks_on.push($scope.parentWindow.section.blocks[i]);
          }
        }
        try {
          $scope.parentWindow.section.blocks_on = blocks_on;
          $scope.parentWindow.section.blocks_off = blocks_off;  
        } catch (e) {

        }
      }
    }
  }, true);
  $.datetimepicker.setLocale('vi');
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
  $scope.CreateBlockGroup = function(section) {
    try {
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
    } catch (e) {
      return false;
    }
    return true;
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
App.directive("p", function () {
  return {
    // A = attribute, E = Element, C = Class and M = HTML Comment
    restrict: 'E',
    //The link function is responsible for registering DOM listeners as well as updating the DOM.
    link: function (scope, element, attrs) {
      if (element.text() == null || element.text().trim() == "") element.remove();
    }
  }
});
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
              setTimeout(() => {
                time  = element.find(".block-count-down metadatas metadata").attr("data-value");
                var t = scope.parentWindow.toDate(time,"dd/mm/yyyy hh:ii");
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
              },500);
            }
          } catch (e) {}
          var html = '<div ng-if="parentWindow.mode > 0" id ="countdown"></div>';
          var t = scope.parentWindow.toDate(time,"dd/mm/yyyy hh:ii");
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
App.directive('auto', ['$compile', function ($compile) {
  return {
    restrict: 'E',
    template: '<div class="default-blocks" ng-class="section.blocks_off.length == 1 ? \'cented_block\' : \'\'">\
            <block ng-if="(($index + 1) <= section.ncolum_show_block) || (($index + 1) <= section.more)" ng-class="[{true : \'active\'}[block.active == 1]]" ng-repeat="block in section.blocks_off" class="col-md-{{12/section.ncolum_block}} col-lg-{{12/section.ncolum_block}} col-sm-{{12/section.ncolum_block}} col-xs-{{12/section.ncolum_block}} block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
                  <div class="wrapper-block">\
                    <div ng-if="parentWindow.mode == 0" class="menu-action" id="support_block">\
                      <ul class="menu-block" compile="parentWindow.ActionBlock(block,section)">\
                      </ul>\
                    </div>\
                    <parts class="list-parts">\
                      <div class="row">\
                        <part ng-if="part.metas.length > 0" ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} {{part.name}} {{part.name}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
                          <metadatas class="{{part.name}}" data-is="{{part.name}}">\
                            <metadata ng-attr-data-value="{{(part.metas[0].meta_key != \'value_media\') ? part.metas[0].value : part.metas[0].medium}}" data-value="" class="{{part.metas[0].meta_key}}" compile="parentWindow.MetaShow(part)" ng-attr-data-index="0" data-index></metadata>\
                          </metadatas>\
                        </part>\
                      </div>\
                    </parts>\
                  </div>\
              </block>\
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
App.directive('slider', ['$compile', function ($compile) {
  return {
    restrict: 'E',
    template: '<div class="default-blocks" ng-class="section.blocks_off.length == 1 ? \'cented_block\' : \'\'"><block ng-class="[{true : \'active\'}[block.active == 1]]" ng-repeat="block in section.blocks_off" class="col-md-{{12/section.ncolum_block}} col-lg-{{12/section.ncolum_block}} col-sm-{{12/section.ncolum_block}} col-xs-{{12/section.ncolum_block}} block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
        <div class="wrapper-block">\
          <div ng-if="parentWindow.mode == 0" class="menu-action" id="support_block">\
          <ul class="menu-block" compile="parentWindow.ActionBlock(block,section)">\
          </ul>\
          </div>\
          <parts class="list-parts">\
          <div class="row">\
            <part ng-if="part.metas.length > 0" ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} {{part.name}} {{part.name}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
            <metadatas class="{{part.name}}" data-is="{{part.name}}">\
              <metadata ng-attr-data-value="{{(part.metas[0].meta_key != \'value_media\') ? part.metas[0].value : part.metas[0].medium}}" data-value="" class="{{part.metas[0].meta_key}}" compile="parentWindow.MetaShow(part)" ng-attr-data-index="0" data-index></metadata>\
            </metadatas>\
            </part>\
          </div>\
          </parts>\
        </div>\
      </block>\
    </div>',
    link: function (scope, element, attrs) {
      scope.section.reload = function ($o = 1) {
        var h = element.height();
        if($o == 1){
          element.css("height",h+"px");
        }
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
          touchEnabled : false,
          oneToOneTouch: false,
          infiniteLoop: false,
          autoStart: false,
          slideMargin: 15,
          onSliderLoad:  () => {
            setTimeout(function () {
              if($o == 1){
                element.parent().css("height", "inherit");
              }
            }, 200);
            setTimeout(function () {
              $(window).trigger("resize");
            }, 500);
          }

        });
        return this;
      }
      var time = scope.section.onload == 0 ? 1000 : 0;
      setTimeout(function () {
        scope.section.reload(2);
        scope.section.onload = 1;
      }, time);
    }
  }
}]);
App.directive('grid', ['$compile', function ($compile) {
  return {
    restrict: 'E',
    template: '<div class="default-blocks" ng-class="section.blocks_off.length == 1 ? \'cented_block\' : \'\'">\
            <block ng-if="(($index + 1) <= section.ncolum_show_block) || (($index + 1) <= section.more)" ng-class="[{true : \'active\'}[block.active == 1]]" ng-repeat="block in section.blocks_off" class="col-md-{{12/section.ncolum_block}} col-lg-{{12/section.ncolum_block}} col-sm-{{12/section.ncolum_block}} col-xs-{{12/section.ncolum_block}}  block-item {{block.class_name}}" ramkey={{block.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
                  <div class="wrapper-block">\
                    <div ng-if="parentWindow.mode == 0" class="menu-action" id="support_block">\
                      <ul class="menu-block" compile="parentWindow.ActionBlock(block,section)">\
                      </ul>\
                    </div>\
                    <parts class="list-parts">\
                      <div class="row">\
                        <part ng-if="part.metas.length > 0" ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} {{part.name}} {{part.name}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>\
                          <metadatas class="{{part.name}}" data-is="{{part.name}}">\
                            <metadata ng-attr-data-value="{{(part.metas[0].meta_key != \'value_media\') ? part.metas[0].value : part.metas[0].medium}}" data-value="" class="{{part.metas[0].meta_key}}" compile="parentWindow.MetaShow(part)" ng-attr-data-index="0" data-index></metadata>\
                          </metadatas>\
                        </part>\
                      </div>\
                    </parts>\
                  </div>\
              </block>\
            </div>',
    link: function (scope, element, attrs) {
      scope.section.reload = function () {
        element.addClass("loading");
        element.parent().css("min-height", element.outerHeight() + "px");
        var index = 1;
        $.each(element.find("block"), function (key, value) {
          if (index % scope.section.ncolum_block == 0) {
            $(this).after('<div class="row break-clolums"><div/>');
          }
          index++;
        });
        element.removeClass("loading");
        element.parent().css("min-height", "auto");
        return this;
      }
      setTimeout(function () {
        scope.section.reload();
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
App.directive('year', function () {
  return {
    // A = attribute, E = Element, C = Class and M = HTML Comment
    restrict: 'A',
    template: '<option ng-repeat="year in parentWindow.years" value="{{year}}">{{year}}</option>',
    //The link function is responsible for registering DOM listeners as well as dating the DOM.
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
        });
      }, 20);
    }
  }
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
        $("#modal-filemanager").on("hidden.bs.modal", function () {
          if (scope.support_key == "block") {
            $("body").addClass("modal-open");
          }
        });
        var length_medias = (scope.metas.length);
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
            scope.theme.style["background-image"] = 'url(' + val[0].full + ')';
          } else if (scope.support_key == "section") {
            scope.section.style["background-image"] = 'url(' + val[0].full + ')';
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
        if (type_action == "effect") {
          scope.theme.effect = 1;
          scope.theme.effect_file.thumb = val[0].thumb;
          scope.theme.effect_file.path = val[0].full;
          scope.theme.effect_media_id = val[0].id;
        }
        scope.$apply();
      }
      var before = function () {
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
        beforchoose: beforchoose,
        after: function () {
          //$("body").addClass("modal-open");
        }
      });
    }
  };
});
App.directive('blocks', function () {
  return {
    // A = attribute, E = Element, C = Class and M = HTML Comment
    restrict: 'E',
    //The link function is responsible for registering DOM listeners as well as updating the DOM.
    link: function (scope, element, attrs) {
      element.sortable({
        connectWith: "parent",
        handle: "#move-action",
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
          scope.blocks = blocks;
          scope.section.blocks = blocks;
          scope.section.blocks = blocks;
          scope.UpdateSort("block", sortlist);
          scope.$apply();
        }
      });
      element.disableSelection();
    }
  };
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

      }, 500);
       
    }
  }
});