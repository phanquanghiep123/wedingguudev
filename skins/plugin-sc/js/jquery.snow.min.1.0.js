/**
 * jquery.snow - jQuery Snow Effect Plugin
 *
 * Available under MIT licence
 *
 * @version 1 (21. Jan 2012)
 * @author Ivan Lazarevic
 * @requires jQuery
 * @see http://workshop.rs
 *
 * @params minSize - min size of snowflake, 10 by default
 * @params maxSize - max size of snowflake, 20 by default
 * @params newOn - frequency in ms of appearing of new snowflake, 500 by default
 * @params flakeColor - color of snowflake, #FFFFFF by default
 * @example $.fn.snow({ maxSize: 200, newOn: 1000 });
 */
 var interval;
(function($)
{
	$.fn.snow = function(options)
	{
		var defaults = {
			minSize: 10,
			maxSize: 20,
			newOn: 300,
			flakeColor: "#FFFFFF",
			html : '&#10052;',
			start:true

		},
		options = $.extend(
		{}, defaults, options),
		$flake = $('<div id="flake" />').css({'position': 'fixed'}).html(options.html);
		var left,top,totop,toleft,width_left,width_top,delayleft,delaytop;
		var arg = ["","rotateX","rotateY","rotate"];
		if(options.start == true){
			interval  = setInterval(function()
			{   var key_ram      = 1 * Math.floor(Math.random() * 4);
				var height       = $(window).height();
				var width        = $(window).width();
				var startOpacity = 0.5 + Math.random();
				var sizeFlake    = options.minSize + Math.random() * options.maxSize,
				left       =  Math.floor(Math.random() * width);
				top        =  Math.floor(Math.random() * height);
			    totop      =  Math.floor(Math.random() * height);
			    toleft     =  Math.floor(Math.random() * width);
				width_left = (left - toleft) > 0 ? (left - toleft) : (toleft - left );
				width_top  = (top - totop) > 0 ? (top - totop) : (top - totop );
				delayleft  = width_left * 10 + Math.random() * 8000;
				delaytop   = height * 10 + Math.random() * 8000;
				var sizeFlakes    = options.minSize + Math.random() * options.maxSize;
				$flake.css({
					top:-20,
					left:left,
					'font-size': sizeFlake,
					color: options.flakeColor,
				});
				$flake.find("img").css({
					opacity: startOpacity,
					width:sizeFlake
				}).animate(
					{ width :sizeFlakes },
					{ duration: delaytop,queue: false},
				);
				$flake.clone().appendTo("body").addClass(arg[key_ram]).animate(
					{ left : toleft } ,
					{	duration: delayleft,
						queue: false,
						complete : function(){
						 	width        = $(window).width();
						    startOpacity = 0.5 + Math.random();
							left          =  Math.floor(Math.random() * width);
						    toleft        =  Math.floor(Math.random() * width);
							width_left    = (left - toleft) > 0 ? (left - toleft) : (toleft - left );
							delayleft     = width_left * 10 + Math.random() * 8000;
							$(this).animate( { left : toleft  },{duration: delayleft,queue: false , complete:function(){
							 	width        = $(window).width();
							    startOpacity = 0.5 + Math.random();
								left          =  Math.floor(Math.random() * width);
							    toleft        =  Math.floor(Math.random() * width);
								width_left    = (left - toleft) > 0 ? (left - toleft) : (toleft - left );
								delayleft     = width_left * 10 + Math.random() * 8000;
							}})
						}
					}
				).animate(
					{ top : height,opacity: 0.2 },
					{ 
						duration: delaytop,
						queue: false,
						complete : function(){
							$(this).remove();
						}
					}
				)
			}, options.newOn);
			return true;
		}else{
			clearInterval(interval); 
			return false
		}
	   
	};
})(jQuery);