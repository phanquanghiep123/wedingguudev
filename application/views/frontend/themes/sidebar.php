

<div class="sidebar-main">

   <!-- /. sidebar body -->

   <div class="sidebar-body">

      <!-- sidebar heading -->

      <div class="logo"><a href="<?php echo base_url(); ?>"><span class="logo-text"><span>WeddingGuu!</span></span></a></div>

      <!-- /. heading -->

      <div id="accordion" class="panel-group">

         <div class="panel panel-default sidebar-item">

            <div class="panel-heading">

               <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-background">Nền của trang<i class="indicator fa fa-angle-right pull-right" ></i>

                  </a> 

               </h4>

            </div>

            <div id="collapse-background" class="panel-collapse collapse">

               <div class="panel-body">

                  <select id="dezign-background-choose" class="form-control select-option">

                     <option value="default">-- Chọn nền --</option>

                     <option value="1" data-tagget="#box-choose-color">Màu nền</option>

                     <option value="2" data-tagget="#box-choose-image">Ảnh nền</option>

                  </select>

                  <div id="box-choose-color" class="full-box not-full">

                     <input type="text" name="" class="form-control" id="value-color-background">

                  </div>

                  <div id="box-choose-image" class="full-box">

                     <div class="panel-body">

                        <select id="dezign-background-image-choose" class="form-control select-option">

                           <option value="default">Mặc định</option>

                           <option value="0" data-tagget="#box-choose-image-example"> Chọn ảnh mẫu</option>

                           <option value="1" data-tagget="#box-choose-image-upload">Quản lí tập tin</option>

                           <option value="2" data-tagget="#box-choose-image-upload">Tải tập tin lên</option>

                        </select>

                        <div id="box-choose-image-example" class="full-box">

                           <select id="dezign-background-image-bgtemplate" class="form-control">

                              <option value="default">Mặc định</option>

                              <?php if(@$bgtemplate != null){

                                    foreach ($bgtemplate as $key => $value) {

                                       if(trim($value) != "" && $value != null && trim($value) !=".." && trim($value) !="."){

                                          $name = ucfirst(str_replace("_"," ", $value));

                                          echo '<option value="'.$value.'">'.$name .'</option>';

                                       } 

                                    }

                              }?>

                           </select>

                           <div id="box-choose-image-example-load" class="full-box"></div>

                        </div>

                        <div id="box-choose-image-upload" class="full-box none">

                           <input data-multil="1" type="hidden" value="" name="" id="IDchangeBg">

                           <a data-multil="1" style="display: none;" class="none" id="poppup-changeBg" data-fancybox="" data-type="iframe" href="<?php echo base_url("/filemanager/dialog.php?type=1&field_id=IDchangeBg&relative_url=1");?>">Chọn</a>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </div>        

         <div class="panel panel-default sidebar-item">

            <div class="panel-heading">

               <h4 class="panel-title"> <a id="getlistsection" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Phông chữ <i class="indicator fa fa-angle-right pull-right" ></i></a> </h4>

            </div>

            <div id="collapseFour" class="panel-collapse collapse">

               <div class="panel-body">

                  <select class="select-option form-control" id="list-section">

                     <option value="default">--Chọn một phần--</option>

                  </select>

                  <select class="select-option form-control" id="list-tag" disabled>

                     <option value="default">--Chọn một tag--</option>

                  </select>

                  <div id="box-choose-style-tag" class="full-box">

                     <div class="panel-body"> 

                     <p>Màu chữ:</p>  

                        <div id="box-choose-color-tag">

                           <input type="text" name="" class="form-control" id="value-color-text">

                        </div>

                     </div>

                     <div id="box-choose-font-size-tag">  

                        <div class="panel-body">

                           <p>Cỡ chữ:</p>

                           <input type="text" data-slider-min="12" data-slider-max="150" data-slider-step="1" name="" id="range-font-size"/>

                        </div>

                     </div>

                     <div id="box-choose-font-style-tag">  

                        <div class="panel-body">

                           <p>In đậm:</p>

                           <select class="select-option form-control" id="list-font-weight">

                              <option value="">-- mặc định --</option>

                              <option value="100">100</option>

                              <option value="200">200</option>

                              <option value="300">300</option>

                              <option value="400">400</option>

                              <option value="500">500</option>

                              <option value="600">600</option>

                              <option value="700">700</option>

                              <option value="800">800</option>

                              <option value="900">900</option>

                              <option value="bold">bold</option>

                           </select>

                        </div>

                     </div>

                     <div id="box-choose-font-family-tag">  

                        <div class="panel-body">

                           <p>Phông chữ:</p>

                             <select class="select-option form-control" id="list-font-family">

                              <option value="default">--Chọn loại phông chữ--</option>

                              <?php 

                                  $fonts = ["Roboto, sans-serif","Asap Condensed, sans-serif","Encode Sans Expanded, sans-serif","Open Sans, sans-serif","Lato, sans-serif","Slabo 27px, serif","Roboto Condensed, sans-serif","Oswald, sans-serif","Source Sans Pro, sans-serif","Montserrat, sans-serif","Encode Sans Condensed, sans-serif","Raleway, sans-serif","PT Sans, sans-serif","Merriweather, serif","Roboto Slab, serif","Open Sans Condensed, sans-serif","Wendy One, sans-serif","Lora, serif","Ubuntu, sans-serif","Arimo, sans-serif","Saira, sans-serif","Noto Sans, sans-serif","Muli, sans-serif","Noto Serif, serif","Nunito, sans-serif","Inconsolata, monospace","Anton, sans-serif","Josefin Sans, sans-serif","Cabin, sans-serif","Roboto Mono, monospace","Fira Sans, sans-serif","Quicksand, sans-serif","Lobster, cursive","Yanone Kaffeesatz, sans-serif","Asap, sans-serif","Pacifico, cursive","Varela Round, sans-serif","Dancing Script, cursive","Play, sans-serif","Maven Pro, sans-serif","Francois One, sans-serif","Cuprum, sans-serif","Amatic SC, cursive","Exo, sans-serif","EB Garamond, serif","Rokkitt, serif","Vollkorn, serif","Kanit, sans-serif","Comfortaa, cursive","Cormorant Garamond, serif","Old Standard TT, serif","Alegreya Sans, sans-serif","Saira Condensed, sans-serif","Saira Semi Condensed, sans-serif","Saira Extra Condensed, sans-serif","Cabin Condensed, sans-serif","Noticia Text, serif","Faustina, serif","Manuale, serif","Nunito Sans, sans-serif","Prompt, sans-serif","Tinos, serif","Alfa Slab One, cursive","Philosopher, sans-serif","Sedgwick Ave, cursive","Sedgwick Ave Display, cursive","Jura, sans-serif","Paytone One, sans-serif","Patrick Hand SC, cursive","Bangers, cursive","Bevan, cursive","Patrick Hand, cursive","Arima Madurai, cursive","Sigmar One, cursive","Fira Sans Condensed, sans-serif","VT323, monospace","Alegreya Sans SC, sans-serif","Spectral, serif","Prata, serif","Baloo Bhaijaan, cursive","Montserrat Alternates, sans-serif","Fira Sans Extra Condensed, sans-serif","Arsenal, sans-serif","Baloo Tammudu, cursive","Space Mono, monospace","Lalezar, cursive","Itim, cursive","Cousine, monospace","Pridi, serif","Taviraj, serif","Andika, sans-serif","Archivo, sans-serif","Bungee Inline, cursive","Yeseva One, cursive","Trirong, serif","Baloo, cursive","Baloo Paaji, cursive","Mitr, sans-serif","Judson, serif","Bungee, cursive","Baloo Bhaina, cursive","Cormorant, serif","Athiti, sans-serif","Podkova, serif","Maitree, serif","Bungee Shade, cursive","Encode Sans, sans-serif","Encode Sans Semi Condensed, sans-serif","Encode Sans Semi Expanded, sans-serif","Cormorant SC, serif","David Libre, serif","Baloo Tamma, cursive","Lemonada, cursive","Sriracha, cursive","Chonburi, cursive","Pattaya, sans-serif","Pangolin, cursive","Cormorant Infant, serif","Baloo Thambi, cursive","Farsan, cursive","Baloo Chettan, cursive","Baloo Bhai, cursive","Cormorant Upright, serif","Cormorant Unicase, serif","Coiny, cursive","Bungee Hairline, cursive","Bungee Outline, cursive","Baloo Da, cursive",];

                                 foreach($fonts AS $key => $value){

                                    echo '<option value="'.$value.'">'.$value.'</option>';

                                 }

                              ?>

                           </select>

                        </div>

                     </div>

                     <div id="box-choose-vertical-align">

                        <div class="panel-body">

                           <p>Vị trí chữ:</p>

                           <select class="select-option form-control" id="list-vertical-align">

                              <option value="default">--Chọn vị trí chữ--</option>

                              <option value="left">Trái</option>

                              <option value="right">Phải</option>

                              <option value="center">Giữa</option>

                           </select>

                        </div>

                     </div>

                     <div id="box-choose-reset-style">

                        <a id="reset-style-now" href="javascript:;" class="btn btn-primary">Đặt lại</a>

                     </div>

                  </div>

               </div>

            </div>

         </div> 

         <div class="panel panel-default sidebar-item">

            <div class="panel-heading">

               <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#theme-music">Nhạc nền <i class="indicator fa fa-angle-right pull-right" ></i></a> 

               </h4>

            </div>

            <div id="theme-music" class="panel-collapse collapse">

               <div class="panel-body">

                  <?php 

                     if($theme["music"] != null){

                        echo '<div class="current_music">';

                        echo '<ul class="list-items"><li>';

                        echo '<p>Nhạc hiện tại</p>';

                        echo '<div class="action">

                                 <audio style="display:none" class="none" loop><source src="'.$theme["music"].'" type="audio/mpeg"></audio>

                                 <a href="javascript:;" id="play-music"><i class="fa fa-play-circle" aria-hidden="true"></i></a>

                              </div>';

                        echo '</li></ul>';

                        echo '</div>';

                     }

                  ?>

                  <select class="select-option form-control" id="select-folder-music">

                     <option value="default">-- Mặc định --</option>

                     <option value="no">Không nhạc</option>

                     <?php if(@$musictemplate != null){

                           foreach ($musictemplate as $key => $value) {

                              if(trim($value) != "" && $value != null && trim($value) !=".." && trim($value) !="."){

                                 $name = ucfirst(str_replace("_"," ", $value));

                                 echo '<option value="'.$value.'">'.$name .'</option>';

                              } 

                           }

                     }?>

                     <option value="upload">Quản lí tập tin</option>

                     <option value="upload-now">Tải tập tin lên</option>

                  </select> 

                  <div id="box-select-folder-music"></div>

                  

                  <div id="box-upload-folder-music" class="none">

                     <input data-multil="1" type="hidden" value="" name="" id="IDchangeMusic">

                     <a data-multil="1" style="display: none;" class="none" id="poppup-IDchangeMusic" data-fancybox="" data-type="iframe" href="<?php echo base_url("/filemanager/dialog.php?type=2&field_id=IDchangeMusic&relative_url=1");?>">Chọn</a>

                  </div>

               </div>

            </div>

         </div>

         <div class="panel panel-default sidebar-item">

            <div class="panel-heading">

               <h4 class="panel-title"> <a id="show-effect" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#effect-theme">Hiệu ứng <i class="indicator fa fa-angle-right pull-right" ></i></a> 

               </h4>

            </div>

            <div id="effect-theme" class="panel-collapse collapse">

               <div class="panel-body">

                  <select id="select-effect" class="select-option form-control">

                     <option value="default">-- Mặc định --</option>

                     <option value="0">Không hiệu ứng</option>

                     <option value="1" data-tagget="#box-choose-imgeffectimg">Ảnh mẫu</option>

                     <option value="2">Quản lí tập tin</option>

                     <option value="3">Tải tập tin lên</option>

                  </select>

                  <div class="none">

                     <input data-multil="1" type="hidden" value="" name="" id="IDchangeEffect">

                     <a data-multil="1" style="display: none;" class="none" id="poppup-IDchangeEffect" data-fancybox="" data-type="iframe" href="<?php echo base_url("/filemanager/dialog.php?type=2&field_id=IDchangeEffect&relative_url=1");?>">Chọn</a>

                  </div>

                  <?php if(@$imgeffecttemplate != null){

                     echo '<div id="box-choose-imgeffectimg" class="full-box not-full"><ul>';

                     foreach ($imgeffecttemplate as $key => $value) {

                        echo '<li class="item-img"><a id="set-effect-img" data-source="'.$value["source"].'" href="javascript:;"><img src="'.$value["source"].'" class=""></a></li>';

                     }

                     echo '</ul></div>';

                  }?>

               </div>

            </div>

         </div> 

         <div class="panel panel-default sidebar-item">

            <div class="panel-heading">

               <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Thành phần trang <i class="indicator fa fa-angle-right pull-right" ></i></a> 

               </h4>

            </div>

            <div id="collapseThree" class="panel-collapse collapse">

               <div class="panel-body">

                  <div class="row">

                     <div class="col-md-12">

                        <button class="btn btn-info" id="order-section-all"><i class="sc-composer-icon sc-c-icon-dragndrop"></i> Sắp xếp</button>

                     </div>

                     <div class="col-md-12">

                        <button class="btn btn-primary" id="add-new-section"><i class="sc-composer-icon sc-c-icon-add"></i>Thêm mới</button>

                     </div>

                  </div>   

               </div>

            </div>

         </div>

         <div class="panel panel-default sidebar-item">

            <div class="panel-heading">

               <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#info-theme">Thông tin giao diện <i class="indicator fa fa-angle-right pull-right" ></i></a> 

               </h4>

            </div>

            <div id="info-theme" class="panel-collapse collapse">

               <div class="panel-body">

                  <div class="row">

                     <div class="form-group form-group-last col-lg-12">

                        <input type="text" name="name" class="form-control" placeholder="Nhập vào tên giao diện">

                     </div>

                     <div class="form-group form-group-last col-lg-12">

                        <textarea name="description" class="form-control" placeholder="Nhập vào mô tả của giao diện"></textarea>  

                     </div>

                     <div class="form-group form-group-last col-lg-12">

                        <input data-multil="1" type="hidden" id="IDchangeHeroImage" name="" value="">

                        <a class="form-control" data-fancybox="" data-type="iframe" href="<?php echo base_url("filemanager/dialog.php?type=1&amp;field_id=IDchangeHeroImage&amp;relative_url=1");?>">Chọn ảnh. </a>

                        <div id="box-show-background-image">

                           <div class="img"><img name="hero_image" src=""><div class="action"><a href="javascript:;" class="remove"><i class="fa fa-remove" aria-hidden="true"></i></a></div></div>

                        </div>

                        <input id="hero_image" name="hero_image" type="hidden">

                     </div>

                  </div>   

               </div>

            </div>

         </div> 

      </div>

   </div>

   <!-- /. sidebar body -->

   <!-- sidebar footer -->

   <!-- /. sidebar footer -->

</div>

<div class="sidebar-footer"> 

   <button class="btn btn-info" data-view="no" id="save-member-theme">Lưu</button> 

   <button class="btn btn-success" data-view="yes" id="save-member-theme">Xem nhanh</button> 

</div>

<div class="close-sidebar-mobile">

   <div class="form-group"> <input class="form-control close_sidebar" type="button" value="close sidebar"> </div>

</div>