<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans|Alegreya+Sans+SC|Alfa+Slab+One|Amatic+SC|Andika|Anton|Archivo|Arima+Madurai|Arimo|Arsenal|Asap|Asap+Condensed|Athiti|Baloo|Baloo+Bhai|Baloo+Bhaijaan|Baloo+Bhaina|Baloo+Chettan|Baloo+Da|Baloo+Paaji|Baloo+Tamma|Baloo+Tammudu|Baloo+Thambi|Bangers|Bevan|Bungee|Bungee+Hairline|Bungee+Inline|Bungee+Outline|Bungee+Shade|Cabin|Cabin+Condensed|Chonburi|Coiny|Comfortaa|Cormorant|Cormorant+Garamond|Cormorant+Infant|Cormorant+SC|Cormorant+Unicase|Cormorant+Upright|Cousine|Cuprum|Dancing+Script|David+Libre|EB+Garamond|Encode+Sans|Encode+Sans+Condensed|Encode+Sans+Expanded|Encode+Sans+Semi+Condensed|Encode+Sans+Semi+Expanded|Exo|Farsan|Faustina|Fira+Sans|Fira+Sans+Condensed|Fira+Sans+Extra+Condensed|Francois+One|Inconsolata|Itim|Josefin+Sans|Judson|Jura|Kanit|Lalezar|Lato|Lemonada|Lobster|Lora|Maitree|Manuale|Maven+Pro|Merriweather|Mitr|Montserrat|Montserrat+Alternates|Muli|Noticia+Text|Noto+Sans|Noto+Serif|Nunito|Nunito+Sans|Old+Standard+TT|Open+Sans|Open+Sans+Condensed:300|Oswald|PT+Sans|Pacifico|Pangolin|Patrick+Hand|Patrick+Hand+SC|Pattaya|Paytone+One|Philosopher|Play|Podkova|Prata|Pridi|Prompt|Quicksand|Raleway|Roboto|Roboto+Condensed|Roboto+Mono|Roboto+Slab|Rokkitt|Saira|Saira+Condensed|Saira+Extra+Condensed|Saira+Semi+Condensed|Sedgwick+Ave|Sedgwick+Ave+Display|Sigmar+One|Slabo+27px|Source+Sans+Pro|Space+Mono|Spectral|Sriracha|Taviraj|Tinos|Trirong|Ubuntu|VT323|Varela+Round|Vollkorn|Wendy+One|Yanone+Kaffeesatz|Yeseva+One" rel="stylesheet">
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
<?php 
  $style = "";
  $html_show = "";
	$items = array();
	if(@$sections != null){
	foreach ($sections as $key => $value) {	
		$arg   = json_decode($value["items"],true);
		if(is_array($arg) && $arg != null){
			foreach ($arg as $key_1 => $value_1) {
				$items []= $value_1;
			}
		}
		$html_show .= $value["html"];
	}
}?>

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
<script type="text/javascript">
  var facebook_app_id = "<?php echo( $setting["facebook_app_id"] );?>";
  var facebook_secret = "<?php echo( $setting["facebook_secret"] );?>";
  var w = 600;
  var h = 400;
  var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
  var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
  var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
  var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
  var left = ((width / 2) - (w / 2)) + dualScreenLeft;
  var top = ((height / 2) - (h / 2)) + dualScreenTop;
  var url_share_social ='https://www.facebook.com/sharer.php?title=<?php echo $theme["name"];?>&u=<?php echo $url_share;?>&picture=<?php echo base_url($theme["hero_image"]);?>&description=<?php echo $theme["description"];?>';
  window.fbAsyncInit = function () {
      FB.init({
          appId: facebook_app_id,
          xfbml: true,
          version: 'v2.5'
      });
  };
  (function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
          return;
      }
      js = d.createElement(s);
      js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  function share() {
    window.open(url_share_social,'_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left);
  }
</script>
<style type="text/css">
  #masthead,#colophon{display: none !important;}
</style>
