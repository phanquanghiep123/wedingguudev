function SC_Visual($element,$baseurl,$id,$argiems = [],action="add",themeID) {
    this.$curentbox;
    this.$themeID            = themeID;
    this.$ThemeInfo          = {};
    this.$baseurl    		 = $baseurl;
    this.$isAction           = action;
    this.$container    		 = $element; 
    this.$modal  			 = this.$container.find("#modal-section"); 
    this.$id    			 = $id; 
    this.$containerSection   = '<div class="col-md-12 container-warpper id-set-ramdom-class sc-section"> <div class="sc-controler"> <div class="row"> <div class="col-md-6"> <ul class="list-inline left"><li class="list-inline-item"><a id="move-box" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop" aria-hidden="true"></i></a></li> <li class="list-inline-item"><a id="sc-not-empty-add-element" href="javascript:;"><i class="sc-composer-icon sc-c-icon-add"></i></a></li><li class="list-inline-item relative"> <a id="split-column" href="javascript:;"><i class="sc-composer-icon sc-c-icon-1-1"></i></i></a> <ul class="list-inline" id="list-colums-default"> <li class="list-inline-item"><a href="javascript:;" data-column="12"><i class="sc-composer-icon sc-c-icon-1-1"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="6 6"><i class="sc-composer-icon sc-c-icon-1-2_1-2"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="8 4"><i class="sc-composer-icon sc-c-icon-2-3_1-3"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="4 4 4"><i class="sc-composer-icon sc-c-icon-1-3_1-3_1-3"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="3 9"><i class="sc-composer-icon sc-c-icon-1-4_3-4"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="3 6 3"><i class="sc-composer-icon sc-c-icon-1-4_1-2_1-4"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="10 2"><i class="sc-composer-icon sc-c-icon-5-6_1-6"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="2 2 2 2 2 2"><i class="sc-composer-icon sc-c-icon-1-6_1-6_1-6_1-6_1-6_1-6"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="2 8 2"><i class="sc-composer-icon sc-c-icon-1-6_2-3_1-6"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="2 2 2 6"><i class="sc-composer-icon sc-c-icon-1-6_1-6_1-6_1-2"></i></a></li> </ul> </li> </ul> </div> <div class="col-md-6"> <ul class="list-inline right"> <li class="list-inline-item"><a id="arrow_drop_down" href="javascript:;"><i class="sc-composer-icon sc-c-icon-arrow_drop_down" aria-hidden="true"></i></a></li> <li class="list-inline-item relative"><a id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i></i></a></li> <li class="list-inline-item"><a href="javascript:;"><i class="sc-composer-icon sc-c-icon-content_copy"></i></i></a></li> <li class="list-inline-item"><a id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></i></a></li> </ul> </div> </div> </div> <div class="wpb_element_wrapper"> <div class="box-border-item"><div class="row section-box" id="sc-page"></div> </div></div> </div> </div>';
    this.$item  = '<div class="sc-controler"> <div class="row"> <div class="col-md-12"> <ul class="list-inline left"> <li class="list-inline-item"><a id="move-box" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop" aria-hidden="true"></i></a></li><li class="list-inline-item"><a id="sc-not-empty-add-element" href="javascript:;"><i class="sc-composer-icon sc-c-icon-add"></i></a></li><li class="list-inline-item"><a id="arrow_drop_down" href="javascript:;"><i class="sc-composer-icon sc-c-icon-arrow_drop_down" aria-hidden="true"></i></a></li> <li class="list-inline-item relative"><a id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i></i></a></li> <li class="list-inline-item"><a href="javascript:;"><i class="sc-composer-icon sc-c-icon-content_copy"></i></i></a></li> <li class="list-inline-item"><a id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></i></a></li> </ul> </div> </div> </div> <div class="wpb_element_wrapper"> <div class="box-border-item"> <div class="row item-box" id="sc-page"></div> </div> </div> </div>';
    this.$argiems            = $argiems;
    this.$key                = null;
    this.$typeShow           = "";    
    this.$slider             = null;
    this.$IDchangeImage      = "IDchangeImage";
    this.$IDchangeBackground = "IDchangeBackground";
    this.$IDchangeVieo       = "IDchangeVieo";
    this.$itemDf             = {
    	id   : "data-setup",
    	type : "done-true",
    	info : {class : "", id:"", style:'margin-top[:][;]margin-right[:][;]margin-bottom[:][;]margin-left[:][;]border-width-top[:][;]border-width-right[:][;]border-width-bottom[:][;]border-width-left[:][;]padding-top[:][;]padding-right[:][;]padding-bottom[:][;]padding-left[:][;]background-color[:]transparent[;]border-color[:]transparent[;]border-style[:]0[;]border-radius[:]0[;]background-size[:]auto[;]background-image[:]none[;]background-repeat[:]no-repeat[;]text-align[:]inherit[;]'},
    	fullcontent : 0
    };
    this.$vcstyle          = 'view.css';
    this.$styleID          = 'wpb_visual_style';
    this.$controlsSystem   = $('body #sidebar');
    this.$currentSection   = null;
    this.$themeStyle         = {};
    this.$themeBgStyle       = {};
    this.$beforethemeStyle   = {};
    this.$beforethemeBgStyle = {};
    this.SliderFont          = null;
    this.$scroll = 0;
    this.beforeStyleKey      = {"font-size":"inherit","font-family":"inherit","text-align":"inherit","color":"inherit"};
    this.templateCl          = {
    	"name" 			: 12,
    	"text" 			: 12,
    	"wedding-day" 	: 12,
    	"slideshow" 	: 12,
    	"text-editer"	: 12,
    	"section-title" : 12,
    	"story" 		: 6,
    	"ticker" 		: 12,
    	"wedding-party" : 4,
    	"title-editer"  : 12,
    	"album"         : 4,
    	"embed"    		: 4,
    	"video"   		: 6,
    	"post"     		: 6,
    	"contact"  		: 12,
    	"social"   		: 3
    };
    this.init();
    
}
SC_Visual.prototype = {
	constructor: SC_Visual,
	init : function (){
		this.setup();
		this.addListener();
	},
	setup:function (){
		var _this = this;
		_this.$container.hide();
		_this.$container.css({"margin": "0 auto","max-width": "100%","width":"1460px","float":"none","overflow":"hidden"});
		$(document).on("click","#list-time-line .item .hook_time",function(){
            $("body #box_tips_timeline").remove();
            if($(this).hasClass("open-timeline") == true){
                $(this).removeClass("open-timeline");
            }else{
                $(this).addClass("open-timeline");
                var box_tips_timeline = $('<div id="box_tips_timeline"><h1 class="name-item"></h1><p class="date-item"></p><div class="thumb-item"></div><div class="content-item"></div></div>');
                var width_box = 400;
                var offset = $(this).offset();
                var parent = $(this).parent();
                var topt  = offset.top;
                var leftt = offset.left;
                box_tips_timeline.css({"width": width_box+"px","top":(topt - width_box)+"px","left":(leftt - ((width_box-20)/2)) + "px"});
                box_tips_timeline.find(".name-item").html(parent.find(".name_timeline").html());
                box_tips_timeline.find(".date-item").html(parent.find(".date_timeline").html());
                box_tips_timeline.find(".thumb-item").html(parent.find(".thumb_timeline").html());
                box_tips_timeline.find(".content-item").html(parent.find(".description_timeline").html());
                $("body").append(box_tips_timeline);
                var height = $("body #box_tips_timeline").innerHeight();
                $("body #box_tips_timeline").css({"top": (topt - height - 10)+"px"})
                $("body #box_tips_timeline").animate({opacity:1},3000);
            }
            return false 
        });
		$(document).ready(function(){
			var menubar = "";
			$.each(_this.$container.find(".sc-section .sc-item #sc-box-section-title"),function(){
				var id = $(this).closest(".container-warpper").attr("id");
				menubar +='<li><a href="javascript:;" data-id="'+id+'"><i class="fa fa-check" aria-hidden="true"></i> '+$(this).find(".title").text()+'</a></li>';
			});
			$("#menu-hamburger-right #content-menu-hamburger").html(menubar);
			_this.initloadingStyle(true);		
		});		 
		$(window) .load(function(){
		 	$.each($("#"+_this.$container.attr("id")+" #sc-box-slideshow"),function(){
				_this.AddSlider($(this));
			});		 	
		});
		$("#"+_this.$container.attr("id")+" #modal-section").on('hidden.bs.modal', function (e) {
			_this.$scroll = 0;
		  	$(_this).html("");
		});
	},
	addListener : function(){
		var _this = this;	
		$( window ).scroll(function() {
		  	var top_document = $(window).scrollTop();
		  	$.each(_this.$container.find(".sc-section .sc-item #sc-box-section-title"),function(){
		  		var top_element = $(this).offset().top ;
		  		if((top_element - 30) <= top_document && top_document <= (top_element+30)){
		  			var id = $(this).closest(".container-warpper").attr("id");
		  			$("#box-menu-hamburger #content-menu-hamburger li a").removeClass("active");
		  			$("#box-menu-hamburger #content-menu-hamburger li a[data-id="+id+"]").addClass("active");
		  		}
		  	});
		});
		$(document).on("click","#menu-hamburger-right #content-menu-hamburger li a",function(){
			$("#menu-hamburger-right #content-menu-hamburger li a").removeClass("active");
			$(this).addClass("active");
        	var id = $(this).attr("data-id");
        	$('html, body').animate({
                scrollTop: $("#" + _this.$container.attr("id") + " #" + id).offset().top
            }, 1000);
        });
        $(document).on("click","#menu-hamburger-right #content-menu-setting a",function(){
        	$(this).toggleClass("active");
        });
        $(document).on("click","#menu-hamburger-right #content-menu-setting #select-off-on-music",function(){
        	$(this).toggleClass("of-music");
        	if($(this).hasClass("of-music")){
        		$(".content-page #carteSoudCtrl")[0].pause();
        	}else{
        		$(".content-page #carteSoudCtrl")[0].play();
        	}
        });
        $(document).on("click","#menu-hamburger-right #content-menu-setting #select-off-on-active",function(){
        	$.ajax({
        		url : _this.$baseurl + "themes/un_and_on_active",
        		type:"post",
        		dataType:"json",
        		data: {id :_this.$themeID},
        		success : function(res){
        			if(res["status"] == "error") alert("Có lỗi xãy ra vui lòng thử lại!");
        		}
        	})
        });
        $(document).on("click","#menu-hamburger-right #content-menu-setting #select-off-on-effect",function(){
        	$(this).toggleClass("of-effect");
        	if($(this).hasClass("of-effect")){
        		try {
		            $.fn.snow({
		                start: false
		            });
		        } catch (err) { }
		        $.each($("body #flake"), function() {
		            $(this).remove();
		        });
        	}else{
        		var month11;
	            if(_this.$ThemeInfo["effect"] !== "0"){ 
	                if(_this.$ThemeInfo["effect"] == "default" ){
	                    var current_date11 = new Date();
	                    var Timezone11 = parseInt(-current_date11.getTimezoneOffset() / 60);
	                    var Lunar = convertSolar2Lunar(22, 09, 2017, Timezone11);
	                    month11 = "/" + Lunar[1] + "/";
	                    var argMoth = {
	                        '/1/2/3': 'hoamai.png',
	                        '/4/5/6': 'hoaphuong.png',
	                        '/7/8/9/': 'leaf.png',
	                        '/10/11/12/': 'hoatuyet.png'
	                    }                  
	                    $.each(argMoth, function(key, val) {
	                        if (key.indexOf(month11) != -1) {
	                            _this.$ThemeInfo["effect_img"]  = '/skins/plugin-sc/images/'+val;
	                            return false;
	                        }
	                    });
	                }
	                if(_this.$ThemeInfo["effect_img"] != null){
	                    try {
	                        $.fn.snow({
	                            minSize: 10,
	                            maxSize: 40,
	                            newOn: 800,
	                            flakeColor: '#fff',
	                            html: '<img src="' + _this.$ThemeInfo["effect_img"] + '">'
	                        });
	                    }catch (err) { }
	                }    
	            } 
        	}
        });
        $(document).on("click","#box-menu-hamburger #icon-cog-section",function(){   
            $("#content-menu-hamburger").removeClass("open");
            $("#content-menu-setting").toggleClass("open");
            $("#box-menu-hamburger #icon-list-section.is-active").toggleClass("is-active");
            if($("#menu-hamburger-right .open").length > 0 ){
                $("#menu-hamburger-right").addClass("open-menu");  
            }else{
                $("#menu-hamburger-right").removeClass("open-menu");  
            }
            $(this).toggleClass("is-active");     
        });
        $(document).on("click","#box-menu-hamburger #icon-list-section",function(){  
            $("#content-menu-setting").removeClass("open");
            $("#content-menu-hamburger").toggleClass("open");
            $("#box-menu-hamburger #icon-cog-section.is-active").toggleClass("is-active");
            if($("#menu-hamburger-right .open").length > 0 ){
                $("#menu-hamburger-right").addClass("open-menu");  
            }else{
                $("#menu-hamburger-right").removeClass("open-menu");  
            }
            $(this).toggleClass("is-active");
        });
		$(document).on("click","#"+_this.$container.attr("id")+" #sc-box-album li img",function(){
			_this.$currentSection = $(this).parents("#sc-box-album");
			var title = _this.$currentSection.find("[data-key=_title_]").text();
			var html = '<div class="modal-dialog add-item-html modal-grid-sc" id="content-album-slider">\
						    <div class="modal-content" style="min-height:'+( $(window).height() + 40)+'px">\
						        <div class="modal-header ">\
						            <h4 class="modal-title ng-binding">'+title+'</h4>\
						             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
						        </div>\
						        <div class="">\
						            <div class="modal-body ">\
						               	<div class="row">  <ul id="waterfall">';
			$.each (_this.$currentSection.find(".sc-content-album ul li"),function(key,val){
				if((key + 1) < 10){
					var img = $(this).find('img').attr("src")
					html +='<li><div><a href="'+img+'" data-fancybox>'+$(this).html()+'</a></div></li>' ;
				}
			});
			html += '</ul></div></div></div></div>';
			_this.$modal.html(html);
			_this.$modal.find('#waterfall').NewWaterfall({
                width: 360,
                delay: 100,
            });
			_this.showModal();
			
		});
		$(document).on("click","#"+_this.$container.attr("id")+" #more-item-wedding-party",function(){
			_this.$currentSection = $(this).closest(".sc-section");
			var html = '<div class="modal-dialog add-item-html modal-grid-sc" id="content-wedding-slider">\
						    <div class="modal-content" style="min-height:'+( $(window).height() + 40)+'px">\
						        <div class="modal-header ">\
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
						        </div>\
						        <div class="">\
						            <div class="modal-body ">\
						               	<div class="row">  <ul id="waterfall">';
			$.each (_this.$currentSection.find(".wpb_element_wrapper .section-box .sc-item #sc-box-wedding-party"),function(key,val){
				if((key + 1) < 10){
					html +='<li id="view-item-wedding-party"><div>'+$(this).html()+'</div></li>' ;
				}
			});
			html += '</ul></div></div></div></div>';
			_this.$modal.html(html);
			_this.$modal.find('#waterfall').NewWaterfall({
                width: 360,
                delay: 100,
            });
			_this.showModal();
			
		});
        var loading = false;
        $("#"+_this.$container.attr("id")+" #modal-section").on( 'scroll', function(){
		   	var type = "";
          	if($("#"+_this.$container.attr("id")+" #content-album-slider #waterfall").length > 0 ) type  = "waterfall";
          	if($("#"+_this.$container.attr("id")+" #content-wedding-slider #waterfall").length > 0 ) type  = "wedding";
		  	if(type == "waterfall" ){
		  	   var e = $(this);
		  	   $("#"+_this.$container.attr("id")+" #modal-section .modal-header").css("top", e.scrollTop());
		  	   if (e[0].scrollHeight - e.scrollTop() == e.height() && !loading)
	           {
	                loading = true;
	                _this.$scroll++;
	                var item_next = (_this.$scroll * 9);
	                var length_li = _this.$currentSection.find(".sc-content-album ul li").length;
	                if( item_next < length_li){
	                	var affter = item_next + 9;
	                	var html = "";
	                	$.each (_this.$currentSection.find(".sc-content-album ul li"),function(key,val){
							if((key + 1) > item_next  && (key ) <= affter){
								var img = $(this).find('img').attr("src")
								html +='<li><div><a href="'+img+'" data-fancybox>'+$(this).html()+'</a></div></li>' ;
							}
						});
						_this.$modal.find("#waterfall").append(html);
						 
	                }
	                loading = false;
	            }
		  	}
		  	if(type == "wedding" ){
		  	   var e = $(this);
		  	   $("#"+_this.$container.attr("id")+" #modal-section .modal-header").css("top", e.scrollTop());
		  	   if (e[0].scrollHeight - e.scrollTop() == e.height() && !loading)
	           {
	                loading = true;
	                _this.$scroll++;
	                var item_next = (_this.$scroll * 9);
	                var length_li = _this.$currentSection.find(".wpb_element_wrapper .section-box .sc-item #sc-box-wedding-party").length;
	                if( item_next < length_li){
	                	var affter = item_next + 9;
	                	var html = "";
	                	$.each (_this.$currentSection.find(".wpb_element_wrapper .section-box .sc-item #sc-box-wedding-party"),function(key,val){
							if((key + 1) > item_next  && (key ) <= affter){
								html +='<li id="view-item-wedding-party"><div>'+$(this).html()+'</div></li>' ;
							}
						});
						_this.$modal.find("#waterfall").append(html);
						 
	                }
	                loading = false;
	            }
		  	}
		});
		$(document).on("click","#"+_this.$container.attr("id")+" .more-content",function(){
			_this.$typeShow    = $(this).closest(".id-set-ramdom-class").attr("data-type");
			_this.$curentbox   = $(this).closest(".container-warpper").find(".content-template").first();
			return _this.editTemplate($(this));
		});
		$(document).on("click","#"+_this.$container.attr("id")+" #view-item-wedding-party,#"+_this.$container.attr("id")+" #sc-box-wedding-party",function(){
			$.fancybox.open("<div class='wedding-party-open'>"+$(this).html()+"</div>");
		});
	},
	hideModal : function(){
		this.$modal.modal("hide");
	},
	showModal : function(){
		this.$modal.modal();
	},
	AddSlider : function(e){
		var type = e.find("[data-key=_sildertype_]").text();
		switch(type) {
		    case "bxslider":
		        var s =  e.find(".sc-content-slider ul").bxSlider({
		        	onSliderLoad:function(){
		        	  e.show();  
		        	},
		        	auto : true,
		        	autoStart: true
		        });
		        s.reloadSlider();
		        break;
		    
		    default:
		        break;
		}
	},
	editTemplate : function (e){
		var _this          = this;
		_this.isAction     = "edit";
		var key,value;
		tinymce.remove();
		$.ajax({
			url  : _this.$baseurl + "themes/getmodalview",
			type : "post",
			data : {id : _this.$typeShow},
			success : function (res){
				$.each(_this.$curentbox.find("[data-key]"),function(){
                    key   = $(this).attr("data-key");
                    value = $(this).html();
                    if($(this).find("#public-themes-old").length > 0){
                        value = $(this).find("#public-themes-old").html();
                    }
                    res = res.replaceAll("{{"+key+"}}",value);
				});
                _this.$modal.html(res);
				_this.showModal();
			}
		});			
	},
	initloadingStyle : function(choose = false){
		var _this = this;
		var id = (_this.$isAction == "add") ? _this.$id : _this.$themeID; 
		_this.loadingDocument();
		$.each( $("#"+_this.$container.attr("id")+" #friendly-data") ,function(){
			$(this).remove();
		});
		var html_more = '<div class="box-more-content"><a href="javascript:;" class="more-content">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>';
        $.each($("#" + _this.$container.attr("id") + ' div[data-key="_content_"]'), function() {
            if($(this).hasClass("wedding-party-content") == false){
                var length = $(this).text().length;
                if(length > 550){
                    $(this).after(html_more);
                    var afterContent = $(this).text();
                    var new_contentold  = $(this).html();
                    var new_content  = afterContent.slice(0, 550);
                    $(this).html(new_content +"...");
                    $(this).append('<div id="public-themes-old">'+new_contentold+'</div>');
                }
            }   
        });
	    html_more = '<div class="box-more-button"><a class="btn btn-info" id="more-item-wedding-party" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop"></i> Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>';
		$.each( $("#"+_this.$container.attr("id")+" .sc-section[data-section-type=wedding-party]") ,function(){
			var check_number_colums = $(this).find(".sc-template[data-type=wedding-party]").length ;
			if(check_number_colums > 9){
				$(this).find(".sc-template:gt(8)").addClass("none");
				$(this).append(html_more);
			}
		});
		
		var argFomat ={
			"day" : [{"%m":"Tháng"},{"%n":"Ngày"}],
			"day+hour" : [{"%m":"Tháng"},{"%n":"Ngày"},{"%H":"Giờ"}],
			"day+hour+minute" : [{"%m":"Tháng"},{"%n":"Ngày"},{"%H":"Giờ"},{"%M":"Phút"}],
			"day+hour+minute+seconds" : [{"%m":"Tháng"},{"%n":"Ngày"},{"%H":"Giờ"},{"%M":"Phút"},{"%S":"Giây"}],
		}
		$.each( $("#"+_this.$container.attr("id")+" #sc-box-ticker") ,function(){
			var title = $(this).find("[data-key=_title_]").text();
			var date = $(this).find("[data-key=_date_]").text();
			var time = $(this).find("[data-key=_time_]").text();
			var format = $(this).find("[data-key=_format_]").text();
			var argdata = date.split("/");
			var html = '<h2 class="sc-text-center title">'+title+'</h2><div id ="Countdown"></div>';
			$(this).html(html);
			var _this = $(this);
			$(this).find('#Countdown').countdown(argdata[2] +"/"+ argdata[1] +"/"+ argdata[0] + " " + time , function(event) {
			  var fomats = argFomat[format];
			  var html_fomat = "";
			  $.each(fomats,function(key,val){
			  	$.each (val,function(key,val){
			  		html_fomat += '<div class="item"><span class="number">'+key+'</span> <span class="text">'+val+' </span></div>';
			  	});			  	
			  })
			  var $this = $(this).html(event.strftime(html_fomat));
			}).on('update.countdown', function(ui,ev){
				var scellDay   = ui.offset.totalDays ;
				var scellMonth = (ui.offset.months);
				if(scellMonth == 0 && scellDay < 8 && _this.find("canvas").length == 0){
					_this.append('<div id="bg-canvas-fireworks"></div>');
					_this.find("#bg-canvas-fireworks").fireworks();
					_this.css("height","200px");				
				}
				_this.find("#Countdown span:gt(0)").addClass("active");	
			    var level = 0;
				var value = ui.offset.months;
				var argLevel = ["tháng","ngày","giờ","phút","giây"];				
				if(ui.offset.months == 0){
					level ++;
					_this.find("#Countdown span:gt(0)").addClass("active");	
					value = ui.offset.totalDays;
					if(ui.offset.totalDays == 0){
						level ++;
						_this.find("#Countdown span").removeClass("active");
						_this.find("#Countdown span:gt(1)").addClass("active");	
						value = ui.offset.totalHours;
						if(ui.offset.totalHours == 0){
							level ++;
							_this.find("#Countdown span").removeClass("active");
							_this.find("#Countdown span:gt(2)").addClass("active");	
							value = ui.offset.totalMinutes;
							if(ui.offset.totalMinutes == 0){
								level ++;
								_this.find("#Countdown span").removeClass("active");
								_this.find("#Countdown span:gt(3)").addClass("active");	
								value = ui.offset.totalSeconds;
								if(ui.offset.totalSeconds == 0){
									level ++; 
								    _this.find("#Countdown span").removeClass("active");
									_this.find("#Countdown span:gt(4)").addClass("active");			
								}
							}		
						}									
					}
				}
				if(level > 0 && ui.offset.days < 8 ){
					if(_this.find(".finish-not-done").length == 0){
						_this.append('<h1 class="finish-not-done">Chỉ còn lại <span class="value">'+value+'</span> <span class="type">'+argLevel[level]+'</span> nữa thôi!</h1>');
					}else{
						_this.find('.finish-not-done .value').text(value);
						_this.find('.finish-not-done .type').text(argLevel[level]);
					}	
				}	
			}).on('finish.countdown', function(){
				_this.find('.finish-not-done').remove();
				_this.find("#bg-canvas-fireworks").remove();
				_this.append('<h1 class="finish-not-done">Đã diển ra!</span></h1>');	
			}).on('stop.countdown', function(){
				_this.find('.finish-not-done').remove();
				_this.find("#bg-canvas-fireworks").remove();
				_this.append('<h1 class="finish-not-done">Đã diển ra!</span></h1>');
			});			
		});
		$.each ( $("#"+_this.$container.attr("id")+" .sc-controler"),function(){
			$(this).remove();
		});
		$.each ( $("#"+_this.$container.attr("id")+" .box-edit"),function(){
			$(this).remove();
		});
		$.each ( $("#"+_this.$container.attr("id")+" .ui-sortable"),function(){
			$(this).removeClass("ui-sortable");
		});
		$.each ( $("#"+_this.$container.attr("id")+" .action"),function(){
			$(this).remove();
		});
		$.each($("#" + _this.$container.attr("id") + " #sc-box-timeline"), function() {
            var lenghtItem = $(this).find(".item").length;
            if(lenghtItem > 0);
            var width = 100/lenghtItem;
            $.each($(this).find(".item"),function(){
                $(this).append('<div class="hook_time" title="'+$(this).find(".date_timeline").text()+'" data-placement="top" data-toggle ="tooltip"></div>');
                $(this).css("width", width +"%");
            });
        });

		$(window).load(function(){
            $.each($("#"+_this.$container.attr("id")+" #sc-box-map-of-place"),function(){
				var mapdiv  = $(this).find("#map-of-place")[0];
				var infowindow = new google.maps.InfoWindow();
				var geocoder = new google.maps.Geocoder();
				var dataOld = $(this).find("[data-key=_mapvalue_]").text();				
				dataOld = $.parseJSON(dataOld);
				var difaultCenter = {lat: dataOld.lat, lng: dataOld.lng};
				var map = new google.maps.Map(mapdiv,{
	  				zoom: 14,
	  				center : difaultCenter
				});
			    var marker = new google.maps.Marker({
					map: map,
					animation: google.maps.Animation.DROP,
					position:difaultCenter
		        });
		        var infowindow = new google.maps.InfoWindow();
		        infowindow.setContent(dataOld.name);
		        infowindow.open(map, marker);
						
			});
   		});
		$.ajax({
			url  : _this.$baseurl+"themes/getstyle/",
		    type : "post",
		    dataType : "json",
		    data:{file :"public.css",id:id,action:_this.$isAction},
		    success: function(res){
				if(choose == true){
					_this.$themeStyle   = res["response"]["themestyle"];
    				_this.$themeBgStyle = res["response"]["themestyleBg"];
    				_this.$ThemeInfo    = res["response"]["themeInfo"];
    				 
				}
				var style = res["response"]["style"].replaceAll("#wpb_visual ","#"+_this.$container.attr("id")+" ");
				if(_this.$vcstyle != "sc.css"){
					$(".page-wrapper").css(_this.$themeStyle);
					$(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
					$.each(_this.$argiems,function(key ,val){ 
						if(typeof val.info != "undefined"){
							if(typeof val.info.style != "undefined"){
								style += "#"+val.id+" > .wpb_element_wrapper{"+val.info.style.replaceAll("[:]",":").replaceAll("[;]"," !important;")+"}\n";
							}
						}
					});
				}
				if($("body #sc_script #"+_this.$styleID+"").length < 1){
					$("body #sc_script").append('<style rel="stylesheet" type="text/css" id="'+_this.$styleID+'"></style>')
				}
				$("body #sc_script #"+_this.$styleID+"").html(style);
				var outerWidth = $("#sidebar").innerWidth();
				$(".page-wrapper .thems-bg").css({left:"0px",top:"0px"});
				_this.$container.show();
				$.each($("#"+_this.$container.attr("id")+' div#sc-box-story [data-key="_content_"]'),function(){
					$(this).addClass("more-success");
					var html_more = '<div class="box-more-content"><a href="javascript:;" class="more-content">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>';
					$(this).after(html_more);
				});
				if(_this.$ThemeInfo["effect"] !== "0"){ 
	                if(_this.$ThemeInfo["effect"] == "default" ){
	                    var current_date11 = new Date();
	                    var Timezone11 = parseInt(-current_date11.getTimezoneOffset() / 60);
	                    var Lunar = convertSolar2Lunar(22, 09, 2017, Timezone11);
	                    month11 = "/" + Lunar[1] + "/";
	                    var argMoth = {
	                        '/1/2/3': 'hoamai.png',
	                        '/4/5/6': 'hoaphuong.png',
	                        '/7/8/9/': 'leaf.png',
	                        '/10/11/12/': 'hoatuyet.png'
	                    }                  
	                    $.each(argMoth, function(key, val) {
	                        if (key.indexOf(month11) != -1) {
	                            _this.$ThemeInfo["effect_img"]  = '/skins/plugin-sc/images/'+val;
	                            return false;
	                        }
	                    });
	                }
	                if(_this.$ThemeInfo["effect_img"] != null){
	                    try {
	                        $.fn.snow({
	                            minSize: 10,
	                            maxSize: 40,
	                            newOn: 800,
	                            flakeColor: '#fff',
	                            html: '<img src="' + _this.$ThemeInfo["effect_img"] + '">'
	                        });
	                    }catch (err) { }
	                }    
	            } 
				_this.removeloadingDocument();
		    }
		});	
		$('[data-toggle="tooltip"]').tooltip();
	},
	loadingDocument : function(){
		$('.builder-loading').show();
	},
	removeloadingDocument:function(){
		$('.builder-loading').fadeOut(2000);
	},

};
String.prototype.replaceKeyAll = function(array) {
	var target = this;
	for (var key in array) {
		target = target.replaceAll(key, array[key]);
	}
	return target;
}
String.prototype.replaceAll = function(search, replacement) {
	var target = this;
	return target.split(search).join(replacement);
};
String.prototype.converHexc = function() {
    var parts = this.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    delete(parts[0]);
    for (var i = 1; i <= 3; ++i) {
        parts[i] = parseInt(parts[i]).toString(16);
        if (parts[i].length == 1) parts[i] = '0' + parts[i];
    }
    color = '#' + parts.join('');
    return color;
}