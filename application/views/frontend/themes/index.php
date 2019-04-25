<section class="section-firts" id="main-page">
    <div class="container">
        <div class="section-body">
            <div class="section-top"> 
                <h2 class="text-center">[{]THEME_STRING_001[}]</h2>
            </div>
            <div class="section-bottom"> 
                <?php $colum1 = $colum2 = $colum3 = "";$i = 0; ?>
                <?php foreach($result as $key => $value): ?>
                	<?php 
	                    $i++;
	                    $date = date_create($value["created_at"]);
	                    $created = date_format($date,"Y / m / d");
	                    ob_start();
	                ?>
	                	<div class="col-md-4 item-card">
						    <div class="card-image relative" data-id="<?php echo $value["id"]; ?>" style="margin-bottom:20px;">
						        <div class="relative">
						            <a href="<?php echo base_url("appthemes/preview/".$value["slug"]); ?>"><div style="background-image:url('<?php echo $value["hero_image"]; ?>');width:100%;height:200px;background-size: cover;background-position: center;background-repeat: no-repeat;"></div></a>
						        </div>
						        <div class="description-bottom">
						            <div class="description" style="padding: 10px 15px 0;border-bottom: 1px solid #ccc;">
						            	<div class="row">
							                <div class="col-12">
							                	<h4 class="text-center"><a href="<?php echo base_url("appthemes/preview/".$value["slug"]); ?>"><?php echo $value["name"]; ?></a></h4>
							                    <!--<p><?php //echo @$value["description"]; ?></p>-->
							                </div>
						                </div>
						            </div>
						            <div class="bottom-card">
						                <div class="box-top text-center" style="padding: 10px 0;">
						                    <a href="<?php echo base_url("appthemes/clone/".$value["slug"]); ?>" class="btn btn-primary" style="text-transform: inherit;">[{]L_USER[}]</a>
						                    <a href="<?php echo base_url("appthemes/preview/".$value["slug"]); ?>" class="btn btn-primary" style="text-transform: inherit;">[{]L_REVIEW[}]</a>
						                </div>
						            </div>
						        </div>
						    </div>
						</div>
					<?php 
                        $html = ob_get_clean();
                        if($i == 1){
                            $colum1 .= $html;
                        }
                        if($i == 2){
                            $colum2 .=$html;
                        }
                        if($i == 3){
                            $colum3 .= $html;
                            $i = 0 ;
                        }
                    ?>
                <?php endforeach; ?>
                <div class="row">
                    <?php echo $colum1 ;?>
                    <?php echo $colum2 ;?>
                    <?php echo $colum3 ;?>
                    <div class="col-md-4 item-card">
                    	<div class="card-image relative" style="margin-bottom:20px;">
					        <div class="relative">
					            <div style="background-image:url('<?php echo skin_url('frontend/images/pexels-photo-566454.jpeg'); ?>');width:100%;height:200px;background-size: cover;background-position: center;background-repeat: no-repeat;"></div>
					        </div>
					        <div class="description-bottom">
					            <div class="description" style="padding: 10px 15px 0;border-bottom: 1px solid #ccc;">
					            	<div class="row">
						                <div class="col-12">
						                	<h4 class="text-center">[{]L_UPDATING[}]...</h4>
						                </div>
					                </div>
					            </div>
					            <div class="bottom-card">
					                <div class="box-top text-center" style="padding: 10px 0;opacity: 0;">
					                    <a href="#" class="btn btn-primary" style="text-transform: inherit;">[{]L_USER[}]</a>
					                    <a href="#" class="btn btn-primary" style="text-transform: inherit;">[{]L_REVIEW[}]</a>
					                </div>
					            </div>
					        </div>
					    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style type="text/css">
    .content-show-page{margin-top: 42px;}
    .item-card{padding-left: 5px;padding-right: 5px;}
    .item-card .card-image {background-color: #fff; float: left;width: 100%;margin-bottom: 20px;}
    .item-card img.src_img {width: 100%; height: auto; border-bottom: 1px solid #f1f1f1;}
    .card-image .top-card {position: absolute;height: 100%;top: 0;left: 0;padding: 5px;display: none;right: 0;z-index: 10;background-color: rgba(0, 0, 0, 0.29);}
    .card-image:hover .top-card {display: block;}
    .left-info-member{float: left;width: 65px;}
    .card-image .top-card .avatar {width: 50px;}
    .card-image .top-card p{margin-bottom: 0; font-size: 13px; color: #fff;text-transform: uppercase;}
    .card-image .top-card p a{margin-bottom: 0; font-size: 13px; color: #fff;text-transform: uppercase;}
    .card-image .description-bottom{-webkit-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.25);-moz-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.25);box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.25);float: left;width: 100%;}
    .card-image .bottom-card .box-top { width: 100%;float: left;padding: 5px 10px;border-bottom: 1px solid #f1f1f1;background-color: #fff;}
    .card-image .bottom-card .box-top p {color: #37a7a7; font-size: 11px;margin-bottom: 0;}
    .card-image .bottom-card .box-top p span{color: #37a7a7;font-size: 11px;margin-bottom: 0;}
    .card-image .bottom-card .box-bottom {float: left;width: 100%;padding: 5px 10px;background-color: #fff;}
    .card-image .description{padding: 5px 0;float: left;width: 100%;border-bottom: 2px solid #f1f1f1;}
    .card-image .bottom-card .box-bottom i{color: rgba(127, 127, 127, 0.63);font-size: 24px;cursor: pointer;}
    .card-image .bottom-card .box-bottom i.active{color: #37a7a7;    }
    .card-image .bottom-card .box-bottom i:hover{color: #37a7a7;}
    .card-image:hover .top-card {display: block;}
    .relative{position: relative;}
    #action-theme{margin: 20px 0 0;}
    #action-theme .btn{opacity: 0.7; border-radius: 0; border: 1px solid #ccc; padding: 2px 10px;}
    #action-theme .btn.active{opacity: 1;}
    #action-theme .btn:hover{opacity: 1;}
    .card-image .description p {margin-bottom: 0 ;font-size:11px; color: rgba(127, 127, 127, 0.63);}
    #action-theme .btn-transparent {opacity: 1;color: #f75a53;background-color: #fff;line-height: 2;box-shadow: none;transition: background .2s ease-in;border: none;border-radius: 3rem;padding-top: 5px;}
    #action-theme .btn-transparent:hover {background: rgb(254,94,87); */background: -moz-linear-gradient(-45deg, rgba(254,94,87,1) 0%, rgba(251,146,131,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fe5e57', endColorstr='#fb9283',GradientType=1);color: #fff;}
    #masthead,#colophon{display: block !important;}
    /*insert css*/
    .top-card .box-top-card {display: table;vertical-align: middle;width: 100%;text-align: center;height: 100%;}
    .top-card .box-top-card .info-member {display: table-cell;vertical-align: middle;}
</style>