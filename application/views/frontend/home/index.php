<?php if(@$setting['home_list'] != null): ?>
    <?php
        $pricing = get_packages($packages);
        $themes = get_themes($themes);
        $testimonials = get_testimonials($testimonials);
        $get_theme_user = get_theme_user($themes_user);
    ?>
    <?php foreach ($setting['home_list'] as $key => $item): ?>
        <?php 
            if($key != 0){
                $replace = array('[%skin_frontend%]','[%pricing%]','[%themes%]','[%testimonials%]','[%num_day%]','[%get_theme_user%]');
                $replace_with = array(skin_frontend('/'),$pricing,$themes,$testimonials,$num_day,$get_theme_user);
                echo str_replace($replace, $replace_with, @$item['section_content']);
            }
        ?>
    <?php endforeach; ?>
<?php endif; ?>
<!-- modal alert settimeout -->
<div class="container">
    <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modal-alert">Open Modal</button> -->
    <!-- Modal 
    <div id="modal-alert" class="modal hide" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">WeddingGuu cảm ơn bạn đã truy cập website</h4>
                </div>
                <div class="modal-body">
                    <p>WeddingGuu xin thông báo với bạn đây là sản phẩm Demo, hệ thống vẫn đang trong quá trình phát triển & hoàn thiện.</p>
                    <p>Trân trọng thông báo!</p>
                    <!--<form action="" method="POST" class="form_register">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" required placeholder="Email">
                                </div>
                            </div>
                            <div class="col-sm-3 text-right"><button class="btn btn-md btn-info">Đăng ký</button></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-left">
                    <button type="button" class="btn btn-md btn-primary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <!-- // modal alert settimeout -->
</div>