<section class="section section-price text-center" style="background-image: url('<?php echo skin_frontend('images/home-bg-price.jpg'); ?>');">
    <div class="container">
        <div class="section-body">
            <h2 class="text-light">Bảng giá <strong>Gói dịch vụ</strong></h2>
            <div class="table-price-holder">
                <div class="card-deck text-left">
                    <?php echo get_packages($data); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<style type="text/css">
    .page-head{display: none;}
    @media (max-width: 768px) {
    	.section-price{margin-top: 61px;}
        .section-price .text-light{font-size: 28px;}
    }
</style>
