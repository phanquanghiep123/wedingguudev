function SC_Visual($element, $baseurl, $id, $argiems = [], action = "add", themeID) {
    this.$sectionName;
    this.$typeFile;
    this.actionUpload;
    this.$curentbox;
    this.$themeID = themeID;
    this.$ThemeInfo = {};
    this.$baseurl = $baseurl;
    this.$isAction = action;
    this.$container = $element;
    this.$modal = this.$container.find("#modal-section");
    this.$id = $id;
    this.$DataPost = {};
    this.$containerSection = '<div class="col-md-12 container-warpper id-set-ramdom-class sc-section"> <div class="sc-controler"> <div class="row"> <div class="col-md-6"> <ul class="list-inline left"><li class="list-inline-item"><a id="move-box" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop" aria-hidden="true"></i></a></li> <li class="list-inline-item"><a id="sc-not-empty-add-element" href="javascript:;"><i class="sc-composer-icon sc-c-icon-add"></i></a></li><li class="list-inline-item relative"> <a id="split-column" href="javascript:;"><i class="sc-composer-icon sc-c-icon-1-1"></i></i></a> <ul class="list-inline" id="list-colums-default"> <li class="list-inline-item"><a href="javascript:;" data-column="12"><i class="sc-composer-icon sc-c-icon-1-1"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="6 6"><i class="sc-composer-icon sc-c-icon-1-2_1-2"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="8 4"><i class="sc-composer-icon sc-c-icon-2-3_1-3"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="4 4 4"><i class="sc-composer-icon sc-c-icon-1-3_1-3_1-3"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="3 9"><i class="sc-composer-icon sc-c-icon-1-4_3-4"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="3 6 3"><i class="sc-composer-icon sc-c-icon-1-4_1-2_1-4"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="10 2"><i class="sc-composer-icon sc-c-icon-5-6_1-6"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="2 2 2 2 2 2"><i class="sc-composer-icon sc-c-icon-1-6_1-6_1-6_1-6_1-6_1-6"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="2 8 2"><i class="sc-composer-icon sc-c-icon-1-6_2-3_1-6"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="2 2 2 6"><i class="sc-composer-icon sc-c-icon-1-6_1-6_1-6_1-2"></i></a></li> </ul> </li> </ul> </div> <div class="col-md-6"> <ul class="list-inline right"> <li class="list-inline-item"><a id="arrow_drop_down" href="javascript:;"><i class="sc-composer-icon sc-c-icon-arrow_drop_down" aria-hidden="true"></i></a></li> <li class="list-inline-item relative"><a id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i></i></a></li> <li class="list-inline-item"><a href="javascript:;"><i class="sc-composer-icon sc-c-icon-content_copy"></i></i></a></li> <li class="list-inline-item"><a id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></i></a></li> </ul> </div> </div> </div> <div class="wpb_element_wrapper"> <div class="box-border-item"><div class="row section-box" id="sc-page"></div> </div></div> </div> </div>';
    this.$item = '<div class="sc-controler"> <div class="row"> <div class="col-md-12"> <ul class="list-inline left"> <li class="list-inline-item"><a id="move-box" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop" aria-hidden="true"></i></a></li><li class="list-inline-item"><a id="sc-not-empty-add-element" href="javascript:;"><i class="sc-composer-icon sc-c-icon-add"></i></a></li><li class="list-inline-item"><a id="arrow_drop_down" href="javascript:;"><i class="sc-composer-icon sc-c-icon-arrow_drop_down" aria-hidden="true"></i></a></li> <li class="list-inline-item relative"><a id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i></i></a></li> <li class="list-inline-item"><a href="javascript:;"><i class="sc-composer-icon sc-c-icon-content_copy"></i></i></a></li> <li class="list-inline-item"><a id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></i></a></li> </ul> </div> </div> </div> <div class="wpb_element_wrapper"> <div class="box-border-item"> <div class="row item-box" id="sc-page"></div> </div> </div> </div>';
    this.$argiems = $argiems;
    this.$key = null;
    this.$typeShow = "";
    this.$slider = null;
    this.$IDchangeImage = "IDchangeImage";
    this.$IDchangeBackground = "IDchangeBackground";
    this.$IDchangeVieo = "IDchangeVieo";
    this.$Snow = null;
    this.$itemDf = {
        id: "data-setup",
        name: "demo-section",
        type: "done-true",
        info: {
            class: "",
            id: "",
            style: 'margin-top[:]auto[;]margin-right[:]auto[;]margin-bottom[:]auto[;]margin-left[:]auto[;]border-width-top[:]auto[;]border-width-right[:]auto[;]border-width-bottom[:]auto[;]border-width-left[:]auto[;]padding-top[:]auto[;]padding-right[:]auto[;]padding-bottom[:]auto[;]padding-left[:]auto[;]background-color[:]transparent[;]border-color[:]transparent[;]border-style[:]0[;]border-radius[:]0[;]background-size[:]auto[;]background-image[:]none[;]background-repeat[:]no-repeat[;]text-align[:]inherit[;]'
        },
        fullcontent: 0
    };
    this.$vcstyle = 'friendly.css';
    this.$styleID = 'wpb_visual_style';
    this.$controlsSystem = $('body #sidebar');
    this.$currentSection = null;
    this.$themeStyle = {};
    this.$themeBgStyle = {};
    this.$beforethemeStyle = {};
    this.$beforethemeBgStyle = {};
    this.$beforeThemeInfo = {};
    this.SliderFont = null;
    this.beforeStyleKey = {
        "font-size": "inherit",
        "font-family": "inherit",
        "text-align": "inherit",
        "color": "inherit"
    };
    this.templateCl = {
        "name": 12,
        "text": 12,
        "wedding-day": 12,
        "slideshow": 12,
        "text-editer": 12,
        "section-title": 12,
        "story": 6,
        "ticker": 12,
        "wedding-party": 4,
        "title-editer": 12,
        "album": 4,
        "embed": 4,
        "video": 6,
        "post": 6,
        "contact": 12,
        "social": 3
    };
    this.$typeAdd = ["story","wedding-party","album","embed","post","video","social"];
    this.chooseBgcolor   = $("#" + this.$controlsSystem.attr("id") + " #box-choose-color #value-color-background");
    this.chooseFontcolor = $("#" + this.$controlsSystem.attr("id") + " #box-choose-color-tag #value-color-text");
    this.$KeyHaveFront   = ["_name_","_weddingday_","_title_","_content_"];
    this.$TypenotFront   = ["slideshow","wedding-party","album","contact"]
    this.init();
}
SC_Visual.prototype = {
    constructor: SC_Visual,
    init: function() {
        this.setup();
        this.addListener();
    },
    setup: function() {
        var _this = this;
        var htmlpage = _this.$container.html();
        _this.$container.hide();
        _this.$container.html("");
        var new_html = $('<div class="clone"><div class="inside container-warpper"> <div class="content-page"> <div class="row ui-parents" id="sc-page">' + htmlpage + '</div></div><div class="none"> <div class="content-footer"> <div class="row"> <div class="col-md-12 sc-welcome" id="sc-no-content"> <a id="sc-not-empty-add-element" class="sc-add-element-not-empty-button" title="Add Element" data-sc-element="add-element-action"> <i class="fa fa-plus-square" aria-hidden="true"></i> </a> </div> </div> </div> </div> <div class="ln_solid"></div> <div class="form-group row"> <div class="col-md-6 col-md-offset-3"> <button id="save-page-data" name="save-type" value="0" type="submit" class="btn btn-success">Lưu</button> </div> </div></div> <div class="modal fade modal-editor" id="modal-section" tabindex="-1" role="dialog" aria-labelledby="modal-tagline-1"></div><form class="none" id="form-upload-files" action="'+_this.$baseurl+'filemanager/upload.php" method="post" enctype="multipart/form-data"><input id="files-upload" type="file" name="file"><input id="files-upload" type="text" value="1" name="custom"></form></div>');
        $.each(_this.$argiems, function(key, val) {
            if (typeof val.info != "undefined"){
                if (typeof val.info.class != "undefined"){
                    new_html.find("#" + val.id).addClass(val.info.class);
                }
            }
            if(typeof val.fullcontent != "undefined" && val.fullcontent == 1){
                new_html.find("#"+val.id).addClass("fullcontent");
            }
        });
        _this.$container.html(new_html.html());
        $.each(_this.$argiems, function(key, val) {
            _this.$container.find("#" + val.id).attr("data-section-type", val.sectiontype);
            _this.$container.find("#" + val.id).attr("data-name", val.name);
            _this.$container.find("#" + val.id).find(">.sc-controler #sc-not-empty-add-element").attr("data-addnew", val.sectiontype);
        });
        _this.$container.css({
            "margin": "0 auto",
            "max-width": "100%",
            "width": "1460px",
            "float": "none",
        });
        var arg_type = _this.$vcstyle.split(".");
        _this.$container.attr("class", arg_type[0]);
        var style_tag = '<link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/bootstrap-slider/css/bootstrap-slider.min.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/css/sidebar.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/css/style.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/css/icon_sc.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/colorpicker/css/evol-colorpicker.css" />\
        <link rel="stylesheet" type="text/css" media="screen" href="/skins/plugin-sc/css/layout.css" />\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/css/ewedding.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/css/colorpicker.css" />\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/jquery-ui/jquery-ui.min.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/jquery-ui/jquery-ui.structure.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/jquery-ui/jquery-ui.theme.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/datetimepicker/jquery.datetimepicker.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/validate/validatefrom.css">\
        <link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/fancybox/dist/jquery.fancybox.css">';
        var script_tag = '<script type="text/javascript"src="/skins/plugin-sc/js/bootstrap-slider/bootstrap-slider.min.js"></script>\
        <script type="text/javascript"src="/skins/plugin-sc/js/jquery.form.js"></script>\
        <script type="text/javascript" src="/skins/plugin-sc/js/validate/validatefrom.js"></script>\
        <script type="text/javascript" src="/skins/plugin-sc/js/jquery-ui/jquery-ui.min.js"></script>\
        <script type="text/javascript" src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>\
        <script type="text/javascript" src="/skins/plugin-sc/js/tinymce/tinymce.min.js"></script>\
        <script type="text/javascript" src="/skins/plugin-sc/js/colorpicker/js/evol-colorpicker.min.js"></script>\
        <script type="text/javascript" src="/skins/plugin-sc/js/eye.js"></script>\
        <script type="text/javascript" src="/skins/plugin-sc/js/utils.js"></script>\
        <script type="text/javascript" src="/skins/plugin-sc/js/colorpicker.js"></script>\
        <script type="text/javascript" src="/skins/plugin-sc/js/datetimepicker/build/jquery.datetimepicker.full.js"></script>\
        <script type="text/javascript" src="/skins/plugin-sc/js/fancybox/dist/jquery.fancybox.js"></script>\
        <script id="map-script" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsftpjCAt1Css6h_0T-XoU_b1R-qx-kUE&libraries=places"></script>';
        $("body #sc_script").prepend(script_tag);
        $("body #sc_script").prepend(style_tag);
        $(document).ready(function() {
            _this.initloadingStyle(true);
            $.datetimepicker.setLocale('vi');                      
            _this.SliderFont = new Slider("#" + _this.$controlsSystem.attr("id") + " #range-font-size", {
                formatter: function(value) {
                    var id = $("#" + _this.$controlsSystem.attr("id") + " #list-section").val();
                    if (id != "default") {
                        var key = $("#" + _this.$controlsSystem.attr("id") + " #list-tag").val();
                        if (key != "default") {
                            $("#" + id + " " + key + "").css("font-size", value + "px");
                            $(".active-section").removeClass("active-section");
                            $("#" + id + " " + key + "").addClass("active-section");
                        }
                    }
                    return value + "px";
                }
            });
            _this.$modal = _this.$container.find("#modal-section");
        });
        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".mce-window").length || $(e.target).closest(".moxman-window").length) {
                e.stopImmediatePropagation();
            }
        });
        $("#" + _this.$container.attr("id") + " #modal-section").on('hidden.bs.modal', function(e) {
            $(_this).html("");
        });
    },
    addEventtimcolor: function() {
        $("body > .colorpicker").remove();
        this.$modal.find('.colorSelectorBg').ColorPicker({
            color: '#ffffff',
            onShow: function(colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function(colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function(hsb, hex, rgb) {
                $('#modal-setting-section #value-backgound').val('#' + hex);
                $('.colorSelectorBg > div').css('background-color', '#' + hex);
            }
        });
        this.$modal.find('.colorSelectorBd').ColorPicker({
            color: '#ffffff',
            onShow: function(colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function(colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function(hsb, hex, rgb) {
                $('#modal-setting-section #value-border').val('#' + hex);
                $('.colorSelectorBd > div').css('background-color', '#' + hex);
            }
        });
    },
    addListener: function() {
        var _this = this;
        _this.chooseBgcolor.colorpicker({
            color:'#ffffff', 
            defaultPalette:'web',
            history: false,
            hideButton:true
        });
        _this.chooseBgcolor.on("change.color", function(event, color){          
            _this.$themeBgStyle["background-image"] = "none";
            _this.$themeBgStyle["background-color"] = color;
            if (_this.$vcstyle != "cs.css") {
                $(".page-wrapper").css(_this.$themeStyle);
                $(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
            }
        });              
        _this.chooseFontcolor.colorpicker({
            color:'#ffffff',
            defaultPalette:'web',
            history: false,
            hideButton:true
        });
        _this.chooseFontcolor.on("change.color", function(event, color){          
            var id = $("#" + _this.$controlsSystem.attr("id") + " #list-section").val();
            if (id != "default") {
                var key = $("#" + _this.$controlsSystem.attr("id") + " #list-tag").val();
                if (key != "default") {
                    $("#" + id + " " + key + "").css("color",color + "!important");
                    $(".active-section").removeClass("active-section");
                    $("#" + id + " " + key + "").addClass("active-section");
                }
            }
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " .panel-body .select-option", function() {
            var parent = $(this).parent();
            parent.find("> .full-box").removeClass("block");
            var value = $(this).val();
            $.each($(this).find("option"), function() {
                if (value == $(this).attr("value")) {
                    parent.find($(this).attr("data-tagget")).addClass("block");
                }
            });
        });
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
        $(document).on("click","#"+_this.$container.attr("id")+".view #sc-box-album li img",function(){
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
        $(document).on("click","#"+_this.$container.attr("id")+".view #more-item-wedding-party",function(){
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
        $("#"+_this.$container.attr("id")+".view #modal-section").on( 'scroll', function(){
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
               $("#"+_this.$container.attr("id")+".view #modal-section .modal-header").css("top", e.scrollTop());
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
        $(document).on("click","#"+_this.$container.attr("id")+".view .more-content",function(){
            _this.$typeShow    = $(this).closest(".id-set-ramdom-class").attr("data-type");
            _this.$curentbox   = $(this).closest(".container-warpper").find(".content-template").first();
            return _this.editTemplate($(this));
        });
        $(document).on("click","#"+_this.$container.attr("id")+".view #view-item-wedding-party,#"+_this.$container.attr("id")+".view #sc-box-wedding-party",function(){
            $.fancybox.open("<div class='wedding-party-open'>"+$(this).html()+"</div>");
        });
        $(document).on("click","#"+this.$controlsSystem.attr("id") + " #show-effect",function(){
            $("#"+_this.$controlsSystem.attr("id") + " #select-effect").val(_this.$ThemeInfo["effect"]);
        });
        $(document).on("change","#"+this.$controlsSystem.attr("id") + " #select-effect",function(){
            _this.$ThemeInfo["effect"] = $(this).val();
            try {
                $.fn.snow({
                    start: false
                });
            } catch (err) {

            }
            if (_this.$vcstyle == "view.css") {
                var month11;
                if(_this.$ThemeInfo["effect"] == "0"){
                    return false;
                }
                else{
                    if(_this.$ThemeInfo["effect"] != "" && _this.$ThemeInfo["effect"] != null){
                        month11 = "/"+_this.$ThemeInfo["effect"]+"/";
                    }else{
                        var current_date11 = new Date();
                        var Timezone11 = parseInt(-current_date11.getTimezoneOffset() / 60);
                        var Lunar = convertSolar2Lunar(22, 09, 2017, Timezone11);
                        month11 = "/" + Lunar[1] + "/";
                    }
                    var argMoth = {
                        '/1/2/3': 'hoamai.png',
                        '/4/5/6': 'hoaphuong.png',
                        '/7/8/9/': 'leaf.png',
                        '/10/11/12/': 'hoatuyet.png'
                    }
                    var imgShow = '';
                    $.each(argMoth, function(key, val) {
                        if (key.indexOf(month11) != -1) {
                            imgShow = val;
                            return false;
                        }
                    });
                    $.fn.snow({
                        minSize: 10,
                        maxSize: 40,
                        newOn: 800,
                        flakeColor: '#fff',
                        html: '<img src="/skins/plugin-sc/images/' + imgShow + '">'
                    });
                }       
            }
        });
        $(document).on("keyup","#"+this.$controlsSystem.attr("id") +" #value-color-background",function(){
            $("#" + _this.$controlsSystem.attr("id") + " #box-choose-color").ColorPickerSetColor($(this).val());
            _this.$themeBgStyle["background-image"] = "none";
            _this.$themeBgStyle["background-color"] = $(this).val();
            if (_this.$vcstyle != "cs.css") {
                $(".page-wrapper").css(_this.$themeStyle);
                $(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
            }
        });
        $(document).on("keyup","#"+this.$controlsSystem.attr("id") +" #value-color-text",function(){
            $("#" + _this.$controlsSystem.attr("id") + " #box-choose-color-tag").ColorPickerSetColor($(this).val());
            var id = $("#" + _this.$controlsSystem.attr("id") + " #list-section").val();
            if (id != "default") {
                var key = $("#" + _this.$controlsSystem.attr("id") + " #list-tag").val();
                if (key != "default") {
                    $("#" + id + " " + key + "").css("color",$(this).val() + "!important");
                    $(".active-section").removeClass("active-section");
                    $("#" + id + " " + key + "").addClass("active-section");
                }
            }
        }); 
        //get modal button click
        $(document).on("click", "#" + this.$container.attr("id") + " #modal-choose-section #save-data", function() {
            var check = _this.$modal.validatefrom({
                //custom câu thông báo
                messege: {},
                //hàm chạy đầu tiên
                before: function(check, options) {},
                //hàm trước khi hiện câu thông báo
                beforeadderror: function(check, options, _childe, messege_error) {},
                //hàm sau khi hiện câu thông báo
                afteradderror: function(check, options, _childe, messege_error) {},
                //hàm kết thúc.
                after: function(check, options) {}
            });
            if (!check) return check;
            _this.$sectionName = $("#modal-choose-section #section-name").val();
            _this.$typeShow = $("#modal-choose-section #choose-section").val();
            if (_this.$typeShow == "row") {
                _this.addrow($(this));
                return true;
            } else {
                return _this.clickButton($(this));
            }

        });
        // add html by typeshow
        $(document).on("submit", "#" + this.$container.attr("id") + " #form-template", function() {
            return _this.addHtml($(this));
        });
        //add new row
        $(document).on("click", "#" + this.$container.attr("id") + " #add-section", function() {
            _this.addrow($(this));
            $("#" + _this.$controlsSystem.attr("id") + " #dezign-page-choose").val(_this.$vcstyle);
            $("#" + _this.$controlsSystem.attr("id") + " #dezign-page-choose").change();
            $("html, body").animate({
                scrollTop: $(document).height() - $(window).height()
            });
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #list-colums-default > li > a", function() {
            return _this.splitcolum($(this));
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #sc-romove-section", function() {
            _this.$currentSection = $(this).closest(".container-warpper");
            var html = '<div class="modal-dialog remove-section-box">\
            <div class="modal-content">\
               <div class="modal-header " ng-if="modal.header==true">\
                   <h4 class="modal-title ng-binding">Xóa !!!</h4>\
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>\
               </div>\
               <div class="modal-body ">Bạn muốn tiếp tuc không!</div>\
               <div class="modal-footer">\
                   <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>\
                   <button type="button" id="romove-section-now" class="btn btn-winnig">Ok</button>\</div>\
            </div>\
            </div>';
            _this.$modal.html(html);
            _this.showModal();
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #sc-order-delete", function() {
            var id = $(this).parent().attr("data-id");
            _this.$currentSection = $("#" + id);
            var html = '<div class="modal-dialog remove-section-box">\
                <div class="modal-content">\
                    <div class="modal-header " ng-if="modal.header==true">\
                        <h4 class="modal-title ng-binding">Xóa !!!</h4>\
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>\
                    </div>\
                    <div class="modal-body ">Bạn muốn tiếp tuc không!</div>\
                    <div class="modal-footer">\
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>\
                        <button type="button" id="romove-section-now" class="btn btn-winnig">Ok</button>\</div>\
                </div>\
            </div>';
            _this.$modal.html(html);
            _this.showModal();
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #romove-section-now", function() {
            _this.removesction($(this));
            _this.readySorBy();
            _this.hideModal();
        });
        $(document).on("click", "#" + this.$container.attr("id") + " .box-edit #romove-section-now", function() {
            if (_this.$vcstyle == "cs.css") {
                _this.removesction($(this));
                _this.hideModal();
            }
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #sc-not-empty-add-element", function() {
            var typeSection = $(this).attr("data-addnew");
            if (typeof typeSection !== "undefined" && typeSection != "") {
                _this.$curentbox = $(this).closest(".container-warpper").find("#sc-page").first();
                _this.isAction = "add";
                _this.$typeShow = typeSection;
                _this.clickButton($(this));
            } else {
                return _this.addSection($(this));
            }
        });
        $(document).on("click", "#" + this.$controlsSystem.attr("id") + " .sidebar-main #add-new-section", function() {
            $("#" + _this.$container.attr("id") + " .content-footer #sc-no-content #sc-not-empty-add-element").trigger("click");
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #sc-setting-section", function() {
            return _this.settingStyle($(this));
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #modal-setting-section #save-data", function() {
            return _this.saveStyle($(this));
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #sc-edit-section", function() {
            return _this.editTemplate($(this));
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #ckfinder-choose-files", function() {
            return _this.ckfinderPopup($(this));
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #photo-listing .remove", function() {
            $(this).parent().parent().remove();
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #box-show-background-image .remove", function() {
            $(this).parents(".img").remove();
            _this.$modal.find("#background-image").val("none");
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #save-page-data", function() {
            return _this.savePage($(this));
        });
        $(document).on("change", "#" + this.$container.attr("id") + " #" + this.$IDchangeImage + "", function() {
            return _this.changeImage($(this));
        });
        $(document).on("change", "#" + this.$container.attr("id") + " #" + this.$IDchangeBackground + "", function() {
            return _this.changeBackground($(this));
        });
        $(document).on("change", "#" + this.$container.attr("id") + " #" + this.$IDchangeVieo + "", function() {
            return _this.changeVieo($(this));
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #arrow_drop_down", function() {
            $(this).closest(".id-set-ramdom-class").find(".wpb_element_wrapper").first().slideToggle("slow", function() {
                $(this).closest(".id-set-ramdom-class").find(".wpb_element_wrapper").first().toggleClass("sc-none");
            });
        });

        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " .sidebar-main #dezign-page-choose", function() {
            _this.$vcstyle = $(this).val() ;
            var arg_type = _this.$vcstyle.split(".");
            _this.$container.attr("class", arg_type[0]);
            _this.loadingStyle(false);  
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " .sidebar-main #choose-my-theme", function() {
            if ($(this).val() != "default") {
                if ($(this).val() == "add") window.location.href = _this.$baseurl + "themes";
                else window.location.href = _this.$baseurl + "themes/edit/" + $(this).val();
            }
        });
        $(document).on("click", "#" + this.$controlsSystem.attr("id") + " #getlistsection", function() {
            var html = '<option value="default">--Chọn một phần--</option>';
            var name ,type;
            $.each($("#" + _this.$container.attr("id") + " .sc-section"), function(key, val) {
                name = $(this).attr("data-name");
                type = $(this).attr("data-section-type");
                if($.inArray(type, _this.$TypenotFront) == -1){
                    html += '<option value="' + $(this).attr("id") + '">' + name + '</option>';
                }
            });
            $("#" + _this.$controlsSystem.attr("id") + " #collapseFour #list-section").html(html);
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #list-section", function() {
            $("#" + _this.$controlsSystem.attr("id") + " #box-choose-style-tag").removeClass("block");
            $(".active-section").removeClass("active-section");
            var id = $(this).val();
            if (id != "default") {
                $("#" + id).find(">.wpb_element_wrapper").addClass("active-section");
                var html = '<option value="default">--Chọn một tag--</option>';

                $.each($("#" + id).find(".sc-template"), function(key) {
                    $.each($(this).find("[data-key]"), function() {
                        if ($.inArray($(this).attr("data-key"), _this.$KeyHaveFront) != -1) {
                            html += '<option value=".sc-template:eq(' + key + ') [data-key=' + $(this).attr("data-key") + ']">Tag ' + $(this).attr("data-key").replaceAll("_", "") + ' #' + (key + 1) + '</option>';
                        }
                    });
                });
                $("#" + _this.$controlsSystem.attr("id") + " #list-tag").html(html);
                $("#" + _this.$controlsSystem.attr("id") + " #list-tag").removeAttr("disabled");
                $('html, body').animate({
                    scrollTop: $("#" + _this.$container.attr("id") + " #" + id).offset().top - 30
                }, 1500);
            } else {
                $("#" + _this.$controlsSystem.attr("id") + " #list-tag").attr("disabled", true);
            }
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #list-tag", function() {
            $(".active-section").removeClass("active-section");
            var id = $("#" + _this.$controlsSystem.attr("id") + " #list-section").val();
            if (id != "default") {
                var key = $(this).val();
                if (key != "default") {
                    $("#" + id + " " + key + "").addClass("active-section");                   
                    var size = $("#" + id + " " + key + "").css("font-size");
                    if (typeof size != "undefined") {
                        _this.beforeStyleKey["font-size"] = size;
                        size = size.replace("px", "");
                        _this.SliderFont.setValue(size);
                    }
                    var family = $("#" + id + " " + key + "").css("font-family");
                    if (typeof family != "undefined") {
                        _this.beforeStyleKey["font-family"] = family;
                        family = family.replaceAll('"', "");
                        family = family.replaceAll("'", "");
                        $("#" + _this.$controlsSystem.attr("id") + " #list-font-family").val(family);
                    }
                    var color = $("#" + id + " " + key + "").css("color");
                    if (typeof color != "undefined") {
                        color = color.converHexc();
                        _this.beforeStyleKey["color"] = color;
                        _this.chooseFontcolor.colorpicker("val",color);
                    }
                    var align = $("#" + id + " " + key + "").css("text-align");
                    if (typeof align != "undefined") _this.beforeStyleKey["text-align"] = align;
                    $("#" + _this.$controlsSystem.attr("id") + " #list-vertical-align").val(align);
                    var fontweight = $("#" + id + " " + key + "").css("font-weight");
                    $("#" + _this.$controlsSystem.attr("id") + " #list-font-weight").val(fontweight);
                    $("#" + _this.$controlsSystem.attr("id") + " #box-choose-style-tag").addClass("block");
                    $('html, body').animate({
                        scrollTop: $("#" + _this.$container.attr("id") + " #" + id).find(key).offset().top - 30
                    }, 1500);
                } else {
                    $("#" + _this.$controlsSystem.attr("id") + " #box-choose-style-tag").removeClass("block");
                }
            } else {
                $("#" + _this.$controlsSystem.attr("id") + " #list-tag").attr("disabled", true);
                $("#" + _this.$controlsSystem.attr("id") + " #box-choose-style-tag").removeClass("block");
            }
        });
        $(document).on("click", "#" + this.$controlsSystem.attr("id") + " #reset-style-now", function() {
            var id = $("#" + _this.$controlsSystem.attr("id") + " #list-section").val();
            if (id != "default") {
                var key = $("#" + _this.$controlsSystem.attr("id") + " #list-tag").val();
                if (key != "default") {
                    $("#" + id + " " + key + "").css(_this.beforeStyleKey);
                    var size = _this.beforeStyleKey["font-size"].replace("px", "");
                    _this.SliderFont.setValue(size);
                    var family = _this.beforeStyleKey["font-family"];
                    family = family.replace('"', "");
                    family = family.replace("'", "");
                    $("#" + _this.$controlsSystem.attr("id") + " #list-font-family").val(family);
                    var color = _this.beforeStyleKey["color"];
                    $("#" + _this.$controlsSystem.attr("id") + " #box-choose-color-tag").ColorPickerSetColor(color);
                    var align = _this.beforeStyleKey["text-align"];
                    $("#" + _this.$controlsSystem.attr("id") + " #list-vertical-align").val(align);
                }
            }
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #list-font-family", function() {
            var id = $("#" + _this.$controlsSystem.attr("id") + " #list-section").val();
            var font = $(this).val();
            if (id != "default") {
                var key = $("#" + _this.$controlsSystem.attr("id") + " #list-tag").val();
                if (key != "default") {
                    $("#" + id + " " + key + "").css("font-family", font);
                    $(".active-section").removeClass("active-section");
                    $("#" + id + " " + key + "").addClass("active-section");
                    $('html, body').animate({
                        scrollTop: $("#" + _this.$container.attr("id") + " #" + id + " " + key + "").offset().top - 30
                    }, 100);
                }
            }
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #list-font-weight", function() {
            var id = $("#" + _this.$controlsSystem.attr("id") + " #list-section").val();
            var weight = $(this).val();
            if (id != "default") {
                var key = $("#" + _this.$controlsSystem.attr("id") + " #list-tag").val();
                if (key != "default") {
                    $("#" + id + " " + key + "").css("font-weight", weight);
                    $(".active-section").removeClass("active-section");
                    $("#" + id + " " + key + "").addClass("active-section");
                    $('html, body').animate({
                        scrollTop: $("#" + _this.$container.attr("id") + " #" + id + " " + key + "").offset().top - 30
                    }, 100);
                }
            }
        });

        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #list-vertical-align", function() {
            var id = $("#" + _this.$controlsSystem.attr("id") + " #list-section").val();
            var align = $(this).val()
            if (id != "default") {
                var key = $("#" + _this.$controlsSystem.attr("id") + " #list-tag").val();
                if (key != "default") {
                    $("#" + id + " " + key + "").css("text-align", align);
                    $(".active-section").removeClass("active-section");
                    $("#" + id + " " + key + "").addClass("active-section");
                }
            }
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #box-choose-image-upload #IDchangeBg", function() {
            var file = $(this).val();
            var arg_file = file.split("[[-]]");
            if (arg_file.length <= $(this).attr("data-multil")) {
                _this.$themeBgStyle["background-image"] = "url(" + arg_file[0] + ")";
                _this.$themeBgStyle["background-color"] = "none";
                if (_this.$vcstyle != "cs.css") {
                    $(".page-wrapper").css(_this.$themeStyle);
                    $(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
                }
                $.fancybox.close();
            } else {
                alert("Vui lòng chọn tối đa " + $(this).attr("data-multil"));
                return false;
            }
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " .sidebar-main #dezign-thems-choose", function() {
            _this.$id = $(this).val();
            _this.loadingStyle(true);
        });

        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #collapse-background .select-option", function() {
            if ($(this).val() == "default") {
                _this.$themeStyle = _this.$beforethemeStyle;
                _this.$themeBgStyle = _this.$beforethemeBgStyle;
                if (_this.$vcstyle != "cs.css") {
                    $(".page-wrapper").css(_this.$themeStyle);
                    $(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
                }
            }
            if ($(this).attr("id") == "dezign-background-image-choose" && $(this).val() == "1") {
                $("#" + _this.$controlsSystem.attr("id") + " #box-choose-image-upload #poppup-changeBg").trigger("click");
                $(this).val("default");
            }
            if ($(this).attr("id") == "dezign-background-image-choose" && $(this).val() == "2") {
                _this.actionUpload = "bg";
                _this.triggerUpload("img",$(this));
            }
        });
        
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #IDchangeEffect", function() {
            var file = $(this).val();
            var arg_file = file.split("[[-]]");
            if (arg_file.length <= $(this).attr("data-multil")) {
                _this.$ThemeInfo["effect_img"] = arg_file[0];  
                _this.installEffect();
                $.fancybox.close();
            } else {
                alert("Vui lòng chọn tối đa " + $(this).attr("data-multil"));
                return false;
            }
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #effect-theme #select-effect", function() {
            _this.$ThemeInfo["effect"] = $(this).val();
            _this.installEffect();
            if ($(this).val() == "2") {
                $("#" + _this.$controlsSystem.attr("id") + " #effect-theme #poppup-IDchangeEffect").trigger("click");
            }
            if ($(this).val() == "3") {
                _this.actionUpload = "effect";
                _this.triggerUpload("img",$(this));
            }
        });
        $(document).on("click","#" + _this.$controlsSystem.attr("id") + " #box-choose-imgeffectimg #set-effect-img",function(){
            $(this).parents("ul").find("li .active").removeClass("active");
            $(this).find("img").addClass("active");          
            _this.$ThemeInfo["effect_img"] = $(this).attr("data-source"); 
            _this.installEffect();
        });
        
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #collapse-background #dezign-background-image-bgtemplate", function() {
            _this.getListBgdata($(this));
        });
        $(document).on("click", "#" + this.$controlsSystem.attr("id") + " #collapse-background #set-bg-img", function() {
            $("#collapse-background #box-choose-image-example-load .active").removeClass("active");
            _this.$themeBgStyle["background-image"] = "url(" + $(this).attr("data-source") + ")";
            _this.$themeBgStyle["background-color"] = "none";
            if (_this.$vcstyle != "cs.css") {
                $(".page-wrapper").css(_this.$themeStyle);
                $(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
            }
            $(this).find('img').addClass("active");
        });
        $(document).on("click", "#" + this.$container.attr("id") + " #btn-order-item", function() {
            _this.$currentItem = $(this).parents(".sc-section");
            _this.itemSection($(this));
        });
        $(document).on("click", "#" + this.$controlsSystem.attr("id") + " #order-section-all", function() {
            _this.orderSections($(this));
        });
        $(document).on("click", "#" + this.$controlsSystem.attr("id") + " #save-member-theme", function() {
            _this.savePage($(this));
        });
        $(document).on("click", "#" + this.$controlsSystem.attr("id") + " #box-show-background-image .remove", function() {
            $(this).parents(".img").remove();
            $("#box-show-background-image #hero_image").val("");
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #info-theme #IDchangeHeroImage", function() {
            var file = $(this).val();
            var arg_file = file.split("[[-]]");
            if (arg_file.length <= $(this).attr("data-multil")) {
                var html = '<div class="img"><img src="' + arg_file[0] + '"><div class="action"><a href="javascript:;" class="remove"><i class="fa fa-remove" aria-hidden="true"></i></a></div></div>';
                $("#" + _this.$controlsSystem.attr("id") + " #info-theme #box-show-background-image").html(html);
                $("#" + _this.$controlsSystem.attr("id") + " #info-theme #hero_image").val(arg_file[0]);
                $.fancybox.close();
            } else {
                alert("Vui lòng chọn tối đa " + $(this).attr("data-multil"));
                return false;
            }
        });
        $(document).on({
            mouseenter: function() {
                $(".active-section").removeClass("active-section");
                $(this).parents("#friendly-data").parent().find(">.wpb_element_wrapper").addClass("active-section");
           		$(this).parents("#friendly-data").append("<p class='show-name'><span>"+$(this).closest(".sc-section").attr("data-name")+"</span></p>")
            },
            mouseleave: function() {
                $(this).parents("#friendly-data").parent().find(">.wpb_element_wrapper").removeClass("active-section");
           		$(this).parents("#friendly-data").find(".show-name").remove();
            }
        }, '#friendly-data a');
        $(document).on({
            mouseenter: function() {
                $(".active-section").removeClass("active-section");
                $(this).find(">.wpb_element_wrapper").addClass("active-section");
            	$(this).closest(".sc-section").find("#friendly-data").append("<p class='show-name'><span>"+$(this).closest(".sc-section").attr("data-name")+"</span></p>");
            },
            mouseleave: function() {
                $(this).find(">.wpb_element_wrapper").removeClass("active-section");
                $(this).closest(".sc-section").find("#friendly-data").find(".show-name").remove();
            }
        }, "#" + this.$container.attr("id") + " .sc-template");
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #select-folder-music", function() {
            _this.getListMusicByFolder($(this).val());
        });
        $(document).on("click", "#" + this.$controlsSystem.attr("id") + " #play-music", function() {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active");
                $(this).parent().html($(this).parent().html());
            } else {
                try {
                    $("#" + _this.$controlsSystem.attr("id") + " #theme-music #play-music.active").parent().find("audio")[0].pause();
                    $("#" + _this.$controlsSystem.attr("id") + " #theme-music #play-music.active").parent().find("audio")[0].currentTime = 0;
                } catch (err) {}
                $("#" + _this.$controlsSystem.attr("id") + " #theme-music #play-music.active").removeClass("active");
                $(this).addClass("active");
                setTimeout(function() {
                    $("#" + _this.$controlsSystem.attr("id") + " #theme-music #play-music.active").parent().find("audio")[0].play();
                }, 100);
            }
        });
        $(document).on("click", "#" + this.$controlsSystem.attr("id") + " #select-music:not(.active)", function() {
            $("#" + _this.$controlsSystem.attr("id") + " #theme-music #select-music.active").removeClass("active");
            $(this).addClass("active");
            _this.$ThemeInfo["music"] = $(this).attr("data-url");
            if (_this.$vcstyle == "view.css") {
                $("body #audio-bg").remove();
                $("body").append('<audio style="display:none" class="none" id="audio-bg" autoplay="true" loop><source src="' + _this.$ThemeInfo["music"] + '" type="audio/mpeg"></audio>');
            }
        });
        $(document).on("change", "#" + this.$controlsSystem.attr("id") + " #box-upload-folder-music #IDchangeMusic", function() {
            var file = $(this).val();
            var arg_file = file.split("[[-]]");
            if (arg_file.length <= $(this).attr("data-multil")) {
                _this.$ThemeInfo["music"] = arg_file[0];
                var html = '<ul class="list-items">';
                html += '<li>\
                    <p>File upload</p>\
                    <div class="action">\
                        <audio style="display:none" class="none" id="carteSoudCtrl">\
                          <source src="' + arg_file[0] + '" type="audio/mpeg">\
                        </audio>\
                        <a href="javascript:;" id="play-music"><i class="fa fa-play-circle" aria-hidden="true"></i></a>\
                    </div>\
                </li>';
                html += '</ul>';
                $("#" + _this.$controlsSystem.attr("id") + " #box-select-folder-music").html(html);
                if (_this.$vcstyle == "view.css") {
                    $("body #audio-bg").remove();
                    $("body").append('<audio style="display:none" class="none" id="audio-bg" autoplay="true" loop><source src="' + _this.$ThemeInfo["music"] + '" type="audio/mpeg"></audio>');
                }
                $.fancybox.close();
            } else {
                alert("Vui lòng chọn tối đa " + $(this).attr("data-multil"));
                return false;
            }
        });
         $(document).on("change", "#" + this.$container.attr("id") + " #form-upload-files #files-upload", function() {
            var url = _this.uploads();
            if(typeof url !== "undefined" && url != null){
                if(_this.actionUpload == "bg" ){
                    _this.$themeBgStyle["background-image"] = "url(" + url + ")";
                    _this.$themeBgStyle["background-color"] = "none";
                    if (_this.$vcstyle != "cs.css") {
                        $(".page-wrapper").css(_this.$themeStyle);
                        $(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
                    }
                }else if(_this.actionUpload == "music"){
                    _this.$ThemeInfo["music"] = url;
                    var html = '<ul class="list-items">';
                    html += '<li>\
                        <p>File upload</p>\
                        <div class="action">\
                            <audio style="display:none" class="none" id="carteSoudCtrl">\
                              <source src="' + url + '" type="audio/mpeg">\
                            </audio>\
                            <a href="javascript:;" id="play-music"><i class="fa fa-play-circle" aria-hidden="true"></i></a>\
                        </div>\
                    </li>';
                    html += '</ul>';
                    $("#" + _this.$controlsSystem.attr("id") + " #box-select-folder-music").html(html);
                    if (_this.$vcstyle == "view.css") {
                        $("body #audio-bg").remove();
                        $("body").append('<audio style="display:none" class="none" id="audio-bg" autoplay="true" loop><source src="' + _this.$ThemeInfo["music"] + '" type="audio/mpeg"></audio>');
                    }
                }else if(_this.actionUpload == "effect"){
                    _this.$ThemeInfo["effect_img"] = url;
                    _this.installEffect();
                }
            }
             
        });
    },
    getListMusicByFolder: function(folder) {
        var _this = this;
        if (folder == "default") {
            _this.$ThemeInfo["music"] = _this.$beforeThemeInfo["music"];
            $("#" + _this.$controlsSystem.attr("id") + " #box-select-folder-music").html("");
        } else if (folder == "upload") {
            $("#" + this.$controlsSystem.attr("id") + " #box-upload-folder-music #poppup-IDchangeMusic").trigger("click");
            $("#" + _this.$controlsSystem.attr("id") + " #box-select-folder-music").html("");
        } else if (folder == "upload-now"){
            _this.actionUpload = "music";
            _this.triggerUpload("music",$("#" + _this.$controlsSystem.attr("id") + " #select-folder-music"));
        } 
        else if (folder == "no") {
            _this.$ThemeInfo["music"] = "";
            $("#" + _this.$controlsSystem.attr("id") + " #box-select-folder-music").html("");
        } else {
            $.ajax({
                url: _this.$baseurl + "themes/getmusic",
                type: "post",
                dataType: "json",
                data: {
                    folder: folder
                },
                success: function(res) {
                    var html = '';
                    if (res["status"] == "success") {
                        html = '<ul class="list-items">';
                        $.each(res["response"], function(key, val) {
                            var active = val["source"] == _this.$ThemeInfo["music"] ? "active" : "";
                            html += '<li>\
                                <p>' + val["name"] + '</p>\
                                <div class="action">\
                                    <audio style="display:none" class="none" id="carteSoudCtrl">\
                                      <source src="' + val["source"] + '" type="audio/mpeg">\
                                    </audio>\
                                    <a href="javascript:;" id="play-music"><i class="fa fa-play-circle" aria-hidden="true"></i></a>\
                                    <a class="' + active + '" data-url="' + val["source"] + '" href="javascript:;" id="select-music"><i class="fa fa-heart" aria-hidden="true"></i></a>\
                                </div>\
                            </li>';
                        });
                        html += '</ul>';
                    }
                    $("#" + _this.$controlsSystem.attr("id") + " #box-select-folder-music").html(html);
                },
                error: function() {}
            });
        }
    },
    itemSection: function(e) {
        var name = e.closest(".sc-section").attr("data-name");
        var html = '<ul class="list-item" id="order-items-section">';
        $.each(this.$currentItem.find(".section-box .sc-item"), function(key, val) {
            html += '<li class="ui-state-default" data-id="' + $(this).attr("id") + '"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> Item #' + (key + 1) + '<a id="sc-order-delete" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></li>';
        });
        html += "</ul>";
        var res = '<div class="modal-dialog order-from-data" id="modal-order-item-section">\
            <div class="modal-content">\
                <div class="modal-header " ng-if="modal.header==true">\
                    <h4 class="modal-title ng-binding">Sắp xếp phần tử: ' + name + '</h4>\
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>\
                </div>\
                <div class="modal-body ">' + html + '</div>\
                <div class="modal-footer">\
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>\
               </div>\
            </div>\
        </div>';
        this.$modal.html(res);
        this.setSortableOrderItems();
        this.showModal();
    },
    orderSections: function() {
        var html = '<ul class="list-item" id="order-sections">';
        var name = "";
        $.each($("#" + this.$container.attr("id") + " .sc-section"), function(key, val) {
            name = $(this).attr("data-name");
            html += '<li class="ui-state-default" data-id="' + $(this).attr("id") + '"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'+ name +'<a id="sc-order-delete" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></li>';
        });
        var res = '<div class="modal-dialog order-from-data" id="modal-order-section">\
            <div class="modal-content">\
                <div class="modal-header " ng-if="modal.header==true">\
                    <h4 class="modal-title ng-binding">Sắp xếp thành phần</h4>\
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>\
                </div>\
                <div class="modal-body ">' + html + '</div>\
                <div class="modal-footer">\
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Đóng</button>\
               </div>\
            </div>\
        </div>';
        html += "</ul>";
        this.$modal.html(res);
        this.setSortableSection();
        this.showModal();
    },
    getListBgdata: function(e) {
        var _this = this;
        var folder = e.val();
        if (folder == "default") {
            _this.$themeStyle = _this.$beforethemeStyle;
            _this.$themeBgStyle = _this.$beforethemeBgStyle;
            if (_this.$vcstyle != "cs.css") {
                $(".page-wrapper").css(_this.$themeStyle);
                $(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
            }
            $("#" + _this.$controlsSystem.attr("id") + " #box-choose-image-example-load").html("");
            return false;
        }
        $.ajax({
            url: _this.$baseurl + "themes/getbgtemplate",
            type: "post",
            dataType: "json",
            data: {
                folder: folder
            },
            success: function(res) {
                var html = "<ul>";
                if (res["status"] == "success") {
                    $.each(res["response"], function(key, val) {
                        html += '<li class="item-img"><a id="set-bg-img" data-source="' + val["source"] + '" href="javascript:;"><img src="' + val["thumbs"] + '"></a></li>';
                    });
                }
                html += "</ul>";
                $("#" + _this.$controlsSystem.attr("id") + " #box-choose-image-example-load").html(html);
                $("#" + _this.$controlsSystem.attr("id") + " #box-choose-image-example-load").addClass("block");
            }
        });
        return false;
    },
    initloadingStyle: function(choose = false) {
        var _this = this;
        var id = (_this.$isAction == "add") ? _this.$id : _this.$themeID;
        _this.loadingDocument();
        $.each($("#" + _this.$container.attr("id") + " #friendly-data"), function() {
            $(this).remove();
        });
        if (_this.$vcstyle != "sc.css") {
            $.each($("#" + this.$container.attr("id") + " .sc-section"), function(key) {
                var dataadd     = "";
                var lengthItem  = $(this).find(".sc-item").length;
                var orderButton = "";
                var addButton  = "";
                if(true){
                    orderButton = '<a class="btn btn-info " id="btn-order-item" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop"></i> Sắp xếp</a>';
                }
                if (typeof $(this).attr("data-section-type") !== "undefined"){
                    dataadd = $(this).attr("data-section-type");
                    if(_this.$typeAdd.indexOf(dataadd) != -1){
                        addButton = '<a id="sc-not-empty-add-element" data-addnew="' + dataadd + '" href="javascript:;" class="btn btn-primary"><i class="sc-composer-icon sc-c-icon-add"></i> Thêm mới</a>';
                    }
                }else{
                    addButton = '<a id="sc-not-empty-add-element" data-addnew="' + dataadd + '" href="javascript:;" class="btn btn-primary"><i class="sc-composer-icon sc-c-icon-add"></i> Thêm mới</a>';
                } 
                
                if (_this.$vcstyle == "friendly.css") {
                    var html = '<div class="row" id="friendly-data" ><div class="col-lg-12 text-center"> <div class="button-padding">'+addButton+orderButton+'<a class="btn btn-danger" id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i> Xóa</a><a class="btn btn-success" id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i> Sửa</a></div></div>';
                    $(this).append(html);
                }               
            });
            _this.setSortablefriendly();
        } else {
            _this.setSortable();
        }
        $.ajax({
            url: _this.$baseurl + "themes/getstyle/",
            type: "post",
            dataType: "json",
            data: {
                file: _this.$vcstyle,
                id: id,
                action: _this.$isAction
            },
            success: function(res) {
                if (choose == true) {
                    _this.$themeStyle   = res["response"]["themestyle"];
                    _this.$themeBgStyle = res["response"]["themestyleBg"];
                    _this.$ThemeInfo    = res["response"]["themeInfo"];
                    if(_this.$themeBgStyle["background-color"] != "none" && _this.$themeBgStyle["background-color"] != null)
                        _this.chooseBgcolor.colorpicker("val",_this.$themeBgStyle["background-color"]);
                    $.each($("#" + _this.$controlsSystem.attr("id") + " #info-theme [name]"), function() {
                        var key = $(this).attr("name");
                        var value = _this.$ThemeInfo[key];
                        $(this).val(value);
                        $(this).attr("src", value);
                    });
                    $.each(_this.$themeStyle, function(key, val) {
                        _this.$beforethemeStyle[key] = val;
                    });
                    $.each(_this.$themeBgStyle, function(key, val) {
                        _this.$beforethemeBgStyle[key] = val;
                    });
                    $.each(_this.$ThemeInfo, function(key, val) {
                        _this.$beforeThemeInfo[key] = val;
                    });
                }
                var style = res["response"]["style"].replaceAll("#wpb_visual ", "#" + _this.$container.attr("id") + " ");
                if (_this.$vcstyle != "sc.css") {
                    $(".page-wrapper").css(_this.$themeStyle);
                    $(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
                    $.each(_this.$argiems, function(key, val) {
                        if (typeof val.info != "undefined") {
                            if (typeof val.info.style != "undefined") {
                                style += "#" + val.id + " > .wpb_element_wrapper{" + val.info.style.replaceAll("[:]", ":").replaceAll("[;]", " !important;") + "}\n";
                            }
                        }
                    });
                }
                if ($("body #sc_script #" + _this.$styleID + "").length < 1) {
                    $("body #sc_script").append('<style rel="stylesheet" type="text/css" id="' + _this.$styleID + '"></style>')
                }
                $("body #sc_script #" + _this.$styleID + "").html(style);
                var outerWidth = $("#sidebar").innerWidth();
                $(".page-wrapper .thems-bg").css({left : outerWidth +"px",top:"0px"});
                _this.$container.show();
                _this.removeloadingDocument();

            }
        });
        $.each(_this.$argiems, function(key, val) {
            _this.$container.find("#" + val.id).attr("data-name", val.name).attr("data-section-type", val.sectiontype);
            _this.$container.find("#" + val.id).find(">.sc-controler #sc-not-empty-add-element").attr("data-addnew", val.sectiontype);
        });
    },
    readySorBy: function() {
        var _this = this;
        $.each($("#" + _this.$container.attr("id") + " #friendly-data"), function() {
            $(this).remove();
        });
        if (_this.$vcstyle != "sc.css") {
            $.each($("#" + this.$container.attr("id") + " .sc-section"), function(key) {
                var dataadd = "";
                var lengthItem = $(this).find(".sc-item").length;
                var orderButton = "";
                var addButton = "";
                if(true){
                    orderButton = '<a class="btn btn-info" id="btn-order-item" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop"></i> Sắp xếp</a>';
                }
                if (typeof $(this).attr("data-section-type") !== "undefined"){
                    dataadd = $(this).attr("data-section-type");
                    if(_this.$typeAdd.indexOf(dataadd) != -1){
                        addButton = '<a id="sc-not-empty-add-element" data-addnew="' + dataadd + '" href="javascript:;" class="btn btn-primary"><i class="sc-composer-icon sc-c-icon-add"></i> Thêm mới</a>';
                    }
                }else{
                    addButton = '<a id="sc-not-empty-add-element" data-addnew="' + dataadd + '" href="javascript:;" class="btn btn-primary"><i class="sc-composer-icon sc-c-icon-add"></i> Thêm mới</a>';
                } 
                
                if (_this.$vcstyle == "friendly.css") {
                    var html = '<div class="row" id="friendly-data" ><div class="col-lg-12 text-center"> <div class="button-padding">'+addButton+orderButton+'<a class="btn btn-danger" id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i> Xóa</a><a class="btn btn-success" id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i> Sửa</a></div></div>';
                    $(this).append(html);
                }

                
            });
            _this.setSortablefriendly();
        } else {
            _this.setSortable();
        }
    },
    loadingStyle: function(choose = false) {
        var _this = this;
        _this.loadingDocument();
        $.each($("#" + _this.$container.attr("id") + " #friendly-data"), function() {
            $(this).remove();
        });
        if (_this.$vcstyle != "sc.css") {
            $.each($("#" + this.$container.attr("id") + " .sc-section"), function(key) {
                var dataadd = "";
                var lengthItem  = $(this).find(".sc-item").length;
                var orderButton = "";
                var addButton    = "";
                if(true){
                    orderButton = '<a class="btn btn-info" id="btn-order-item" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop"></i> Sắp xếp</a>';
                }
                if (typeof $(this).attr("data-section-type") !== "undefined"){
                    dataadd = $(this).attr("data-section-type");
                    if(_this.$typeAdd.indexOf(dataadd) != -1){
                        addButton = '<a id="sc-not-empty-add-element" data-addnew="' + dataadd + '" href="javascript:;" class="btn btn-primary"><i class="sc-composer-icon sc-c-icon-add"></i> Thêm mới</a>';
                    }
                }else{
                    addButton = '<a id="sc-not-empty-add-element" data-addnew="' + dataadd + '" href="javascript:;" class="btn btn-primary"><i class="sc-composer-icon sc-c-icon-add"></i> Thêm mới</a>';
                } 
                
                if (_this.$vcstyle == "friendly.css") {
                    var html = '<div class="row" id="friendly-data" ><div class="col-lg-12 text-center"> <div class="button-padding">'+addButton+orderButton+'<a class="btn btn-danger" id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i> Xóa</a><a class="btn btn-success" id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i> Sửa</a></div></div>';
                    $(this).append(html);
                }
                
            });
            _this.setSortablefriendly();
        } else {
            _this.setSortable();
        }
        $.ajax({
            url: _this.$baseurl + "themes/getstyle/",
            type: "post",
            dataType: "json",
            data: {
                file: _this.$vcstyle,
                id: _this.$id,
                action: "add"
            },
            success: function(res) {
                if (choose == true) {
                    _this.$themeStyle = res["response"]["themestyle"];
                    _this.$themeBgStyle = res["response"]["themestyleBg"];
                    _this.$ThemeInfo = res["response"]["themeInfo"];
                    $.each($("#" + _this.$controlsSystem.attr("id") + " #info-theme [name]"), function() {
                        var key = $(this).attr("name");
                        var value = _this.$ThemeInfo[key];
                        $(this).val(value);
                        $(this).attr("src", value);
                    });
                    $.each(_this.$themeStyle, function(key, val) {
                        _this.$beforethemeStyle[key] = val;
                    });
                    $.each(_this.$themeBgStyle, function(key, val) {
                        _this.$beforethemeBgStyle[key] = val;
                    });
                }
                var style = res["response"]["style"].replaceAll("#wpb_visual ", "#" + _this.$container.attr("id") + " ");
                if (_this.$vcstyle != "sc.css") {
                    $(".page-wrapper").css(_this.$themeStyle);
                    $(".page-wrapper .thems-bg").css(_this.$themeBgStyle);
                    $.each(_this.$argiems, function(key, val) {
                        if (typeof val.info != "undefined") {
                            if (typeof val.info.style != "undefined") {
                                style += "#" + val.id + " > .wpb_element_wrapper{" + val.info.style.replaceAll("[:]", ":").replaceAll("[;]", " !important;") + "}\n";
                            }
                        }
                    });
                }
                if ($("body #sc_script #" + _this.$styleID + "").length < 1) {
                    $("body #sc_script").append('<style rel="stylesheet" type="text/css" id="' + _this.$styleID + '"></style>')
                }
                $("body #sc_script #" + _this.$styleID + "").html(style);
                var outerWidth = $("#sidebar").innerWidth();
                $(".page-wrapper .thems-bg").css({left : outerWidth +"px",top:"0px"});
                _this.$container.show();
                _this.public();
                _this.removeloadingDocument();
                console.log(_this.$ThemeInfo);
            }
        });
    },
    addSection: function(e) {
        var _this = this;
        this.isAction = "add";
        this.$curentbox = e.closest(".container-warpper").find("#sc-page").first();
        $.ajax({
            url: _this.$baseurl + "themes/getmodal",
            type: "post",
            data: {
                id: "choose-section",  
            },
            success: function(res) {
                _this.$modal.html(res);
                var level = (e.parents("#sc-page").length);
                if (level > 0) _this.$modal.find("#add-section").hide();
                else _this.$modal.find("#add-section").show();
                if(_this.$vcstyle == "sc.css"){
                    _this.$modal.find("#option-row").show();
                }else{
                    _this.$modal.find("#option-row").hide();
                }
                _this.showModal();
            }
        });
    },
    addrow: function() {
        var _this = this;
        _this.$typeShow = "section";
        _this.$key = this.randomKey();;
        _this.$argiems.push({
            id: _this.$key,
            info: _this.$itemDf.info,
            type: "section",
            typeshow: _this.$typeShow,
            html: "",
            name: _this.$sectionName,
            fullcontent: 0
        });
        _this.hideModal();
        var row = $(this.$containerSection);
        row.attr("id", _this.$key);
        row.attr("data-type", "section");
        _this.$curentbox.append(row);
        _this.setSortable();
        $("#" + _this.$controlsSystem.attr("id") + " #dezign-page-choose").val(_this.$vcstyle);
        $("#" + _this.$controlsSystem.attr("id") + " #dezign-page-choose").change();
        $('html, body').animate({
            scrollTop: $("#" + _this.$key).offset().top
        }, 2000);
    },
    clickButton: function(e) {
        var _this = this;
        _this.loading(e);
        _this.$DataPost.id = _this.$typeShow;
        $.ajax({
            url: _this.$baseurl + "themes/getmodal",
            type: "post",
            data: _this.$DataPost,
            success: function(res) {
                _this.$modal.html('<form id="form-template" method="post">' + res + '</form>');
                $.each(_this.$modal.find("[set-value]"), function() {
                    if ($(this).prop("tagName").toLowerCase() != "div") {
                        if ($(this).attr("type") == 'text' || $(this).prop("tagName").toLowerCase() == "textarea") {
                            $(this).val("");
                        } else if ($(this).prop("tagName").toLowerCase() == "select") {
                            $(this).val($(this).find("option").first().attr("value"));
                        }
                    } else {
                        $(this).html("");
                    }
                });
                tinymce.remove();
                $.each(_this.$modal.find("[data-show=editer]"), function() {
                    $(this).val("");
                    tinymce.init({
                        selector: '#' + $(this).attr("id"),
                        height: 300,
                        menubar: false,
                        plugins: ['advlist autolink lists link image charmap print preview anchor', 'searchreplace visualblocks code fullscreen', 'insertdatetime media table contextmenu paste code'],
                        toolbar: ' styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
                    });
                });
                $.each(_this.$modal.find("[data-show=date]"), function() {
                    $(this).val("");
                    try {
                        $(this).datetimepicker('destroy');
                    } catch (err) {}
                    $(this).datetimepicker({
                        timepicker: false,
                        format: 'd/m/Y',
                        formatDate: 'd/m/Y',
                    });
                });
                $.each(_this.$modal.find("[data-show=time]"), function() {
                    $(this).val("");
                    try {
                        $(this).datetimepicker('destroy');
                    } catch (err) {}
                    $(this).datetimepicker({
                        datepicker: false,
                        format: 'H:i',
                        formatDate: 'H:i'
                    });
                });
                $("#" + _this.$container.attr("id") + " [data-fancybox]").fancybox({
                    iframe: {
                        css: {
                            width: '1000px',
                            height: '600px'
                        },
                    },
                    autoScale: false,
                    beforeLoad: function() {
                        if (_this.$modal.find("#photo-listing img").length >= _this.$modal.find("#" + _this.$IDchangeImage).attr("data-multil")) {
                            alert("Vui lòng xóa bớt ảnh hiện tại! số ảnh tối đa là " + _this.$modal.find("#" + _this.$IDchangeImage).attr("data-multil") + "");
                            $.fancybox.close();
                        }
                    }
                });
                $.each(_this.$modal.find("[data-show=map-of-place]"), function() {
                    var mapdiv = _this.$modal.find("#map-of-place")[0];
                    var search = _this.$modal.find("#search-places")[0];
                    var geocoder = new google.maps.Geocoder();
                    var difaultCenter = {
                        lat: -34.397,
                        lng: 150.644
                    };
                    var map = new google.maps.Map(mapdiv, {
                        center: difaultCenter,
                        zoom: 14
                    });
                    var marker = new google.maps.Marker({
                        map: map,
                        draggable: true,
                        animation: google.maps.Animation.DROP
                    });
                    var infowindow = new google.maps.InfoWindow();
                    var autocomplete = new google.maps.places.Autocomplete(search, {
                        types: ['geocode']
                    });
                    autocomplete.bindTo('bounds', map);
                    autocomplete.addListener('place_changed', function() {
                        infowindow.close();
                        marker.setVisible(false);
                        var difaultCenter = {
                            lat: -34.397,
                            lng: 150.644
                        };
                        var place = autocomplete.getPlace();
                        if (!place.geometry) {
                            window.alert("No details available for input: '" + place.name + "'");
                            return;
                        }
                        if (place.geometry.viewport) {
                            map.fitBounds(place.geometry.viewport);
                        } else {
                            map.setCenter(place.geometry.location);
                            map.setZoom(17);
                        }
                        marker.setPosition(place.geometry.location);
                        infowindow.setContent(place.formatted_address);
                        marker.setVisible(true);
                        infowindow.open(map, marker);
                        _this.$modal.find("[data-key=_mapvalue_]").val('{"name":"' + place.formatted_address + '","lat":' + place.geometry.location.lat() + ',"lng":' + place.geometry.location.lng() + '}');
                        marker.addListener('click', function() {
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
                                    infowindow.open(map, marker);
                                }
                            });
                            if (marker.getAnimation() !== null) {
                                marker.setAnimation(null);
                            } else {
                                marker.setAnimation(google.maps.Animation.BOUNCE);
                            }
                        });
                        marker.addListener('dragend', function(event) {
                            infowindow.close();
                            geocoder.geocode({
                                'latLng': {
                                    lat: event.latLng.lat(),
                                    lng: event.latLng.lng()
                                }
                            }, function(results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    if (results.length > 0) {
                                        infowindow.setContent(results[0].formatted_address);
                                        _this.$modal.find("#search-places").val(results[0].formatted_address);
                                    } else {
                                        infowindow.setContent("Not found");
                                        _this.$modal.find("#search-places").val("Not found");
                                    }
                                    infowindow.open(map, marker);
                                    _this.$modal.find("[data-key=_mapvalue_]").val('{"name":"' + results[0].formatted_address + '","lat":' + event.latLng.lat() + ',"lng":' + event.latLng.lng() + '}');
                                }
                            });
                        });
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var pos = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                };
                                infowindow.setPosition(pos);
                                infowindow.open(map);
                                map.setCenter(pos);
                            }, function() {
                                infowindow.setPosition(difaultCenter);
                            });
                        } else {
                            infowindow.setPosition(difaultCenter);
                            infoWindow.setPosition(pos);
                            infoWindow.setContent('Location found.');
                            infoWindow.open(_this.$map);
                            _this.$map.setCenter(pos);
                        }
                    });
                });
                _this.removeloading(e);
                _this.setSortableSlider();
                _this.showModal();
            }
        });
    },
    createcolums: function($n) {
        this.$key = this.randomKey();
        this.$argiems.push({
            id: this.$key,
            info: this.$itemDf.info,
            type: "item",
            typeshow: this.$typeShow,
            html: "",
            fullcontent: 0,
            name: this.$key,
            sectiontype: ""
        });
        var t = '<div class="col-md-' + $n + ' colum-sc id-set-ramdom-class container-warpper sc-item" id="' + this.$key + '" data-type="column">' + this.$item + '</div>';
        return t;
    },
    splitcolum: function(e) {
        var _this = this;
        _this.$typeShow = "column";
        var length = e.closest(".container-warpper").find("#sc-page").first().find(" > .sc-item").length - 1;
        var stringcolumns = e.attr("data-column");
        $this = e.closest(".container-warpper").find("#sc-page").first();
        e.closest(".container-warpper").find("#split-column i").attr("class", e.find("i").attr("class"));
        var arg = stringcolumns.split(" ");
        arg = arg.filter(function(n) {
            return n != undefined && n != " " && n != "" && n <= 12
        });
        arg = arg.filter(Number);
        var h = '';
        var length_arg = arg.length - 1;
        $.each(arg, function(key, val) {
            if (key <= length) {
                e.closest(".container-warpper").find("#sc-page").first().find(".sc-item:eq(" + key + ")").attr("class", "id-set-ramdom-class col-md-" + val + " container-warpper sc-item");
            } else {
                $this.append(_this.createcolums(val));
            }
        });
        e.closest(".container-warpper").find("#sc-page").first().find(".sc-item:gt(" + length_arg + ")").remove();
        _this.setSortable();
    },
    settingStyle: function(e) {
        var _this = this;
        var item = _this.$itemDf;
        _this.$curentbox = e.closest(".container-warpper");
        _this.$key = _this.$curentbox.attr("id");
        $.ajax({
            url: _this.$baseurl + "themes/getmodal",
            type: "post",
            data: {
                id: "setting"
            },
            success: function(res) {
                _this.$modal.html(res);
                $.each(_this.$argiems, function(key, val) {
                    if (typeof val.info !== "undefined") {
                        var size = Object.keys(val.info).length;
                        if (val.id == _this.$key && size > 0) {
                            item = val;
                            return false;
                        }
                    }
                });
                _this.$modal.find("[data-name = class]").val(item.info.class);
                _this.$modal.find("[data-name = id]").val(item.info.id);
                _this.$modal.find("[data-name = full-content]").val(item.fullcontent);
                _this.$modal.find("[data-name = name]").val(item.name);
                _this.$modal.find("[data-name = sectiontype]").val(item.sectiontype);
                var style = item.info.style.split('[;]');
                var item_look;
                var stringstyle = "";
                $.each(style, function(key, val) {
                    item_look = val.split('[:]');
                    if (item_look.length == 2) {
                        if (item_look[0] == "background-image") {
                            if (item_look[1] != "none") {
                                var url = item_look[1].replace("url(", "");
                                url = url.replace(")", "");
                                $("#modal-setting-section #box-show-background-image").html('<div class="img "><img src="' + url + '"><div class="action"><a href="javascript:;" class="remove"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></div></div>')
                            } else {
                                $("#modal-setting-section #box-show-background-image").html("");
                            }
                        }
                        _this.$modal.find("[data-name = '" + item_look[0] + "']").val(item_look[1].replace("px", ""));
                    }
                });
                var bg = $("#modal-setting-section #value-backgound").val();
                $('#modal-setting-section .colorSelectorBg > div').css('background-color', '#' + bg);
                var bd = $("#modal-setting-section #value-border").val();
                $('#modal-setting-section .colorSelectorBd > div').css('background-color', '#' + bd);
                var level = (e.parents("#sc-page").length);
                if (level > 1) _this.$modal.find("#box-full-content").hide();
                else _this.$modal.find("#box-full-content").show();
                _this.addEventtimcolor();
                _this.showModal();
            }
        });
    },
    saveStyle: function(e) {
        var name;
        var value;
        var style = "";
        var _this = this;
        var dataclass = "";
        var dataid = "";
        var fullcontent = 0;
        var fix = "";
        var sectionname = "";
        var sectiontype = "";
        $.each(_this.$modal.find("input[data-name],select[data-name]"), function() {
            name = $(this).attr("data-name");
            value = $(this).val();
            fix = (typeof $(this).attr("data-fix") !== "undefined" && $(this).attr("data-fix").trim() != "") ? $(this).attr("data-fix") : "";
            if (value != null && value.trim() != "") {
                if (name != "class" && name != "id" && name != "full-content" && name != "name" && name != "sectiontype") {
                    style += name + "[:]" + value + fix + "[;]";
                } else {
                    if (name == "class") {
                        dataclass = value;
                        _this.$curentbox.find("> .wpb_element_wrapper").addClass("nestss");
                        _this.$curentbox.find("> .nestss").attr("class", "wpb_element_wrapper " + value + "").removeClass("nestss");
                    }
                    if (name == "id") dataid = value;
                    if (name == "full-content") fullcontent = value;
                    if (name == "name") sectionname = value;
                    if (name == "sectiontype") sectiontype = value;
                }
            }
        })
        $.each(_this.$argiems, function(key, val) {
            if (val.id == _this.$key) {
                _this.$argiems[key].info = {};
                _this.$argiems[key].info.style = style;
                _this.$argiems[key].info.class = dataclass;
                _this.$argiems[key].info.id = dataid;
                _this.$argiems[key].fullcontent = fullcontent;
                _this.$argiems[key].name = sectionname;
                _this.$argiems[key].sectiontype = sectiontype;
                if(fullcontent == 1){
                    _this.$container.find ("#" + val.id).addClass("fullcontent");
                }else{
                    _this.$container.find ("#" + val.id).removeClass("fullcontent");
                }
                return false;
            }
        });
        if (_this.$vcstyle != "sc.css") {
            $("#" + _this.$controlsSystem.attr("id") + " #dezign-page-choose").change();
        }
        _this.hideModal();
        return false;
    },
    addHtml: function(e) {
        var _this = this;
        tinyMCE.triggerSave();
        var check = _this.$modal.validatefrom({
            //custom câu thông báo
            messege: {},
            //hàm chạy đầu tiên
            before: function(check, options) {},
            //hàm trước khi hiện câu thông báo
            beforeadderror: function(check, options, _childe, messege_error) {},
            //hàm sau khi hiện câu thông báo
            afteradderror: function(check, options, _childe, messege_error) {},
            //hàm kết thúc.
            after: function(check, options) {}
        });
        if (!check) return check;
        e.ajaxSubmit({
            url: this.$baseurl + "themes/template",
            type: "post",
            data: {
                id: this.$typeShow
            },
            beforeSubmit: function() {
                _this.loading(e.find("[type=submit]"));
            },
            success: function(res) {
                _this.removeloading(e.find("[type=submit]"));
                var colum = 12;
                var html = _this.addTemplate(res.trim());
                html = html.replaceAll("{{_key_template_}}", _this.$key);
                html = html.replaceAll("{{_type_show_}}", _this.$typeShow);
                $.each(_this.$modal.find("[set-value]"), function(key, val) {
                    if ($(this).attr("data-set") == "html") {
                        html = html.replaceAll($(this).attr("name"), $(this).html());
                    } else {
                        html = html.replaceAll($(this).attr("name"), $(this).val());
                    }
                });
                if (_this.isAction == "add") _this.$curentbox.append(html);
                if (_this.isAction == "edit") {
                    var content = $(html);
                    _this.$curentbox.html(content.find(".content-template").html());
                }
                if (_this.$vcstyle != "sc.css") {
                    $("#" + _this.$controlsSystem.attr("id") + " #dezign-page-choose").change();
                }
                _this.hideModal();
                $('html, body').animate({
                    scrollTop: $("#" + _this.$key).offset().top
                }, 2000);
            },
            error: function() {
                _this.removeloading(e.find("[type=submit]"));
            }
        });
        return false;
    },
    addTemplate: function(temp) {
        var column = 12;
        if (typeof this.templateCl[this.$typeShow] != "undefined") column = this.templateCl[this.$typeShow];
        var level = (this.$curentbox.parents("#sc-page").length);
        this.$key = this.randomKey();
        if (level == 0) {
            var key_section = this.randomKey();
            var key_column = this.randomKey();
            this.$argiems.push({
                id: key_section,
                info: this.$itemDf.info,
                type: "item",
                typeshow: "section",
                html: "",
                fullcontent: 0,
                name: this.$sectionName,
                sectiontype: this.$typeShow
            });
            this.$argiems.push({
                id: key_column,
                info: this.$itemDf.info,
                type: "item",
                typeshow: "column",
                html: "",
                fullcontent: 0,
                name: key_column,
                sectiontype: this.$typeShow
            });
            this.$argiems.push({
                id: this.$key,
                info: this.$itemDf.info,
                type: "item",
                typeshow: this.$typeShow,
                html: "",
                fullcontent: 0,
                name: this.$key,
                sectiontype: this.$typeShow
            });
            var orderButton = dataadd = addButton = bnt_action ="";
            if(true){
                orderButton = '<a class="btn btn-info " id="btn-order-item" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop"></i> Sắp xếp</a>';
            }
            if(this.$typeAdd.indexOf(this.$typeShow) != -1){
                addButton = '<a id="sc-not-empty-add-element" data-addnew="' + this.$typeShow + '" href="javascript:;" class="btn btn-primary"><i class="sc-composer-icon sc-c-icon-add"></i> Thêm mới</a>';
            }          
            if (this.$vcstyle == "friendly.css") {
                bnt_action = '<div class="row" id="friendly-data" ><div class="col-lg-12 text-center"> <div class="button-padding">'+addButton+orderButton+'<a class="btn btn-danger" id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i> Xóa</a><a class="btn btn-success" id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i> Sửa</a></div></div>';
            }
            return '<div class="col-md-12 container-warpper id-set-ramdom-class sc-section" id="' + key_section + '" data-type="section" data-name="'+this.$sectionName+'"> <div class="sc-controler"> <div class="row"> <div class="col-md-6"> <ul class="list-inline left"> <li class="list-inline-item"><a id="move-box" href="javascript:;" class="ui-sortable-handle"><i class="sc-composer-icon sc-c-icon-dragndrop" aria-hidden="true"></i></a></li> <li class="list-inline-item"><a id="sc-not-empty-add-element" href="javascript:;"><i class="sc-composer-icon sc-c-icon-add"></i></a></li> <li class="list-inline-item relative"> <a id="split-column" href="javascript:;"><i class="sc-composer-icon sc-c-icon-1-1"></i></a> <ul class="list-inline" id="list-colums-default"> <li class="list-inline-item"><a href="javascript:;" data-column="12"><i class="sc-composer-icon sc-c-icon-1-1"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="6 6"><i class="sc-composer-icon sc-c-icon-1-2_1-2"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="4 8"><i class="sc-composer-icon sc-c-icon-2-3_1-3"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="4 4 4"><i class="sc-composer-icon sc-c-icon-1-3_1-3_1-3"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="3 9"><i class="sc-composer-icon sc-c-icon-1-4_3-4"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="3 6 3"><i class="sc-composer-icon sc-c-icon-1-4_1-2_1-4"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="3 6 3"><i class="sc-composer-icon sc-c-icon-1-4_1-2_1-4"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="2 2 2 2 2 2"><i class="sc-composer-icon sc-c-icon-1-6_1-6_1-6_1-6_1-6_1-6"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="2 8 2"><i class="sc-composer-icon sc-c-icon-1-6_2-3_1-6"></i></a></li> <li class="list-inline-item"><a href="javascript:;" data-column="2 2 2 6"><i class="sc-composer-icon sc-c-icon-1-6_1-6_1-6_1-2"></i></a></li> </ul> </li> </ul> </div> <div class="col-md-6"> <ul class="list-inline right"> <li class="list-inline-item"><a id="arrow_drop_down" href="javascript:;"><i class="sc-composer-icon sc-c-icon-arrow_drop_down" aria-hidden="true"></i></a></li> <li class="list-inline-item relative"><a id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i></a></li> <li class="list-inline-item"><a href="javascript:;"><i class="sc-composer-icon sc-c-icon-content_copy"></i></a></li> <li class="list-inline-item"><a id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></li> </ul> </div> </div> </div> <div class="wpb_element_wrapper"> <div class="box-border-item"> <div class="row section-box ui-sortable" id="sc-page"> <div class="col-md-' + column + ' colum-sc id-set-ramdom-class container-warpper sc-item" id="' + key_column + '"> <div class="sc-controler"> <div class="row"> <div class="col-md-12"> <ul class="list-inline left"> <li class="list-inline-item"><a id="move-box" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop" aria-hidden="true"></i></a></li> <li class="list-inline-item"><a id="sc-not-empty-add-element" href="javascript:;"><i class="sc-composer-icon sc-c-icon-add"></i></a></li> <li class="list-inline-item"><a id="arrow_drop_down" href="javascript:;"><i class="sc-composer-icon sc-c-icon-arrow_drop_down" aria-hidden="true"></i></a></li> <li class="list-inline-item relative"><a id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i></a></li> <li class="list-inline-item"><a href="javascript:;"><i class="sc-composer-icon sc-c-icon-content_copy"></i></a></li> <li class="list-inline-item"><a id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></li> </ul> </div> </div> </div> <div class="wpb_element_wrapper"> <div class="box-border-item"> <div class="row item-box ui-sortable" id="sc-page">' + temp + '</div> </div> </div> </div> </div> </div> </div>'+bnt_action+'</div>';
        } else if (level == 1) {
            var key_column = this.randomKey();
            this.$argiems.push({
                id: key_column,
                info: this.$itemDf.info,
                type: "item",
                typeshow: "column",
                html: "",
                fullcontent: 0,
                name: key_column,
                sectiontype: this.$typeShow
            });

            this.$argiems.push({
                id: this.$key,
                info: this.$itemDf.info,
                type: "item",
                typeshow: this.$typeShow,
                html: "",
                fullcontent: 0,
                name: this.$sectionName,
                sectiontype: this.$typeShow
            });
            return '<div class="col-md-' + column + ' colum-sc id-set-ramdom-class container-warpper sc-item" id="' + key_column + '" data-type="column"> <div class="sc-controler"> <div class="row"> <div class="col-md-12"> <ul class="list-inline left"> <li class="list-inline-item"><a id="move-box" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop" aria-hidden="true"></i></a></li> <li class="list-inline-item"><a id="sc-not-empty-add-element" href="javascript:;"><i class="sc-composer-icon sc-c-icon-add"></i></a></li> <li class="list-inline-item"><a id="arrow_drop_down" href="javascript:;"><i class="sc-composer-icon sc-c-icon-arrow_drop_down" aria-hidden="true"></i></a></li> <li class="list-inline-item relative"><a id="sc-setting-section" href="javascript:;"><i class="fa fa-cog"></i></a></li> <li class="list-inline-item"><a href="javascript:;"><i class="sc-composer-icon sc-c-icon-content_copy"></i></a></li> <li class="list-inline-item"><a id="sc-romove-section" href="javascript:;"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></li> </ul> </div> </div> </div> <div class="wpb_element_wrapper"> <div class="box-border-item"> <div class="row item-box ui-sortable" id="sc-page">' + temp + '</div> </div> </div> </div>';
        } else {
            this.$argiems.push({
                id: this.$key,
                info: this.$itemDf.info,
                type: "item",
                typeshow: this.$typeShow,
                html: "",
                fullcontent: 0,
                name: this.$sectionName,
                sectiontype: this.$typeShow
            });
            return temp;
        }
    },
    editTemplate: function(e) {
        var _this = this;
        _this.isAction = "edit";
        _this.$typeShow = e.closest(".id-set-ramdom-class").attr("data-type");
        _this.$curentbox = e.closest(".container-warpper").find(".content-template").first();
        var key, value, item;
        tinymce.remove();
        $.ajax({
            url: _this.$baseurl + "themes/getmodal",
            type: "post",
            data: {
                id: _this.$typeShow
            },
            success: function(res) {
                _this.$modal.html('<form id="form-template" method="post">' + res + '</form>');
                $.each(_this.$curentbox.find("[data-key]"), function() {
                    key = $(this).attr("data-key");
                    value = $(this).html();
                    item = _this.$modal.find("[data-key='" + key + "']");
                    if (item.attr("data-set") == "html") {
                        item.html(value);
                    } else {
                        item.val(value);
                    }
                });
                tinymce.remove();
                $.each(_this.$modal.find("[data-show=editer]"), function() {
                    tinymce.init({
                        selector: '#' + $(this).attr("id"),
                        height: 300,
                        menubar: false,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table contextmenu paste code'
                        ],
                        toolbar: ' styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                    });
                });
                $.each(_this.$modal.find("[data-show=date]"), function() {
                    try {
                        $(this).datetimepicker('destroy');
                    } catch (err) {}
                    $(this).datetimepicker({
                        timepicker: false,
                        format: 'd/m/Y',
                        formatDate: 'd/m/Y'
                    });
                });
                $.each(_this.$modal.find("[data-show=time]"), function() {
                    try {
                        $(this).datetimepicker('destroy');
                    } catch (err) {}
                    $(this).datetimepicker({
                        datepicker: false,
                        format: 'H:i',
                        formatDate: 'H:i'
                    });
                });
                $("#" + _this.$container.attr("id") + " [data-fancybox]").fancybox({
                    iframe: {
                        css: {
                            width: '1000px',
                            height: '600px'
                        }
                    },
                    autoScale: false,
                    beforeLoad: function() {
                        if (_this.$modal.find("#photo-listing img").length >= _this.$modal.find("#" + _this.$IDchangeImage).attr("data-multil")) {
                            alert("Vui lòng xóa bớt ảnh hiện tại! số ảnh tối đa là " + _this.$modal.find("#" + _this.$IDchangeImage).attr("data-multil") + "");
                            $.fancybox.close();
                        }
                    }
                });
                _this.setSortableSlider();
                _this.showModal();
                $.each(_this.$modal.find("[data-show=map-of-place]"), function() {
                    var mapdiv = _this.$modal.find("#map-of-place")[0];
                    var search = _this.$modal.find("#search-places")[0];
                    var dataOld = _this.$modal.find("[data-key=_mapvalue_]").val();
                    var title = _this.$modal.find("[data-key=_title_]").val();
                    var infowindow = new google.maps.InfoWindow();
                    var geocoder = new google.maps.Geocoder();
                    dataOld = $.parseJSON(dataOld);
                    var difaultCenter = {
                        lat: dataOld.lat,
                        lng: dataOld.lng
                    };
                    var map = new google.maps.Map(mapdiv, {
                        zoom: 14
                    });
                    setTimeout(function() {
                        google.maps.event.trigger(map, "resize");
                        map.setCenter(difaultCenter);
                    }, 500);
                    var marker = new google.maps.Marker({
                        map: map,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        position: difaultCenter
                    });
                    var infowindow = new google.maps.InfoWindow();
                    infowindow.setContent(dataOld.name);
                    infowindow.open(map, marker);
                    var autocomplete = new google.maps.places.Autocomplete(search, {
                        types: ['geocode']
                    });
                    autocomplete.bindTo('bounds', map);
                    autocomplete.addListener('place_changed', function() {
                        infowindow.close();
                        marker.setVisible(false);
                        var place = autocomplete.getPlace();
                        if (!place.geometry) {
                            window.alert("No details available for input: '" + place.name + "'");
                            return;
                        }
                        if (place.geometry.viewport) {
                            map.fitBounds(place.geometry.viewport);
                        } else {
                            map.setCenter(place.geometry.location);
                            map.setZoom(17);
                        }
                        marker.setPosition(place.geometry.location);
                        infowindow.setContent(place.formatted_address);
                        marker.setVisible(true);
                        infowindow.open(map, marker);
                        _this.$modal.find("[data-key=_mapvalue_]").val('{"name":"' + place.formatted_address + '","lat":' + place.geometry.location.lat() + ',"lng":' + place.geometry.location.lng() + '}');
                    });
                    marker.addListener('click', function() {
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
                                infowindow.open(map, marker);
                            }
                        });
                        if (marker.getAnimation() !== null) {
                            marker.setAnimation(null);
                        } else {
                            marker.setAnimation(google.maps.Animation.BOUNCE);
                        }
                    });
                    marker.addListener('dragend', function(event) {
                        infowindow.close();
                        geocoder.geocode({
                            'latLng': {
                                lat: event.latLng.lat(),
                                lng: event.latLng.lng()
                            }
                        }, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results.length > 0) {
                                    infowindow.setContent(results[0].formatted_address);
                                    _this.$modal.find("#search-places").val(results[0].formatted_address);
                                } else {
                                    infowindow.setContent("Not found");
                                    _this.$modal.find("#search-places").val("Not found");
                                }
                                infowindow.open(map, marker);
                                _this.$modal.find("[data-key=_mapvalue_]").val('{"name":"' + results[0].formatted_address + '","lat":' + event.latLng.lat() + ',"lng":' + event.latLng.lng() + '}');
                            }
                        });
                    });
                });
            }
        });
    },
    ckfinderPopup: function(e) {
        var _this = this;
        var m = true;
        if (e.attr("data-multil") == "1") m = false;
        CKFinder.popup({
            selectMultiple: m,
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function(finder) {
                finder.on('files:choose', function(evt) {
                    var file = evt.data.files.models;
                    if (file.length <= e.attr("data-multil")) {
                        var html = "<ul>";
                        $.each(file, function(key, val) {
                            html += '<li class="img"> <img  src="' + val.changed.url + '"><div class="action"><a id="move-box" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop" aria-hidden="true"></i></a><a href="javascript:;" class="remove"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></div> </li>';
                            if (e.attr("data-multil") == (key + 1)) {
                                return false;
                            }
                        });
                        html += "</ul>";
                        _this.$modal.find("#photo-listing").html(html);
                        if (e.attr("data-multil") != "1") _this.setSortableSlider();
                    } else {
                        alert("Vui lòng chọn tối đa " + e.attr("data-multil"));
                        return false;
                    }
                });
                finder.on('file:choose:resizedImage', function(evt) {
                    var output = document.getElementById('output');
                    output.innerHTML = 'Selected resized image: ' + evt.data.file.get('name') + '<br>url: ' + evt.data.resizedUrl;
                });
            }
        });
    },
    ckfinderPopupOne: function(e) {
        var _this = this;
        CKFinder.popup({
            selectMultiple: false,
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function(finder) {
                finder.on('files:choose', function(evt) {
                    var file = evt.data.files.first();
                    var url = file.changed.url;
                    var html = '<div class="img"><img src="' + url + '"><div class="action"><a href="javascript:;" class="remove"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></div></div>';
                    _this.$modal.find("#box-show-background-image").html(html);
                    _this.$modal.find("#background-image").val("url(" + url + ")");
                });
                finder.on('file:choose:resizedImage', function(evt) {
                    var output = document.getElementById('output');
                    output.innerHTML = 'Selected resized image: ' + evt.data.file.get('name') + '<br>url: ' + evt.data.resizedUrl;
                });
            }
        });
    },
    removesction: function(e) {
        var argkey = [];
        if (this.$vcstyle != "sc.css" && this.$currentSection.hasClass("sc-template") == true) {
            this.$currentSection = this.$currentSection.closest(".sc-item");
        }
        this.$currentSection.remove();
        $.each($('#' + this.$container.attr("id") + " .container-warpper .container-warpper"), function() {
            argkey.push($(this).attr("id"));
        });
        var items = [];
        $.each(this.$argiems, function(key, val) {
            if ($.inArray(val.id, argkey) !== -1) {
                items.push(val);
            }
        });
        this.$argiems = items;
    },
    hideModal: function() {
        this.$modal.modal("hide");
    },
    showModal: function() {
        this.$modal.modal();
    },
    randomKey: function(len) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        for (var i = 0; i < 10; i++) text += possible.charAt(Math.floor(Math.random() * possible.length));
        var d = new Date();
        var n = d.getTime();
        return text + n;
    },
    setSortableOrderItems: function() {
        var _this = this;
        $("#wpb_visual #order-items-section").sortable({
            stop: function(event, ui) {
                var section = _this.$currentItem.find(".section-box");
                var clone = "";
                $.each($("#wpb_visual #order-items-section li"), function(key, val) {
                    clone += section.find("#" + $(this).attr("data-id"))[0].outerHTML;
                });
                section.html(clone);
                $("#" + _this.$controlsSystem.attr("id") + " #dezign-page-choose").change();
            }
        });
        $("#wpb_visual #order-items-section").disableSelection();
    },
    setSortableSection: function() {
        var _this = this;
        $("#wpb_visual #order-sections").sortable({
            stop: function(event, ui) {
                var section = $("#" + _this.$container.attr("id") + " .ui-parents#sc-page");
                var clone = "";
                $.each($("#wpb_visual #order-sections li"), function(key, val) {
                    clone += section.find("#" + $(this).attr("data-id"))[0].outerHTML;
                });
                section.html(clone);
                $("#" + _this.$controlsSystem.attr("id") + " #dezign-page-choose").change();
            }
        });
        $("#wpb_visual #order-items-section").disableSelection();
    },
    setSortable: function() {
        try {
            $('#' + this.$container.attr("id") + ' #sc-page').sortable("destroy");
        } catch (err) {}
        $('#' + this.$container.attr("id") + ' .ui-parents#sc-page').sortable({
            foscePlaceholderSize: true,
            connectWith: '.ui-parents#sc-page,.section-box#sc-page',
            items: ">.sc-section",
            cursor: 'move',
            handle: "> .sc-controler #move-box",
            opacity: 0.7,
            revert: true,
            stop: function(event, ui) {
                ui.item.attr("style", "");
            },
            start: function(e, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
            }
        });
        $('#' + this.$container.attr("id") + ' #sc-page .section-box#sc-page').sortable({
            foscePlaceholderSize: true,
            connectWith: '.section-box#sc-page',
            cursor: 'move',
            handle: "> .sc-controler #move-box",
            items: ">.sc-item",
            opacity: 0.7,
            revert: true,
            stop: function(event, ui) {
                ui.item.attr("style", "");
            },
            start: function(e, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
            }
        });
        $('#' + this.$container.attr("id") + ' #sc-page .item-box#sc-page').sortable({
            foscePlaceholderSize: true,
            connectWith: '.item-box#sc-page',
            cursor: 'move',
            handle: ".box-edit #move-box",
            items: ">.sc-template",
            opacity: 0.7,
            revert: true,
            stop: function(event, ui) {
                ui.item.attr("style", "");
            },
            start: function(e, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
            }
        });
    },
    setSortablefriendly: function(e) {
        var _this = this;
        try {
            $('#' + this.$container.attr("id") + ' #sc-page').sortable("destroy");
        } catch (err) {}
        $('#' + this.$container.attr("id") + ' .ui-parents#sc-page').sortable({
            foscePlaceholderSize: true,
            connectWith: '.ui-parents#sc-page',
            handle: "#btn-order-item",
            items: ".sc-section",
            cursor: 'move',
            opacity: 0.7,
            revert: true,
            stop: function(event, ui) {
                ui.item.attr("style", "");
                _this.readySorBy();
            },
            start: function(e, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
            }
        });
        $('#' + this.$container.attr("id") + ' .section-box#sc-page').sortable({
            foscePlaceholderSize: true,
            connectWith: '.section-box#sc-page',
            cursor: 'move',
            handle: ".box-edit #move-box",
            items: ".sc-item",
            opacity: 0.7,
            revert: true,
            stop: function(event, ui) {
                ui.item.attr("style", "");
            },
            start: function(e, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
            }
        });
    },
    setSortableSlider: function() {
        this.$slider = $('#' + this.$container.attr("id") + ' #photo-listing ul').sortable({
            foscePlaceholderSize: true,
            cursor: 'move',
            items: "li",
            handle: "#move-box",
            opacity: 0.7,
            stop: function(event, ui) {
                ui.item.attr("style", "");
            }
        });
    },
    changeImage: function(e) {
        var file = e.val();
        var arg_file = file.split("[[-]]");
        var length_li = this.$modal.find("#photo-listing").find("ul .img").length;
        var max_file = parseInt(e.attr("data-multil")) - length_li;
        if (arg_file.length <= max_file) {
            var html = "";
            if (this.$modal.find("#photo-listing").find("ul").length < 1) {
                html = "<ul>";
            }
            $.each(arg_file, function(key, val) {
                html += '<li class="img"> <img  src="' + val + '"><div class="action"><a id="move-box" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop" aria-hidden="true"></i></a><a href="javascript:;" class="remove"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></div> </li>';
                if (e.attr("data-multil") == (key + 1)) {
                    return false;
                }
            });
            if (this.$modal.find("#photo-listing").find("ul").length < 1) {
                html += "</ul>";
                this.$modal.find("#photo-listing").html(html);
            } else {
                this.$modal.find("#photo-listing ul").append(html);
            }
            if (e.attr("data-multil") != "1") this.setSortableSlider();
            $.fancybox.close();
        } else {
            alert("Vui lòng chọn tối đa " + max_file);
            return false;
        }
    },
    changeBackground: function(e) {
        var file = e.val();
        var arg_file = file.split("[[-]]");
        if (arg_file.length <= e.attr("data-multil")) {
            var html = '<div class="img"><img src="' + arg_file[0] + '"><div class="action"><a href="javascript:;" class="remove"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></div></div>';
            this.$modal.find("#box-show-background-image").html(html);
            this.$modal.find("#background-image").val("url(" + arg_file[0] + ")");
            $.fancybox.close();
        } else {
            alert("Vui lòng chọn tối đa " + e.attr("data-multil"));
            return false;
        }
    },
    changeVieo: function(e) {
        var file = e.val();
        var arg_file = file.split("[[-]]");
        if (arg_file.length <= e.attr("data-multil")) {
            var html = '<div class="item-video"><video width="100%" height="auto" controls><source src="' + arg_file[0] + '" type="video/mp4"></video><div class="action"><a href="javascript:;" class="remove"><i class="sc-composer-icon sc-c-icon-delete_empty"></i></a></div></div>';
            this.$modal.find("#photo-listing").html(html);
            $.fancybox.close();
        } else {
            alert("Vui lòng chọn tối đa " + e.attr("data-multil"));
            return false;
        }
    },
    savePage: function(e) {
        var view = e.attr("data-view");
        var _this = this;
        var sections = [];
        var section = {};
        var argkey = [];
        var items = [];
        var new_item = [];
        var style = "";
        var html_content = "";
        var set_item = _this.$argiems;
        _this.loading(e);
        var html_look = $(_this.$container.html());
        $.each(html_look.find("#public-themes-old"), function() {
            $(this).parent().html($(this).html());
        });
        $.each(html_look.find(".sc-template .box-more-content"), function() {
            $(this).remove();
        });
        $.each(html_look.find(".sc-section .box-more-button"), function() {
            $(this).remove();
        });
        $.each(html_look.find(".ui-parents > .sc-section"), function() {
            key_parent = $(this).attr("id");
            html_content = $(this).clone();
            container = $('<div></div>');
            container.append(html_content);
            $.each($(this).find(".id-set-ramdom-class"), function() {
                argkey.push($(this).attr("id"));
            });
            var i = 0;
            var fullcontent = 0,
                sectionname = "",
                sectiontype = "";
            $.each(set_item, function(key, val) {
                if ($.inArray(val.id, argkey) !== -1 || key_parent == val.id) {
                    val.order = i;
                    items.push(val);
                    if (val.info != null && typeof val.info.style !== 'undefined') {
                        style += "#" + val.id + "{" + val.info.style + ";}";
                        style = style.replaceAll("[:]", ":");
                        style = style.replaceAll("[;]", ";");
                        style = style.replaceAll(";;", ";");
                    }
                    if (key_parent == val.id) {
                        fullcontent = val.fullcontent;
                        sectionname = val.name;
                        sectiontype = val.sectiontype;
                    }
                    i++;
                } else {
                    new_item.push(val);
                }
            });
            set_item = new_item;
            new_item = [];
            section = {
                id: key_parent,
                html: container.html(),
                items: items,
                style: style,
                fullcontent: fullcontent,
                name: sectionname,
                sectiontype: sectiontype
            }
            sections.push(section);
            items = [];
            style = "";
            fullcontent = 0
        });
        var ThemsStyle = jQuery.extend({}, _this.$themeStyle, _this.$themeBgStyle);
        $.each($("#" + _this.$controlsSystem.attr("id") + " #info-theme [name]"), function() {
            var key = $(this).attr("name");
            var value = $(this).val();
            if (value != null && key != null && value.trim() != "" && key.trim() != "") {
                _this.$ThemeInfo[key] = value;
            }
        });
        _this.$ThemeInfo["style"] = ThemsStyle;
        $.ajax({
            url: _this.$baseurl + "themes/save",
            type: "post",
            dataType: "json",
            data: {
                page        : sections,
                id          : _this.$id,
                action      : _this.$isAction,
                themesID    : _this.$themeID,
                themeInfo   : _this.$ThemeInfo,
            },
            success: function(res) {
                if (res["status"] == "success") {
                    if(view == "yes"){
                        window.open(_this.$baseurl + "themes/view/" + res["id"]);
                    }
                    if (res["reload"] == true) {
                        window.location.href = _this.$baseurl + "themes/edit/" + res["id"];
                    }
                } else {
                    alert("Error!");
                }
                _this.removeloading(e);
            },
            error: function() {
                _this.removeloading(e);
            }
        })
    },
    loading: function(e) {
        e.css("position", "relative");
        e.append('<div class="loading"><img src="/skins/images/loading.gif"/></div>')
    },
    removeloading: function(e) {
        e.find(".loading").remove();
    },
    loadingDocument: function() {
        $('.builder-loading').show();
    },
    removeloadingDocument: function() {
        $('.builder-loading').fadeOut(2000);
    },
    installEffect : function (){
        var _this = this;
        try {
            $.fn.snow({
                start: false
            });
        } catch (err) {

        }
        if (_this.$vcstyle == "view.css") {
            var month11;
            if(_this.$ThemeInfo["effect"] == "0"){
                return false;
            }
            else{
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
    },
    public: function() {
        var _this = this;
        try {
            $.fn.snow({
                start: false
            });
        } catch (err) {

        }
        $.each($("#sc_script #public-script"), function() {
            $(this).remove();
        });
        $.each($("body #flake"), function() {
            $(this).remove();
        });
        $.each($("#" + _this.$container.attr("id") + " .sc-template .box-more-content"), function() {
            $(this).remove();
        });
        $.each($("#" + _this.$container.attr("id") + " .sc-section .box-more-button"), function() {
            $(this).remove();
        });
        $.each($("#" + _this.$container.attr("id") + " #public-themes-old"), function() {
            $(this).parent().html($(this).html());
        });
        $("body #box_tips_timeline").remove();
        $("body #audio-bg").remove();
        if (_this.$vcstyle == "view.css") {
              
            if (_this.$ThemeInfo["music"] != "") {
                $("body").append('<audio style="display:none" class="none" id="audio-bg" autoplay="true" loop><source src="' + _this.$ThemeInfo["music"] + '" type="audio/mpeg"></audio>');
            }
            var style_tag = '<link id="public-script" rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/jquery.bxslider/jquery.bxslider.min.css">';
            var script_tag = '<script id="public-script" type="text/javascript"src="/skins/plugin-sc/js/jquery.bxslider/jquery.bxslider.min.js"></script>\
                <script id="public-script" type="text/javascript" src="/skins/plugin-sc/js/Waterfall/newWaterfall.js"></script>\
                <script id="public-script" type="text/javascript" src="/skins/plugin-sc/js/jquery.snow.min.1.0.js"></script>\
                <script id="public-script" type="text/javascript" src="/skins/plugin-sc/js/jquery.countdown/jquery.countdown.min.js"></script>\
                <script id="public-script" type="text/javascript" src="/skins/plugin-sc/js/lunar-calendar.js"></script>\
                <script id="public-script" type="text/javascript" src="/skins/plugin-sc/js/jquery.fireworks/jquery.fireworks.js"></script>';
            $("body #sc_script").prepend(script_tag);
            $("body #sc_script").prepend(style_tag);
            var html_more = '<div class="box-more-content"><a href="javascript:;" class="more-content">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>';
            $.each($("#" + _this.$container.attr("id") + ' div[data-key="_content_"]'), function() {
                if($(this).hasClass("wedding-party-content") == false){
                    var length = $(this).text().length;
                    if(length > 450){
                        $(this).after(html_more);
                        var afterContent = $(this).text();
                        var new_content  = afterContent.slice(0, 450);
                        $(this).html(new_content + "...");
                        $(this).append('<div id="public-themes-old">'+afterContent+'</div>');
                    }
                }   
            });
            html_more = '<div class="box-more-button"><a class="btn btn-info" id="more-item-wedding-party" href="javascript:;"><i class="sc-composer-icon sc-c-icon-dragndrop"></i> Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>';
            $.each($("#" + _this.$container.attr("id") + " .sc-section[data-section-type=wedding-party]"), function() {
                var check_number_colums = $(this).find(".sc-template[data-type=wedding-party]").length;
                if (check_number_colums > 9) {
                    $(this).find(".sc-template:gt(8)").addClass("none");
                    $(this).append(html_more);
                }
            });
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
            var argFomat = {
                "day": [{
                    "%m": "Tháng"
                }, {
                    "%n": "Ngày"
                }],
                "day+hour": [{
                    "%m": "Tháng"
                }, {
                    "%n": "Ngày"
                }, {
                    "%H": "Giờ"
                }],
                "day+hour+minute": [{
                    "%m": "Tháng"
                }, {
                    "%n": "Ngày"
                }, {
                    "%H": "Giờ"
                }, {
                    "%M": "Phút"
                }],
                "day+hour+minute+seconds": [{
                    "%m": "Tháng"
                }, {
                    "%n": "Ngày"
                }, {
                    "%H": "Giờ"
                }, {
                    "%M": "Phút"
                }, {
                    "%S": "Giây"
                }],
            }
            $.each($("#" + _this.$container.attr("id") + " #sc-box-ticker"), function() {
                var title = $(this).find("[data-key=_title_]").text();
                var date = $(this).find("[data-key=_date_]").text();
                var time = $(this).find("[data-key=_time_]").text();
                var format = $(this).find("[data-key=_format_]").text();
                var argdata = date.split("/");
                var old_html = '<div id="public-themes-old">' + $(this).html() + '</div>';
                var html = '<div id="public-themes"><h2 class="sc-text-center title">' + title + '</h2><div id ="Countdown"></div></div>';
                $(this).html(old_html + html);
                var _this = $(this);
                $(this).find('#Countdown').countdown(argdata[2] + "/" + argdata[1] + "/" + argdata[0] + " " + time, function(event) {
                    var fomats = argFomat[format];
                    var html_fomat = "";
                    $.each(fomats, function(key, val) {
                        $.each(val, function(key, val) {
                           html_fomat += '<div class="item"><span class="number">'+key+'</span> <span class="text">'+val+' </span></div>';
                        });
                    })
                    var $this = $(this).html(event.strftime(html_fomat));
                }).on('update.countdown', function(ui, ev) {
                    var scellDay = (ui.offset.days);
                    var scellMonth = (ui.offset.months);
                    if (scellMonth == 0 && scellDay < 8 && _this.find("canvas").length == 0) {
                        _this.append('<div id="bg-canvas-fireworks"></div>');
                        _this.find("#bg-canvas-fireworks").fireworks();
                        _this.css("height", "200px");
                    }
                    _this.find("#Countdown span:gt(0)").addClass("active");
                    var level = 0;
                    var value = ui.offset.months;
                    var argLevel = ["tháng", "ngày", "giờ", "phút", "giây"];
                    if (ui.offset.months == 0) {
                        level++;
                        _this.find("#Countdown span:gt(0)").addClass("active");
                        value = ui.offset.days;
                        if (ui.offset.days == 0) {
                            level++;
                            _this.find("#Countdown span").removeClass("active");
                            _this.find("#Countdown span:gt(1)").addClass("active");
                            value = ui.offset.hours;
                            if (ui.offset.hours == 0) {
                                level++;
                                _this.find("#Countdown span").removeClass("active");
                                _this.find("#Countdown span:gt(2)").addClass("active");
                                value = ui.offset.minutes;
                                if (ui.offset.minutes == 0) {
                                    level++;
                                    _this.find("#Countdown span").removeClass("active");
                                    _this.find("#Countdown span:gt(3)").addClass("active");
                                    value = ui.offset.seconds;
                                    if (ui.offset.seconds == 0) {
                                        level++;
                                        _this.find("#Countdown span").removeClass("active");
                                        _this.find("#Countdown span:gt(4)").addClass("active");
                                    }
                                }
                            }
                        }
                    }
                    if (level > 0 && ui.offset.days < 8) {
                        if (_this.find(".finish-not-done").length == 0) {
                            _this.append('<h1 class="finish-not-done">Chỉ còn lại <span class="value">' + value + '</span> <span class="type">' + argLevel[level] + '</span> nữa thôi!</h1>');
                        } else {
                            _this.find('.finish-not-done .value').text(value);
                            _this.find('.finish-not-done .type').text(argLevel[level]);
                        }
                    }
                }).on('finish.countdown', function() {
                    _this.find('.finish-not-done').remove();
                    _this.find("#bg-canvas-fireworks").remove();
                    _this.append('<h1 class="finish-not-done">Đã diển ra!</span></h1>');
                }).on('stop.countdown', function() {
                    _this.find('.finish-not-done').remove();
                    _this.find("#bg-canvas-fireworks").remove();
                    _this.append('<h1 class="finish-not-done">Đã diển ra!</span></h1>');
                });
            });
            $.each($("#" + _this.$container.attr("id") + " #sc-box-slideshow"), function() {
                var old_html = '<div id="public-themes-old">' + $(this).html() + '</div>';
                _this.AddSlider($(this));
                $(this).append(old_html);
            });
            $.each($("#" + _this.$container.attr("id") + " #sc-box-timeline"), function() {
                var old_html = '<div id="public-themes-old">' + $(this).html() + '</div>';
                var lenghtItem = $(this).find(".item").length;
                if(lenghtItem > 0);
                var width = 100/lenghtItem;
                $.each($(this).find(".item"),function(){
                    $(this).append('<div class="hook_time" title="'+$(this).find(".date_timeline").text()+'" data-placement="top" data-toggle ="tooltip"></div>');
                    $(this).css("width", width +"%");
                });
                $(this).append(old_html);
            });
            $.each($("#" + _this.$container.attr("id") + " #sc-box-map-of-place"), function() {
                var old_html = '<div id="public-themes-old">' + $(this).html() + '</div>';
                var mapdiv = $(this).find("#map-of-place")[0];
                var dataOld = $(this).find("[data-key=_mapvalue_]").html();
                var infowindow = new google.maps.InfoWindow();
                var geocoder = new google.maps.Geocoder();
                dataOld = $.parseJSON(dataOld);
                var difaultCenter = {
                    lat: dataOld.lat,
                    lng: dataOld.lng
                };
                var map = new google.maps.Map(mapdiv, {
                    zoom: 14,
                    center: difaultCenter
                });
                var marker = new google.maps.Marker({
                    map: map,
                    animation: google.maps.Animation.DROP,
                    position: difaultCenter
                });
                var infowindow = new google.maps.InfoWindow();
                infowindow.setContent(dataOld.name);
                infowindow.open(map, marker);
                $(this).append(old_html);
            });
        }
    },
    AddSlider: function(e) {
        var type = e.find("[data-key=_sildertype_]").first().text();
        var s;
        switch (type) {
            case "bxslider":
                s = e.find(".sc-content-slider ul").first().bxSlider({
                    onSliderLoad: function() {
                        e.show();
                    },
                    auto: true,
                    autoStart: true
                });
                s.reloadSlider();
                break;
            default:
                break;
        }
    },
    triggerUpload: function($type,e){
        this.$typeFile = $type;
        var typeFile = {
            "img"   : ".png,.jpg,.gif,.jpeg",
            "video" : ".mp4,.webm.ogv",
            "music" : ".mp3,.wav,.mp4"
        }
        var stringType = typeFile[this.$typeFile];
        this.$container.find("#form-upload-files #files-upload").attr("accept",stringType);
        this.$container.find("#form-upload-files #files-upload").trigger("click");
    },
    uploads:function(){
        var urlFlie ;
        var typeFile = {
            "img"   : ["png","jpg","gif","jpeg"],
            "video" : ["mp4","webm","ogv"],
            "music" : ["mp3","wav","mp4"]
        }
        var arg_type = typeFile[this.$typeFile];
        if(typeof arg_type != "undefined"){
            var filename =  this.$container.find("#form-upload-files #files-upload").val();
            var extension = filename.replace(/^.*\./, '');
            var check = true;
            if (extension == filename) {
                extension = '';
            } else {
                extension = extension.toLowerCase();
            }
            if(arg_type.indexOf(extension) != -1){
                var _this = this;
                this.$container.find("#form-upload-files").ajaxSubmit({
                    //dataType : "json",
                    async : false,
                    data : {type : _this.$typeFile},
                    success: function(res){
                        urlFlie = res.trim();
                    },error:function(v,vv){
                        console.log(v);
                        console.log(v);
                    }
                }); 
            }else{
                var nameshow;
                switch ( this.$typeFile){
                    case "img" : 
                        nameshow = "ảnh";
                    break;
                    case "video" : 
                        nameshow = "video";
                    break;
                    case "music" : 
                        nameshow = "nhạc";
                    break;
                }
                this.$container.find("#form-upload-files #files-upload").trigger("click");
                alert("Vui lòng chọn file " + nameshow);
            }
        } 
        return urlFlie;    
    }
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

function initMap() {
    console.log("*_*");
}