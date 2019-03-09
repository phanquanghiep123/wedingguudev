<div class="page-content template-faq">
    <div class="container">
        <div class="row">
            <div id="faq" class="col-md-9">
                <div class="panel-group" id="accordion">
                    <?php if(isset($faqs) && $faqs): ?>
                        <?php foreach ($faqs as $key => $item): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle <?php echo @$_GET['id'] == 'collapse-'.$key ? 'is_active' : ''; ?>" href="#collapse-<?php echo $key; ?>"><?php echo @$item['title']; ?></a>
                                    </h4>
                                </div>
                                <div id="collapse-<?php echo $key; ?>" class="panel-collapse <?php echo @$_GET['id'] == 'collapse-'.$key ? 'is_active' : ''; ?>" <?php echo @$_GET['id'] == 'collapse-'.$key ? '' : 'style="display: none;"'; ?> >
                                    <div class="panel-body">
                                        <?php echo @$item['content']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3">
                <?php if(isset($category) && $category != null): ?>
                    <p class="lead">Chuyên mục</p>
                    <div class="list-group">
                        <a href="<?php echo base_url('/trang/hoi-dap'); ?>" class="list-group-item">Tất cả chuyên mục</a>
                        <?php foreach ($category as $key => $item): ?>
                            <a href="<?php echo base_url('/trang/hoi-dap/'.@$item['id']); ?>" class="list-group-item <?php echo @$_GET['category_id'] == @$item['id'] ? 'active' : ''; ?>"><?php echo @$item['name']; ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".accordion-toggle").click(function(){
            $(this).toggleClass('is_active');
            $(this).parents('.panel').find('.panel-collapse').toggleClass('is_active').slideToggle('slow');
            return false;
        });
    });
</script>