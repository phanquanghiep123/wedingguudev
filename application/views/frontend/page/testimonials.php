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
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php if(isset($testimonials) && $testimonials != null): ?>
                <?php foreach ($testimonials as $key => $item): ?>
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
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>