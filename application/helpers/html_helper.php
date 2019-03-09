<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_packages')){
	function get_packages($data = null){ 
		ob_start();
?>
		<?php if(isset($data) && $data != null): ?>
            <?php foreach ($data as $key => $item): ?>
                <div class="card package-1">
                    <div class="card-header">
                        <h2 class="title"><?php echo $item['name']; ?><br><span class="price"><?php echo number_format($item['price'],0,",","."); ?></span><span class="unit">VND</span></h2>
                    </div>
                    <div class="card-body">
                        <?php echo $item['description']; ?>
                    </div>
                    <div class="card-footer text-center">
                        <?php if($item['price'] != 0): ?>
                            <a href="<?php echo base_url('payment/index/'.@$item['id']); ?>" class="btn btn-lg btn-secondary">Chọn gói</a>
                        <?php else: ?>
                        	<a href="javascript:void(0);" data-toggle="modal" data-target="#modal-signup" class="btn btn-lg btn-secondary">Dùng thử</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
<?php
		return ob_get_clean();
	}
}

if ( ! function_exists('get_themes')){
    function get_themes($data){
        ob_start();
    ?>
        <div class="carousel-3d">
            <?php if(isset($data) && $data != null): ?>
                <?php foreach ($data as $key => $item): ?>
                    <a href="<?php echo base_url('/appthemes/preview/'.$item['slug']); ?>">
                    	<img style="width:760px;" src="<?php echo base_url($item['hero_image']); ?>" />
                    	<div class="carousel-caption">
                    		<span><?php echo @$item['name']; ?></span>
                    	</div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <a id="prev" class="nav_button prev_button link pull-left" title="prev"><i class="fa fa-chevron-left"></i></a>
        <a id="next" class="nav_button next_button link pull-right" title="next"><i class="fa fa-chevron-right"></i></a>
    <?php
        return ob_get_clean();
    }
}


if ( ! function_exists('get_testimonials')){
    function get_testimonials($data){
        ob_start();
    ?>
        <ul class="bxslider">
            <?php if(isset($data) && $data != null): ?>
                <?php foreach ($data as $key => $item): ?>
                    <li>
                        <div class="testimonial-holder">
                            <div class="img-holder">
                                <img src="<?php echo base_url($item['image']); ?>" />
                            </div>
                            <div class="text-holder">
                                <div class="text-inner">
                                    <div class="rating">
                                        <?php for ($i = 0; $i < $item['rate']; $i++):?>
                                            <i class="fa fa-star"></i>
                                        <?php endfor; ?> 
                                    </div>
                                    <p class="des"><?php echo $item['content']; ?></p>
                                    <p class="author"><?php echo $item['name']; ?> <span>- <?php echo $item['address']; ?></span></p>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    <?php
        return ob_get_clean();
    }
}

if ( ! function_exists('get_theme_user')){
    function get_theme_user($data){
        ob_start();
    ?>
       <ul class="bxslider">
            <?php if(isset($data) && $data != null): ?>
                <?php foreach ($data as $key => $item): ?>
                    <li>
                        <a data-id="<?php echo $item['id']; ?>" href="//<?php echo $item['sub_domain']; ?>.weddingguu.com">
                            <div class="client-holder box-with-label">
                                <div class="img-holder" style="background-image: url('<?php echo base_url($item['hero_image']); ?>');"></div>
                                <div class="box-slide">
                                    <div class="label-holder">
                                        <div class="label-inner">
                                            <div class="text">
                                                <span class="name h4"><?php echo @$item['name']; ?></span>
                                                <span class="sep"></span>
                                                <span class="date"><?php echo date('d/m',strtotime($item['created_at'])); ?></span>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    <?php
        return ob_get_clean();
    }
}