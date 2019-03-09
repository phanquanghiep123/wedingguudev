 

<section class="section section-price text-center" xss="removed">
    <div class="container">
        <?php if($this->input->get('alert')):?>
            <div class="alert alert-warning">
              <strong>Thông báo!</strong> Tài khoản của bạn đã hết hạn, Vui lòng chọn gói dich vụ bên dưới để gia hạn tài khoản!
            </div>
        <?php endif;?>
        <div class="section-body">
            <h2 class="text-light">Bảng giá <strong>Gói dịch vụ</strong></h2>
            <div class="table-price-holder">
                <div class="card-deck text-left">
                     <?php echo get_packages($packages); ?>                                                  
                </div>
            </div>
        </div>
    </div>
</section>