

/*$(document).on("click","body #open-filemanager",function(){
	modal.modal();
});*/

(function($){
    $.fn.extend({ 
        Scfilemanager: function(options) {
        	var css = '<link rel="stylesheet" href="/css/filemanager.css" rel="stylesheet" />';
            var iframe_url = "/medias";
            var defaults = {
                base_url : "/",
                query    : {
                	type_file : "all",
                	max_files : 1
                },
                value_get : "id",
                before : function(){

                },
                beforselect : function($val){

                },

                afterselect : function($val){

                },
                beforchoose : function($val){

                }
                afferchoose : function($val){

                }
                after : function($val){

                }
            };   
            var options = $.extend(defaults, options);
            this.init = function(){
            	var get_send = "";
            	for (var i in options.query){
            		get_send +="&"+i+"="+ options.query[i];
            	}
            	iframe_url = options.base_url + iframe_url + "?"+get_send;
            	$("body").append('<div id="modal-filemanager" class="modal fade" role="dialog"> <div class="modal-dialog"> <!-- Modal content--> <div class="modal-content"> <div class="modal-body"> <iframe id="iframe-manager" src="'+iframe_url+'"></iframe> <input type="hidden" id="data-value-choose-file"> <button type="button" class="close" data-dismiss="modal">&times;</button> </div> </div> </div> </div>');
            	$("body").append(css);
            }
            this.init();
        }
    });
})(jQuery);