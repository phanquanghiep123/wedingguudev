$(window).scroll(function() {
    var sticky = $('.header'),
        scroll = $(window).scrollTop();
    if (scroll >= 100) sticky.addClass('fixed');
    else sticky.removeClass('fixed');
});;
(function($) {
    var carousel = [];
    var carousel_setting = [];
    var content_width = '';
    MAIN_UI = {
        init: function() {
            this.int_content_width();
            this.int_header_scroll();
            this.int_bxslider();
            this.int_carousel_3d();
            this.int_bs_carousel_loading();
        },
        int_content_width: function() {
            content_width = $('.container').width();
        },
        int_header_scroll: function() {
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if (scroll >= 200) {
                    $(".site-header").addClass("scroll");
                    $(".navbar-transparent").removeClass("navbar-dark");
                    $(".navbar-transparent").addClass("navbar-light");
                } else {
                    $(".site-header").removeClass("scroll");
                    $(".navbar-transparent").removeClass("navbar-light");
                    $(".navbar-transparent").addClass("navbar-dark");
                }
            });
            $('.navbar-toggler').click(function(e) {
                $('body').toggleClass('nav-bar-active');
                e.preventDefault();
            });
        },
        int_bxslider: function() {
            $(".bxlsider-wrapper").each(function(i, obj) {
                var options = {};
                var wrapper = $(this);

                $(this).addClass('loading');
                options['minSlides'] = $(this).attr('data_min');
                options['maxSlides'] = $(this).attr('data_max');
                options['slideMargin'] = parseInt($(this).attr('data_gutter'));
                options['slideWidth'] = $(window).width() > 768 ? Math.round(($(this).width() - (options['maxSlides'] - 1) * options['slideMargin']) / options['maxSlides']) : $(this).width();
                options['pager'] = false;
                if($(window).width() < 767) {
                    options['pager'] = true;
                    options['controls'] = false;
                }
                options['moveSlides'] = 1;
                options['nextText'] = '<i class="fa fa-chevron-right"></i>';
                options['prevText'] = '<i class="fa fa-chevron-left"></i>';
                options['onSliderLoad'] = function() {
                    wrapper.removeClass('loading')
                };
                carousel[i] = $(this).children('.bxslider').bxSlider(options);
                carousel_setting[i] = options;
            });
            return carousel;
        },
        resize_bxslider: function() {
            if (carousel.length) {
                $.each(carousel, function(i, obj) {
                    carousel[i].destroySlider();
                });
                carousel = [];
            }
        },
        int_bs_carousel_loading: function() {
            var bs_carousel = $('.carousel').addClass('loading');
            var deferreds = [];
            var imgs = $('.carousel').find('img');
            imgs.each(function() {
                var self = $(this);
                var datasrc = self.attr('data-src');
                if (datasrc) {
                    var d = $.Deferred();
                    self.one('load', d.resolve).attr("src", datasrc).attr('data-src', '');
                    deferreds.push(d.promise());
                }
            });
            $.when.apply($, deferreds).done(function() {
                bs_carousel.removeClass('loading');
            });
        },
        int_carousel_3d: function() {
            var number;
            var height;
            var separation;
            if (content_width > 940) {
                number_item = 2;
                height = 534;
                separation = content_width / (number_item * 2);
            } else if (content_width > 720) {
                number_item = 2;
                height = 400;
                separation = 200;
            } else if (content_width > 400) {
                number_item = 1;
                height = 250;
                separation = 100;
            } else {
                number_item = 1;
                height = 140;
                separation = 100;
            }
            $('.carousel-3d').width(content_width);
            $('.carousel-3d').height(height);
            var carousel_3d = $(".carousel-3d").waterwheelCarousel({
                flankingItems: number_item,
                separation: separation,
                movedToCenter: function ($newCenterItem) {
                    $newCenterItem.next('.carousel-caption').show();
                },
                movingFromCenter: function ($oldCenterItem) {
                    $oldCenterItem.next('.carousel-caption').hide();
                },
                edgeFadeEnabled: true
            });

            $('.templates-holder #prev').on('click', function () {
			    carousel_3d.prev();
			    return false
			});
			$('.templates-holder #next').on('click', function () {
			    carousel_3d.next();
			    return false;
			});
        },
    };
    $(document).ready(function() {
        MAIN_UI.init();
        $('.site-header .menu-mobile .menu-bar').click(function(e) {
	        $('.site-header .menu-mobile .menu-list').slideToggle('slow');
	        return false;
	    });

        $(document).ajaxSuccess(function (event,xhr,options,data) {
            if(typeof data =='object'){
                console.log(data);
            }
        });
    });
    $(window).resize(function() {
        MAIN_UI.int_carousel_3d();
        MAIN_UI.int_content_width();
        MAIN_UI.resize_bxslider();
        MAIN_UI.int_bxslider();
    });
})(jQuery);
$(document).ready(function() {
    var sns_con = {
        setTitle: "",
        setUrl: "",
        getLink: function(d) {
            var url = "";
            switch (d) {
                case "twitter":
                    url = "https://twitter.com/intent/tweet?url=" + this.setUrl;
                    break;
                case "google":
                    url = "https://plus.google.com/share?url=" + this.setUrl;
                    break;
                case "linkedin":
                    url = "http://www.linkedin.com/shareArticle?mini=true&url=" + this.setUrl + "&title=" + this.setTitle;
                    break;
                default:
                    alert("error");
                    return false;
            };
            if (url != "") {
                window.open(url);
            }
        }
    };
    $(".share-facebook").each(function() {
        $(this).attr('title', 'Share Facebook');
    });
    $(document).on("click", ".share-facebook", function() {
        var title = '',
            url = '',
            image = '';
        var winWidth = 520,
            winHeight = 350;
        title = $(this).attr("data-title");
        url = $(this).attr("data-url");
        image = $(this).attr("data-image");
        var summary = $(this).attr("data-summary");
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('https://www.facebook.com/sharer.php?title=' + title + '&caption=' + title + '&u=' + url + '&picture=' + image + '&description=' + summary, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
        return false;
    });
    $(document).on("click", ".share-twitter", function() {
        title = $(this).attr("data-title");
        url = $(this).attr("data-url");
        image = $(this).attr("data-image");
        sns_con.setTitle = title;
        sns_con.setUrl = url;
        sns_con.getLink("twitter");
        return false;
    });
    $(document).on("click", ".share-google", function() {
        sns_con.setTitle = $(this).data("title");
        sns_con.setUrl = $(this).data("url");
        sns_con.getLink("google");
        return false;
    });
    $(document).on("click", ".share-linkedin", function() {
        sns_con.setTitle = $(this).data("title");
        sns_con.setUrl = $(this).data("url");
        sns_con.getLink("linkedin");
        return false;
    });
    $(document).on("click", ".share-pinterest", function() {
        var image = $(this).data("url");
        window.open('http://pinterest.com/pin/create/button/?url=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
        return false;
    });
});