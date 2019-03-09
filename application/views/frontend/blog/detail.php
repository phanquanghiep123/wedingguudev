<section class="page-head banner-page" style="background: url('<?php echo $post['Media']; ?>') no-repeat center center;height: 250px;">
    <div class="page-head-opacity">
        <div class="page-head-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title text-center"></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <article class="post-item">
                    <h2 style="margin-top: 0;"><?php echo $post['Name']; ?></h2>
                    <p class="meta">
                        <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d/m/Y',strtotime(@$post['Created_At'])); ?></span>
                        <?php if(@$post_category!= null): ?>
                            <span class="category"><i class="fa fa-tags" aria-hidden="true"></i> 
                                <?php foreach ($post_category as $key1 => $item1): ?>
                                    <a href="<?php echo base_url(); ?>chuyen-muc/<?php echo @$item1['Slug']; ?>"><?php echo @$item1['Name']; ?></a>
                                    <?php if($key1 < count($post_category ) - 1): ?>
                                        , 
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </span> 
                        <?php endif; ?>
                        <span class="view"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo @$post['View']; ?> </span>
                    </p> 
                    <div class="post-cotent">
                        <?php
                        	$dom = new DOMDocument();
							$paragraphs = array();
							$dom->loadHTML('<?xml encoding="utf-8" ?>' . @$post['Content']);
							foreach($dom->getElementsByTagName('p') as $key => $node){
							    //$paragraphs[] = $dom->saveHTML($node);
							    echo $dom->saveHTML($node);
                                if($key == 10 && @$advertisement != null){
                                    echo '<p class="text-center advertisement"><a href="'.$advertisement['url'].'" title="'.$advertisement['name'].'"><img src="'.base_url($advertisement['image']).'" class="w-100"></a></p>';
                                }
							}
                        ?>
                    </div>
                    <p class="social">
                        Chia sẻ: 
                        <a style="outline: 0;" class="btn btn-primary social-login-btn share-facebook social-facebook" href="/auth/facebook"><i class="fa fa-facebook"></i></a>
                        <a style="outline: 0;" class="btn btn-primary social-login-btn share-twitter social-twitter" href="/auth/twitter"><i class="fa fa-twitter"></i></a>
                        <a style="outline: 0;padding: 5px 12px;" style="outline: 0;" class="btn btn-primary social-login-btn share-linkedin social-linkedin"  href="/auth/linkedin"><i class="fa fa-linkedin"></i></a>
                        <a style="outline: 0;" class="btn btn-primary social-login-btn share-google social-google" href="/auth/google"><i class="fa fa-google-plus"></i></a>
                    </p>
                    <?php if(isset($post_relationship) && $post_relationship != null): ?>
	                	<hr>
	                	<h3 class="post_relationship_title">Những bài viết liên quan</h3>
	                	<ul class="post_relationship">
	                		<?php foreach ($post_relationship as $key => $item): ?>
	                			<li>
	                				<i class="fa fa-angle-double-right" aria-hidden="true"></i> 
	                				<a href="<?php echo base_url(); ?>bai-viet/<?php echo $item['Slug']; ?>"><?php echo $item['Name']; ?> (<?php echo date('d/m/Y',strtotime(@$item['Created_At'])); ?>)</a>
	                			</li>
	                		<?php endforeach; ?>
	                	</ul>
                	<?php endif;?>
                    <div class="fb-comments" data-href="<?php echo base_url('/bai-viet/'.@$post['Slug']); ?>" width="100%" data-numposts="5"></div>
                </article>
            </div>
            <div class="col-sm-3">
                <div class="sidebar-blog">
                    <form class="form-group" action="<?php echo base_url('/bai-viet/'); ?>" method="get">
                        <input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
                        <div class="input-group">
                            <input class="form-control" value="<?php echo $this->input->get('keyword'); ?>" placeholder="Từ khóa tìm kiếm..." name="keyword"> 
                            <span class="input-group-btn"> 
                                <button class="btn btn-default btn-primary btn-search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </span>
                        </div>
                    </form>
                    <h3>Chuyên mục bài viết</h3>
                    <ul>
                        <?php if(isset($category) && $category != null): ?>
                            <?php foreach ($category as $key => $item): ?>
                                <li><i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp; <a href="<?php echo base_url(); ?>chuyen-muc/<?php echo @$item['Slug']; ?>"><?php echo @$item['Name']; ?></a></li>
                            <?php endforeach; ?>
                        <?php endif;?>
                    </ul>
                    <h3>Bài viết mới nhất</h3>
                    <ul>
                        <?php if(isset($last_post) && $last_post != null): ?>
                            <?php foreach ($last_post as $key => $item): ?>
                                <li><i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;&nbsp; <a href="<?php echo base_url(); ?>bai-viet/<?php echo $item['Slug']; ?>"><?php echo @$item['Name']; ?></a></li>
                            <?php endforeach; ?>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
	.fb-comments,
	.fb-comments > span,
	.fb-comments iframe,
	.fb_iframe_widget_fluid span, iframe.fb_ltr{width: 100% !important;}
	.post_relationship_title{color: #000 !important;margin-bottom: 20px;}
	.post_relationship{list-style: none;padding-left: 0;}
	.post_relationship li{margin-bottom: 5px;font-size: 16px;}
	.post_relationship li i{margin-right: 10px;}
    @media (max-width: 768px) {
        .post-item iframe{max-width: 100% !important;}
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        var title = "<?php echo addslashes(@$post['Name']); ?>";
        var description = "<?php echo addslashes(preg_replace('/\s+/',' ',substr(strip_tags(@$post['Summary']),0,400))); ?> ";
        var url = '<?php echo base_url('/bai-viet/'.@$post['Slug']); ?>';
        var image = '<?php echo base_url(@$post['Media']); ?>';
        $(".social .social-login-btn").each(function(){
            $(this).attr('data-title',title);
            $(this).attr('data-url',url);
            $(this).attr('data-image',image);
            $(this).attr('data-summary',description);
        });
    });
</script>