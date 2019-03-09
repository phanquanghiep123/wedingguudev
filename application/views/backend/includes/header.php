<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrator <?php echo (@$title_page != null) ? " | ".$title_page : "";?></title>
    <!-- Bootstrap -->
    <link href="<?php echo skin_backend('vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo skin_backend('vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo skin_backend('vendors/nprogress/nprogress.css');?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo skin_backend('vendors/iCheck/skins/flat/green.css');?>" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?php echo skin_backend('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css');?>" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo skin_backend('vendors/jqvmap/dist/jqvmap.min.css');?>" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo skin_backend('vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo skin_backend('build/css/custom.min.css');?>" rel="stylesheet">
    <link href="<?php echo skin_backend('vendors/switchery/dist/switchery.min.css');?>" rel="stylesheet">
    <link href="<?php echo skin_backend('css/style.css');?>" rel="stylesheet">
    <script src="<?php echo skin_backend('vendors/jquery/dist/jquery.min.js');?>"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
    </script>

    <!-- Bootstrap -->
    <script src="<?php echo skin_backend('vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <!-- FastClick -->
    <script src="<?php echo skin_backend('vendors/fastclick/lib/fastclick.js');?>"></script>
    <!-- NProgress -->
    <script src="<?php echo skin_backend('vendors/nprogress/nprogress.js');?>"></script>
    <!-- Chart.js -->
    <script src="<?php echo skin_backend('vendors/Chart.js/dist/Chart.min.js');?>"></script>
    <!-- gauge.js -->
    <script src="<?php echo skin_backend('vendors/gauge.js/dist/gauge.min.js');?>"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo skin_backend('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js');?>"></script>
    <!-- iCheck -->
    <script src="<?php echo skin_backend('vendors/iCheck/icheck.min.js');?>"></script>
    <!-- Skycons -->
    <script src="<?php echo skin_backend('vendors/skycons/skycons.js');?>"></script>
    <!-- Flot -->
    <script src="<?php echo skin_backend('vendors/Flot/jquery.flot.js');?>"></script>
    <script src="<?php echo skin_backend('vendors/Flot/jquery.flot.pie.js');?>"></script>
    <script src="<?php echo skin_backend('vendors/Flot/jquery.flot.time.js');?>"></script>
    <script src="<?php echo skin_backend('vendors/Flot/jquery.flot.stack.js');?>"></script>
    <script src="<?php echo skin_backend('vendors/Flot/jquery.flot.resize.js');?>"></script>
    <!-- Flot plugins -->
    <script src="<?php echo skin_backend('vendors/flot.orderbars/js/jquery.flot.orderBars.js');?>"></script>
    <script src="<?php echo skin_backend('vendors/flot-spline/js/jquery.flot.spline.min.js');?>"></script>
    <script src="<?php echo skin_backend('vendors/flot.curvedlines/curvedLines.js');?>"></script>
    <!-- DateJS -->
    <script src="<?php echo skin_backend('vendors/DateJS/build/date.js');?>"></script>
    <!-- JQVMap -->
    <script src="<?php echo skin_backend('vendors/jqvmap/dist/jquery.vmap.js');?>"></script>
    <script src="<?php echo skin_backend('vendors/jqvmap/dist/maps/jquery.vmap.world.js');?>"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo skin_backend('vendors/moment/min/moment.min.js');?>"></script>
    <script src="<?php echo skin_backend('vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>    
    <script src="<?php echo skin_backend('build/js/custom.min.js');?>"></script>
    <script src="<?php echo skin_backend('vendors/switchery/dist/switchery.min.js');?>"></script>
    <script src="<?php echo skin_backend('js/main.js');?>"></script>
    <script type="text/javascript" src="<?php echo skin_url('js/ckfinder/ckfinder.js'); ?>"></script>
    <script type="text/javascript">
        function BrowseServerCustom(element) {
            CKFinder.modal( {
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function(finder) {
                    finder.on( 'files:choose', function( evt ) {
                        var files = evt.data.files.first();
                        var fileUrl = files.getUrl();
                        $(element).parents('.featured-image').find('.xImagePath').val(fileUrl);
                        $(element).parents('.featured-image').find('img').attr('src',fileUrl);
                        $(element).parents('.featured-image').addClass('active');
                        $('.overlay-ckfinder').hide();
                    });
                    $("#ckf-modal-header #ckf-modal-close").attr("onclick","$('.overlay-ckfinder').hide();");
                    $('.overlay-ckfinder').show();
                }
            } );
        }
        function ClearFileCustom(element){
            $(element).parents('.featured-image').find('.xImagePath').val('');
            $(element).parents('.featured-image').removeClass('active');
        }
    </script>
</head>
<body class="nav-md <?php echo @$body_class;?>">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                             <?php if(@$admin_info["User_Avatar"] == "" ||true):?>
                                <img src="<?php echo skin_backend('images/img.jpg');?>" alt="..." class="img-circle profile_img">
                             <?php else:?>
                                <img src="<?php echo base_url(@$admin_info["User_Avatar"]);?>" alt="..." class="img-circle profile_img">
                             <?php endif;?>
                        </div>
                        <div class="profile_info">
                             <span>Welcome,</span>
                             <h2><?php echo @$admin_info["User_Name"];?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br>
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section active">
                            <?php echo @$_menu;?>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <?php if(@$admin_info["User_Avatar"] == ""):?>
                                      <img src="<?php echo skin_backend('images/img.jpg');?>" alt="">
                                    <?php else:?>
                                      <img src="<?php echo base_url(@$admin_info["User_Avatar"]);?>" alt="">
                                    <?php endif;?>
                                    <?php echo @$admin_info["User_Name"];?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="<?php echo backend_url("profile");?>">Thông tin cá nhân</a></li>
                                    <li><a href="<?php echo backend_url("acounts/logout");?>"><i class="fa fa-sign-out pull-right"></i> Đăng xuất</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->
            <div class="right_col" role="main">