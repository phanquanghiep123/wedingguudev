<?php if(@$setting['home_list'] != null): ?>
    <?php
        $pricing = get_packages($packages);
        $themes = get_themes($themes);
        $testimonials = get_testimonials($testimonials);
        $get_theme_user = get_theme_user($themes_user);
        $get_advertisement = get_advertisement(@$advertisement);
    ?>
    <?php foreach ($setting['home_list'] as $key => $item): ?>
        <?php 
            if($key != 0){
                $replace = array('[%skin_frontend%]','[%pricing%]','[%themes%]','[%testimonials%]','[%num_day%]','[%get_theme_user%]','[%advertisement%]');
                $replace_with = array(skin_frontend('/'),$pricing,$themes,$testimonials,$num_day,$get_theme_user,$get_advertisement);
                echo str_replace($replace, $replace_with, @$item['section_content']);
            }
        ?>
    <?php endforeach; ?>
<?php endif; ?>