var _filemanager_setting = {
    list_filemanager : [],
    index_filemanager : 0,
    value_choose : []
};
(function($){
    $.fn.extend({ 
        Scfilemanagers : function(options) {      	
            var iframe    = "/filemanager";
            var wait      = 0;
            var id_iframe = "#iframe-manager";
            var modal     = null;
            var value     = [];
            var _this     = this;
            var defaults = {
                _media   : false,
                base_url : "/",
                public   : "/skins/themes/",
                query    : {
                	type_file  : null,
                	max_file   : 1,
                    ext_filter : null
                },
                value_get : "id",
                before : function(){
                    return true;
                },  
                beforselect : function($val){
                    return true;
                },
                afterselect : function($val){
                    return true;
                },
                beforchoose : function($val){
                    return true;
                },
                afferchoose : function($val){
                    return true;
                },
                after : function($val){
                    return true;
                }
            }; 
            this._selector = _filemanager_setting.index_filemanager;
            this.options   = $.extend(defaults,options);
            this.init = function(){
                if(this.options._media == false){
                    this._selector = _filemanager_setting.index_filemanager++;
                    _filemanager_setting.list_filemanager[_this._selector] = _this;
                    var css = '<link rel="stylesheet" href="'+this.options.base_url+ "/" +this.options.public + '/filemanager/filemanager.css" rel="stylesheet" />';
                    if($("body #modal-filemanager").length < 1){
                        $("body").append('<div id="modal-filemanager" class="modal fade" role="dialog"> <div class="modal-dialog"> <!-- Modal content--> <button type="button" class="close">&times;</button><div class="modal-content"> <div class="modal-body"> <iframe id="iframe-manager" src=""></iframe> <input type="hidden" id="data-value-choose-file"></div> </div> </div> </div>');
                        $("body").append(css);
                    }
                    modal = $("#modal-filemanager");    
                    $(_this).on("click",function(){
                        var before = _this.options.before();
                        if( before == false ) return false;
                        modal.attr("data-modal",_this._selector); 
                        _this.onload();
                        modal.modal();
                    }); 
                    
                    $(document).on("click","#modal-filemanager .close",function(){
                        modal.modal("hide");  
                    });
                }
                $(document).on("change","#modal-filemanager[data-modal="+_this._selector+"] #data-value-choose-file",function(){
                    
                    if(typeof (_filemanager_setting.list_filemanager[$(this).val()]) != "undefined" && _filemanager_setting.list_filemanager[$(this).val()] != null){
                        var filemanager = (_filemanager_setting.list_filemanager[$(this).val()]);
                        var beforchoose = filemanager.options.beforchoose(_filemanager_setting.value_choose);
                        if(beforchoose == false) return false; 
                        var afferchoose = filemanager.options.afferchoose(_filemanager_setting.value_choose);
                        if(afferchoose == false) return false; 
                        _this.hide();
                        $("#modal-filemanager[data-modal="+_this._selector+"]").on("hidden.bs.modal",function(){
                           filemanager.options.after();
                        });
                        
                    }
                });
            }
            this.onload = function (){
            	this.addloadding();
            	$("#iframe-manager").hide();
                var get_send = "";
                for (var i in this.options.query){  
                    if(this.options.query[i] != null && this.options.query[i] != "null"){
                        get_send +="&"+i+"="+ this.options.query[i];
                    }    
                }
                iframe_url = this.options.base_url + iframe + "?is_iframe=true"+get_send + "&selector="+this._selector;      
                modal.find(id_iframe).attr("src",iframe_url);
                $("#iframe-manager").load(function(){
                	$(this).show();
                	_this.remove_loadding();
                });
            }
            this.actionchange = function($v1,$v2){
                window.parent._filemanager_setting.value_choose = $v2;    
                var modal_filemanager = window.parent.$('#modal-filemanager');
                modal_filemanager.find("#data-value-choose-file").val($v1).change();
            } 
            this.hide = function(){
                modal.modal("hide"); 
            }
            this.addloadding = function (){
			    modal.find(".modal-body").append('<div id="loading-ajax" class="display-table"><div class="display-cell"><div class="loader"></div></div></div>');
			}
			this.remove_loadding = function (){
			    modal.find(".modal-body #loading-ajax").remove();
			}
            this.init();
            return this;
        }
    });
})(jQuery);