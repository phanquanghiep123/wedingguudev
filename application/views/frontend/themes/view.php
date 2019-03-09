<link rel="stylesheet" type="text/css" href="<?php echo skin_url("plugin-sc/js/Hamburger/css/style.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("plugin-sc/js/Hamburger/css/font-awesome.min.css")?>">
<style type="text/css">
  	.header,.footer{
	    display:  none; 
	    visibility: hidden;
	    height: 0;
	    width: 0;
	    padding: 0; 
	    margin: 0;
	}
</style>
<div class="page" id="sc-view">
   <div class="builder-loading" style="display: block;"> <img src=<?php echo skin_url("images/spinner-large.png");?>" alt=""> </div>
   <div id="editor" style="" class="container-fluid">
      <!-- page content -->
      <div class="o-container" id="box-menu-hamburger">
          <div class="o-grid__item">
              <a href="javascript:;" class="c-hamburger c-hamburger--htra" id="icon-cog-section">
                <span class="fa fa-cog"></span>
              </a>
          </div>  
          <div class="o-grid__item">
              <a href="javascript:;" class="c-hamburger c-hamburger--htra" id="icon-list-section">
                <span>toggle menu</span>
              </a>
          </div>
          <div class="o-grid__item">
              <a href="<?php echo base_url("/");?>" class="c-hamburger c-hamburger--htra" id="icon-home-section">
                <span class="fa fa-cog"></span>
              </a>
          </div> 
          <?php if(@$is_login == true):?> 
          <div class="o-grid__item">
              <a href="<?php echo base_url("/profile/logout/");?>" class="c-hamburger c-hamburger--htra" id="icon-logout-section">
                <span class="fa fa-sign-out"> </span>
              </a>
          </div>
        <?php else:?>
          <div class="o-grid__item">
              <a href="<?php echo base_url("/account/login/");?>" class="c-hamburger c-hamburger--htra sign-in" id="icon-logout-section">
                <span class="fa fa-sign-in"> </span>
              </a>
          </div>
        <?php endif?>
      </div>
      <main class="o-content" id="menu-hamburger-right">
        <?php $is_active = $theme["is_active"] == 1 ? "active" : "";?>
        <ul id="content-menu-hamburger" class="content-menu-hamburger"></ul>
        <ul id="content-menu-setting" class="content-menu-hamburger">
          <li><a href="javascript:;" id="select-off-on-music"><i class="fa fa-power-off" aria-hidden="true"></i> Tắt nhạc nền</a></li>
          <li><a href="javascript:;" id="select-off-on-effect"><i class="fa fa-power-off" aria-hidden="true"></i> Tắt hiệu ứng</a></li>
          <?php if(@$is_login == true):?>
            <?php if(@$is_owner == true){ ?>
              <li><a href="<?php echo base_url("/themes/edit/$id")?>" id="select-off-on-effect"><i class="fa fa-edit" aria-hidden="true"></i> Chỉnh sửa giao diện</a></li>
              <li><a class="<?php echo $is_active;?>" href="javascript:;" id="select-off-on-active"><i class="fa fa-check" aria-hidden="true"></i> Kích hoạt giao diện</a></li>
            <?php } ?>
            <li><a href="<?php echo base_url("/themes/my/");?>"><i class="fa fa-themeisle" aria-hidden="true"></i> Giao diện của tôi</a></li>
          <?php endif;?>
          <li><a data-url="<?php echo @$url_share;?>" href="javascript:;" onclick="return share();"><i class="fa fa-share-alt" aria-hidden="true"></i> Chia sẻ giao diện</a></li>
          <li><a href="<?php echo base_url()?>"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
        </ul>
        </div>
      </main>
      <a class="redit-base" href="<?php echo base_url()?>"><img src="<?php echo skin_url("frontend/images/spinner-large.png");?>"></a>
      <div class="page-wrapper dezign-page-layout">
         <div class="thems-bg"></div>
            <div id="wpb_visual" class="view">
               <div class="content-page">
                  <div class="row">
   				     <?php echo $html_show;?>
                     <div class="modal fade modal-editor" id="modal-section" tabindex="-1" role="dialog" aria-labelledby="modal-tagline-1"></div>
                  </div>
   			        <?php if(@$theme["music"] != null && trim(@$theme["music"]) != ""){
                    echo '<audio id="carteSoudCtrl" autoplay="true" loop>
                      <source src="'.$theme["music"].'" type="audio/mpeg">
                    </audio>';
                }?>  
               </div>
            </div>
         </div>
         <!-- /. page content -->
      </div>
   </div>
</div>
<link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/jquery.bxslider/jquery.bxslider.min.css">
<link rel="stylesheet" type="text/css" href="/skins/plugin-sc/css/style.css">
<link rel="stylesheet" type="text/css" href="/skins/plugin-sc/css/friendly.css">
<link rel="stylesheet" type="text/css" href="/skins/plugin-sc/css/view.css">
<link rel="stylesheet" type="text/css" href="/skins/plugin-sc/css/ewedding.css">
<link rel="stylesheet" type="text/css" href="/skins/plugin-sc/js/fancybox/dist/jquery.fancybox.css">
<script type="text/javascript" src="/skins/plugin-sc/js/jquery.bxslider/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/skins/plugin-sc/js/Waterfall/newWaterfall.js"></script>
<script type="text/javascript" src="/skins/plugin-sc/js/jquery.snow.min.1.0.js"></script>
<script type="text/javascript" src="/skins/plugin-sc/js/jquery.countdown/jquery.countdown.min.js"></script>
<script type="text/javascript" src="/skins/plugin-sc/js/lunar-calendar.js"></script>
<script type="text/javascript" src="/skins/plugin-sc/js/jquery.fireworks/jquery.fireworks.js"></script>
<script type="text/javascript" src="/skins/plugin-sc/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="/skins/plugin-sc/js/fancybox/dist/jquery.fancybox.js"></script>
<script id="map-script" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsftpjCAt1Css6h_0T-XoU_b1R-qx-kUE&libraries=places"></script>
<div id="sc_script">
   <script type="text/javascript" src="<?php echo skin_url('plugin-sc/js/public.js')?>"></script>
   <script type="text/javascript">
      var SC;
      $(document).ready (function(){   
         var id    = <?php echo @$ThemeID;?>;
         var themesID = <?php echo $id;?>;
         var items =  $.parseJSON( '<?php echo json_encode($items);?>' );
         SC = new SC_Visual($('#wpb_visual'),"<?php echo base_url("/");?>",id,items,"edit",themesID);
      });
   </script>
</div>
