<!DOCTYPE html>
<html>
    <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <?php echo @$meta;?>
        <link rel="icon" href="<?php echo @$setting['favicon']; ?>" type="image/*"/>
        <title><?php echo @$setting['name']; ?></title>
        <link rel="stylesheet" href="<?php echo skin_frontend('css/font-awesome.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo skin_frontend('css/bootstrap.min.css'); ?>">
        <link href="<?php echo skin_frontend('css/jquery.bxslider.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo skin_frontend('css/bootstrap-select.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo skin_frontend('css/common.css'); ?>">
        <link rel="stylesheet" href="<?php echo skin_frontend('css/style.css'); ?>">
        <script src="<?php echo skin_frontend('js/jquery.min.js'); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="<?php echo skin_frontend('js/bootstrap.js'); ?>"></script>
        <script src="<?php echo skin_frontend('js/bootstrap-select.min.js'); ?>"></script>
        <script src="<?php echo skin_frontend('js/jquery.bxslider.min.js'); ?>"></script>
        <script src="<?php echo skin_frontend('js/jquery.waterwheelCarousel.min.js'); ?>"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            <?php //echo @$setting['javascript']; ?>
            var base_url = '<?php echo base_url(); ?>';
        </script>
         <?php echo(@$setting['javascript'])?>
        <style type="text/css">
            <?php echo @$setting['css']; ?>
        </style>
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=<?php echo @$setting['facebook_app_id'] ?>";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    </head>
 
    <body id="page-wrapper" class="page <?php echo @$is_home != null && $is_home ? 'home' : 'not-home'; ?>">
        <div id="page" class="site">
          	<header id="masthead" class="site-header" role="banner">
	            <nav class="navbar navbar-expand-lg navbar-transparent navbar-dark">
	                <div class="container menu-destop">
                      	<a class="navbar-brand" href="<?php echo base_url(); ?>"><span class="logo-text"><span>WeddingGuu!</span></span></a>
                      	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          	<span class="navbar-toggler-icon"></span>
                      	</button>
	                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	                        <?php echo @$menu; ?>
	                        <?php if(isset($is_login) && $is_login): ?>
	                            <div class="dropdown nav-profile">
	                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none;">
	                                    <img class="img-circle" width="40" height="40" src="<?php echo @$user['avatar'] != null ? $user['avatar'] : skin_frontend('images/avatar-default.png'); ?>">
	                                	<span class="nav-profile-text">Tài khoản <i class="fa fa-caret-down" aria-hidden="true"></i></span>
	                                </a>
	                                <ul class="dropdown-menu">
	                                    <li><a href="<?php echo base_url('/profile'); ?>"><i class="fa fa-user-circle" aria-hidden="true"></i> Thông tin cá nhân</a></li>
	                                    <?php if(@$user['sub_domain']):?>
                                          <li><a href="//<?php echo @$user['sub_domain']; ?>.weddingguu.com/"><i class="fa fa-tripadvisor" aria-hidden="true"></i> Trang tường</a></li>
                                      <?php endif;?>
	                                    <li><a href="<?php echo base_url('/themes/my/'); ?>"><i class="fa fa-th" aria-hidden="true"></i> Giao diện của bạn</a></li>
	                                    <li><a href="<?php echo base_url('/profile/change_password'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Đổi mật khẩu</a></li>
	                                    <li><a href="<?php echo base_url('/profile/payment_history'); ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> Lịch sử thanh toán</a></li>
	                                    <li><a href="<?php echo base_url('/invite/'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> Mời bạn bè</a></li>
	                                    <li><a href="<?php echo base_url('/profile/logout/'); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a></li>
	                                </ul>
	                            </div>
	                        <?php else: ?>
	                          	<ul class="navbar-nav navbar-nav-user " id="myNavbar">
	                              	<li class="btn-signup btn-account"><a href="#" class="nav-link">Đăng Ký</a></li>
	                             	<li class="btn-login btn-account link-login"><a class="nav-link" href="#">Đăng nhập</a></li>
	                          	</ul>
	                        <?php endif; ?>
	                    </div>
	                </div>
	                <div class="menu-mobile">
		            	<a class="navbar-brand" href="<?php echo base_url(); ?>"><span class="logo-text"><span>WeddingGuu!</span></span></a>
		            	<?php if(isset($is_login) && $is_login): ?>
                            <div class="dropdown nav-profile">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none;">
                                    <img class="img-circle" width="40" height="40" src="<?php echo @$user['avatar'] != null ? $user['avatar'] : skin_frontend('images/avatar-default.png'); ?>">
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url('/profile'); ?>"><i class="fa fa-user-circle" aria-hidden="true"></i> Thông tin cá nhân</a></li>
                                    <?php if( @$user['sub_domain'] || @$user['domain']):?>
                                      <?php if(@$user['domain'] == null):?>
                                        <?php if(@$user['sub_domain']):?>
                                          <li><a href="//<?php echo @$user['sub_domain']; ?>"><i class="fa fa-tripadvisor" aria-hidden="true"></i> Trang tường</a></li>
                                        <?php endif;?>
                                      <?php else : ?>
                                        <li><a href="//<?php echo @$user['domain']; ?>"><i class="fa fa-tripadvisor" aria-hidden="true"></i> Trang tường</a></li>
                                      <?php endif;?>
                                    <?php endif;?>
                                    <li><a href="<?php echo base_url('/themes/my/'); ?>"><i class="fa fa-th" aria-hidden="true"></i> Giao diện của bạn</a></li>
                                    <li><a href="<?php echo base_url('/profile/change_password'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Đổi mật khẩu</a></li>
                                    <li><a href="<?php echo base_url('/profile/payment_history'); ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> Lịch sử thanh toán</a></li>
                                    <li><a href="<?php echo base_url('/invite/'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> Mời bạn bè</a></li>
                                    <li><a href="<?php echo base_url('/profile/logout/'); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a></li>
                                </ul>
                            </div>
	                    <?php endif; ?>
		            	<a href="#" class="menu-bar"><i class="fa fa-bars"></i></a>
		            	<div class="menu-list">
	                        <?php echo @$menu; ?>
	                        <?php if(!(isset($is_login) && $is_login)): ?>
	                          	<ul class="navbar-nav navbar-nav-user " id="myNavbar">
	                              	<li class="btn-signup btn-account"><a href="#" class="nav-link">Đăng Ký</a></li>
	                             	<li class="btn-login btn-account link-login"><a class="nav-link" href="#">Đăng nhập</a></li>
	                          	</ul>
	                        <?php endif; ?>
	                    </div>
		            </div>
	            </nav>
          	</header>
          	<!-- #masthead -->
	        <?php if(@$is_home != null && $is_home && @$setting['home_list'][0] != null): ?>
              	<?php
                  $replace = array('[%skin_frontend%]','[%num_day%]');
                  $replace_with = array(skin_frontend('/'),@$setting['num_day']);
                  echo str_replace($replace, $replace_with, @$setting['home_list'][0]['section_content']);
             	?>
	        <?php endif; ?>
          	<?php if ($title_page != "") : ?>
              	<section class="page-head banner-page">
                  	<div class="page-head-opacity">
                      	<div class="page-head-content">
                          	<div class="container">
                              	<div class="row">
                                  	<div class="col-md-12">
                                      	<h1 class="title text-center" style="padding-top: 10px;"><?php echo $title_page; ?></h1>
                                  	</div>
                              	</div>
                          	</div>
                      	</div>
                  	</div>
              	</section>
          	<?php endif; ?>
          	<div id="content" class="site-content">
              	<div id="primary" class="content-area">
                	<main id="main" class="site-main" role="main">