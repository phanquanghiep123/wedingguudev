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
    </script>
    <style type="text/css">
        @media (min-width: 992px) {
            .navbar-expand-lg .navbar-collapse {
                display: -ms-flexbox!important;
                display: flex!important;
                -ms-flex-preferred-size: auto;
                flex-basis: auto;
            }
            .navbar-expand-lg .navbar-nav {
                -ms-flex-direction: row;
                flex-direction: row;
            }
            .navbar-expand-lg .navbar-toggler {
                display: none;
            }
        }
        .navbar-toggler{
            color: rgba(255,255,255,.5);
            border-color: rgba(255,255,255,.1);
            padding: .25rem .75rem;
            font-size: 1.25rem;
            line-height: 1;
            background: 0 0;
            border: 1px solid transparent;
            border-radius: .25rem;
            text-transform: none;
        }
        .navbar-dark .navbar-toggler-icon{
            display: inline-block;
            width: 1.5em;
            height: 1.5em;
            vertical-align: middle;
            content: "";
            background: no-repeat center center;
            background-size: 100% 100%;
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://ww…p='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
        .mr-auto, .mx-auto {
            margin-right: auto!important;
        }
        .navbar-expand-lg .navbar-nav{
            margin-right: auto;
            float: none;
            list-style: none;
            margin-left: 0;
            margin-top: 15px;
        }
        .navbar .nav-link{
            text-decoration: none !important;
        }
        .page-head-content .title{
            padding-top: 0 !important;
            font-size: 48px;
            margin-top: 10px;
        }
        #masthead,#colophon{display: none;}
    </style>
</html>