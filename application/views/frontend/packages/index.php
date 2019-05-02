 

<section class="section section-price text-center" xss="removed">
    <div class="container">
        <?php if($this->input->get('alert')):?>
            <div class="alert alert-warning">

              <strong>[{]PACKAGE_STRING_002[}] !</strong>[{]PACKAGE_STRING_003[}] !
            </div>
        <?php endif;?>
        <div class="section-body">
            <h2 class="text-light">[{]PACKAGE_STRING_001[}]</h2>
            <div class="table-price-holder">
                <div class="card-deck text-left">
                     <?php echo get_packages($packages); ?>                                                  
                </div>
            </div>
        </div>
    </div>
</section>