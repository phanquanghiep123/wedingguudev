var App = angular.module('ThemeApp', []);
App.config(['$qProvider', function ($qProvider) {
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
App.controller('Sidebar',function($scope, $http) {
	$scope.menus = [
	    {
	  		name        : "Chế chỉnh sửa",
	  		id 	        : "page-change",
	  		controller 	: "SidebarChange"
	  	},
	  	{
	  		name        : "Nền trang",
	  		id 	        : "page-background",
	  		controller 	: "SidebarBackground"
	  	},
	  	{
	  		name 		: "Phông chữ",
	  		id 			: "page-font",	
	  		controller 	: "SidebarFont"
	  	},
	  	{
	  		name 		: "Nhạc nền",
	  		id   		: "page-sound",	
	  		controller 	: "SidebarSound"
	  	},
	  	{
	  		name 		: "Hiệu ứng",
	  		id   		: "page-effect",
	  		controller 	:"SidebarEffect"
	  	},
	  	{	name       : "Thành phần trang" , 
	  		id         : "page-section",	
	  		controller : "SidebarSection"
	  	},
	  	{
	  		name 	   : "Chọn style file",
	  		id         : "page-style",	
	  		controller : "SidebarParts"
	  	},
	  	{
	  		name 	   : "Thông tin theme",
	  		id         : "page-info",	
	  		controller : "SidebarParts"
	  	}
	];
	$scope.content_actions = "";
	var beforchoose = function (val){
	    var max_file = this.query.max_file;
	    console.log(val);
	}
	var before = function (){
	    this.query.max_file  = $("#sidebar-actions #openFilemanager").attr("data-max");
	    this.query.type_file = $("#sidebar-actions #openFilemanager").attr("data-type");
	    var length_medias = $(".modal #content-list .info-item").length;
	    if(length_medias >= this.query.max_file && this.query.max_file > 1){
	      alert("Please select up to "+this.query.max_file+" media file");
	      return false;
	    }
	    return true;
	}
	$scope.getContentmenu = function(name){
	  	$http({
	        method : "POST",
	        data   : {template : name,theme_id : ThemeID},
	        url : AppAccessCotroller + "themes/themes/get_template_by_sidebar"
    	}).then(function(response) {
    		$("#sidebar-actions .actions-body").html(response.data);
        	var filemanager = $("#sidebar-actions #openFilemanager").Scfilemanagers({
		        base_url    : AppAccess,
		        before      : before,
		        beforchoose : beforchoose,
		        after : function (){
		          $("body").addClass("modal-open");
		        }     
		    });
		    $("#sidebar-actions").addClass("open");
	    },function(error){
	    	console.log(error);
	    }) ;
	    return false;
	}
	$scope.CloseActions = function(){
		$("#sidebar-actions").removeClass("open");
		return false;
	}
});
App.controller('Content', function($scope,$http) {
	$scope.mode_class = "colonnade";
	$scope.mode       = 0;
  	$scope.sections = [];
  	$http({
	    method         : "GET",
	    responseType   : "json",
	    url            : AppAccessCotroller + "themes/themes/get/" + ThemeID
	}).then(function(response) {
		$scope.sections = response.data;
	},function(error){
		console.log(error);
	});
	$scope.setHtml = function(){
		var metas = this.part.metas;
		var show_html = this.part.html_show;
		var list_show = this.part.list_show;
		var part      = this.part;
		var stringR = "";
		if($scope.mode == 1){
			for (var i in metas){
				if(metas[i].media_id != 0){
					stringR += list_show.replace("{{value}}",AppAccess + metas[i].thumb).replace("{{media_id}}", metas[i].media_id);
				}else{
					stringR += list_show.replace("{{value}}",metas[i].value);
				}	
			}
			show_html = show_html.replace("{{value}}",stringR);
		}else if($scope.mode == 0){
			stringR = '<div data-colum="'+part.ncolum+'" data-id="'+part.block_part_id+'" class="item-part-block col-md-'+part.ncolum+'"> <div class="block-part"> <h3 class="title-block">'+part.name+'</h3> <div class="menu-action" id="support_part"> <ul class="menu-block"> <li><a ng-click="PartEdit()"href="javascript:;" id="edit-part"><i class="fa fa-pencil" aria-hidden="true"></i></a></li> <li><a ng-click="PartAdd()" href="javascript:;" id="delete-part"><i class="fa fa-trash" aria-hidden="true"></i></a></li> </ul> </div> </div></div>';
		    show_html = stringR;
		}
		this.part.html = show_html;
	}
	$scope.Show_Title = function(val){
		if(val == 1 || $scope.mode == 0) return true;
		else return false;
	}
	$scope.readerHtml = function (part){
		return part.html;
	}
	$scope.SectionEdit = function(){
		console.log(this);
	}
	$scope.SectionDelete = function(){
		console.log(this);
	}
	$scope.SectionAdd = function(){
		console.log(this);
	}
	$scope.BlockEdit = function(){
		console.log(this);
	}
	$scope.BlockDelete = function(){
		console.log(this);
	}
	$scope.BlockAdd = function(){
		console.log(this);
	}
	$scope.PartEdit = function(){
		console.log(this);
	}
	$scope.PartDelete = function(){
		console.log(this);
	}
	$scope.PartAdd = function(){
		console.log(this);
	}
	$scope.sortableOptions = {
	    update: function(e, ui) {

	    },
	    axis: 'x'
	}
}).filter('trustHtml',function($sce){
  return function(html){
    return $sce.trustAsHtml(html);
  }
});
App.directive('compile', ['$compile', function ($compile) {
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
    restrict:'E',
    //The link function is responsible for registering DOM listeners as well as updating the DOM.
    link: function(scope, element, attrs) {
      	element.sortable({
	      connectWith: "parent"
	    });
	    element.addClass("sdffsdfdsfds");
    }
  };
});
String.prototype.replaceAll = function(search, replacement) {
	var target = this;
	return target.split(search).join(replacement);
}
