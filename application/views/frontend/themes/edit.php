<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans|Alegreya+Sans+SC|Alfa+Slab+One|Amatic+SC|Andika|Anton|Archivo|Arima+Madurai|Arimo|Arsenal|Asap|Asap+Condensed|Athiti|Baloo|Baloo+Bhai|Baloo+Bhaijaan|Baloo+Bhaina|Baloo+Chettan|Baloo+Da|Baloo+Paaji|Baloo+Tamma|Baloo+Tammudu|Baloo+Thambi|Bangers|Bevan|Bungee|Bungee+Hairline|Bungee+Inline|Bungee+Outline|Bungee+Shade|Cabin|Cabin+Condensed|Chonburi|Coiny|Comfortaa|Cormorant|Cormorant+Garamond|Cormorant+Infant|Cormorant+SC|Cormorant+Unicase|Cormorant+Upright|Cousine|Cuprum|Dancing+Script|David+Libre|EB+Garamond|Encode+Sans|Encode+Sans+Condensed|Encode+Sans+Expanded|Encode+Sans+Semi+Condensed|Encode+Sans+Semi+Expanded|Exo|Farsan|Faustina|Fira+Sans|Fira+Sans+Condensed|Fira+Sans+Extra+Condensed|Francois+One|Inconsolata|Itim|Josefin+Sans|Judson|Jura|Kanit|Lalezar|Lato|Lemonada|Lobster|Lora|Maitree|Manuale|Maven+Pro|Merriweather|Mitr|Montserrat|Montserrat+Alternates|Muli|Noticia+Text|Noto+Sans|Noto+Serif|Nunito|Nunito+Sans|Old+Standard+TT|Open+Sans|Open+Sans+Condensed:300|Oswald|PT+Sans|Pacifico|Pangolin|Patrick+Hand|Patrick+Hand+SC|Pattaya|Paytone+One|Philosopher|Play|Podkova|Prata|Pridi|Prompt|Quicksand|Raleway|Roboto|Roboto+Condensed|Roboto+Mono|Roboto+Slab|Rokkitt|Saira|Saira+Condensed|Saira+Extra+Condensed|Saira+Semi+Condensed|Sedgwick+Ave|Sedgwick+Ave+Display|Sigmar+One|Slabo+27px|Source+Sans+Pro|Space+Mono|Spectral|Sriracha|Taviraj|Tinos|Trirong|Ubuntu|VT323|Varela+Round|Vollkorn|Wendy+One|Yanone+Kaffeesatz|Yeseva+One" rel="stylesheet">
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
<div class="page">
   <div class="builder-loading" style="display: block;"> <img src="images/spinner-large.png" alt=""> </div>
   <div id="editor" style="" class="container-fluid">
      <div class="row">
         <button class="btn btn-default show-sidebar-mobile"><i class="fa fa-cog"></i></button>
         <!-- sidebar -->
         <div id="sidebar" class="col-sm-3 col-md-3 col-lg-2 sidebar">
            <?php $this->load->view("frontend/themes/sidebar",["action" => "edit"]);?>
         </div>
         <!-- /. sidebar -->
         <!-- page content -->
         <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-10 col-lg-offset-2">
            <div class="page-wrapper dezign-page-layout">
               <div class="thems-bg"></div>
               <div id="wpb_visual">
					    <?php echo $html_show;?>
				   </div>
            </div>
         </div>
         <!-- /. page content -->
      </div>
   </div>
</div>
<div id="sc_script">
<script type="text/javascript" src="<?php echo skin_url('plugin-sc/js/sc-frontend.js');?>"></script>
<script type="text/javascript">
   var SC;
	$(document).ready (function(){	
		var id    = <?php echo @$ThemeID;?>;
      var themesID = <?php echo $id;?>;
		var items =  $.parseJSON( '<?php echo json_encode($items);?>' );
	   SC = new SC_Visual($('#wpb_visual'),"<?php echo base_url("/");?>",id,items,"edit",themesID);
	});
   //$( "#sc-page").addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" ).find( ".portlet-header" ).addClass( "ui-widget-header ui-corner-all" ).prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
</script>
</div>
<script type="text/javascript">
   function toggleChevron(e)
   {
   	$(e.target).prev('.panel-heading').find("i.indicator").toggleClass('fa-angle-down');
   }
   $('#accordion').on('hidden.bs.collapse', toggleChevron);
   $('#accordion').on('shown.bs.collapse', toggleChevron);
</script>

