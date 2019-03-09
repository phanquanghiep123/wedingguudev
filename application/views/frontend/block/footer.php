                    </main>
                </div>
            </div>
            <!-- /. page -->
            <?php if(!(isset($is_login) && $is_login)): ?>
                <?php $this->load->view($this->asset.'/block/login-account'); ?>
            <?php endif; ?>
            <footer id="colophon" class="site-footer" role="contentinfo">
                <div class="container">
                    <div class="footer-top">
                        <div class="row">
                            <div class="footer-top-1 col-sm-4">
                                <div class="widget">
                                    <?php echo @$setting['footer1']; ?> 
                                </div>
                            </div>
                            <div class="footer-top-2 col-sm-4">
                                <div class="widget">
                                    <?php echo @$setting['footer2']; ?> 
                                </div>
                            </div>
                            <div class="footer-top-3 col-sm-4">
                                <div class="widget">
                                    <ul class="socials">
                                        <li><a href="<?php echo @$setting['facebook']; ?>" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                                        <li><a href="<?php echo @$setting['twitter']; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li><a href="<?php echo @$setting['google']; ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-bottom">
                        <div class="site-info">
                            <?php echo @$setting['copyright']; ?> 
                        </div>
                    </div>
                </div>
            </footer>
            <!-- #colophon -->
        </div>
        <!-- #page -->
        <div class="custom-loading" style="display: none;">
            <div>
                <img width="32" src="<?php echo skin_url("images/loading.gif"); ?>" />
            </div>
        </div>
    </body>
    <script type="text/javascript" src="<?php echo skin_frontend("js/main.js"); ?>"></script>
    <script>
        $(window).load(function(){
            $('.builder-loading').fadeOut('slow');
            $('.show-sidebar-mobile').click(function(){
                $('#sidebar').show(700);
                $('.show-sidebar-mobile').hide(300);
            });
            $('.close_sidebar').click(function(){
                $('#sidebar').hide(700);
                $('.show-sidebar-mobile').show(300);
            });
            var href = window.location.href;
            var home = "<?php echo base_url(); ?>";
            $("#navbarSupportedContent ul li > a, .footer-col ul li > a").each(function(){
                var current_link = $(this).attr('href');
                if(home == current_link || (current_link == '/' && home == href)) {
                    $(this).parent().addClass('active');
                    $(this).parents("li").addClass('active');
                    $(this).parents("li").find("> a").addClass('active');
                }
                if(home != current_link && (href == home.substr(0,home.length-1) + current_link || href == current_link || href == current_link + '/') && current_link != '' && current_link != '#'){
                    $(this).parent().addClass('active');
                    $(this).parents("li").addClass('active');
                    $(this).parents("li").find("> a").addClass('active');
                }
            });
        });
        $('#btn-more-function').click(function(){
           $('.function-more').show('slow');
           $('#btn-more-functiondis').show();
           $('#btn-more-function').hide();
        });
        $('#btn-more-functiondis').click(function(){
           $('.function-more').hide('slow');
           $('#btn-more-functiondis').hide();
           $('#btn-more-function').show();
        });
        //show more section section-function
        $('#show-more').click(function(){
            $('.section-more-function').toggleClass('is_open_more').slideToggle();
            if($('.section-more-function').hasClass("is_open_more")){
                var top = $('.section-more-function').offset().top - 20;
                var body = $("html, body");
                body.stop().animate({scrollTop:top}, 'slow');
            }
        });
        // setTimeout show popup in Home
        $(document).ready(function(){
            setTimeout(function(){
                $('#modal-alert').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }, 5000);

            $(".modal").on('hidden.bs.modal', function() {
			  	$("body").removeClass("modal-open");
			});
        });
    </script>
</html>