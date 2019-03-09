<section class="page-head banner-page" style="background: url('<?php echo skin_frontend("images/page-home-v2-Recovered.png"); ?>') no-repeat center center;">
    <div class="page-head-opacity">
        <div class="page-head-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title text-center"><?php echo @$title; ?></h1>
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
                <div class="list-post">
                    <?php if(isset($data) && $data != null): ?>
                       <?php foreach ($data as $key => $item): ?>
                            <article class="post-item">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3><?php echo $item['title']; ?></a></h3>
                                        <div class="description" style="margin-bottom:10px;"><?php echo @$item['content']; ?></div>
                                    </div>
                                </div>
                            </article>
                       <?php endforeach; ?>
                    <?php endif;?>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <?php echo $this->pagination->create_links();?>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="sidebar-blog">
                    <form class="form-group" action="<?php echo base_url('/bai-viet/'); ?>" method="get">
                        <div class="input-group">
                            <input class="form-control" value="<?php echo $this->input->get('keyword'); ?>" placeholder="Từ khóa tìm kiếm..." name="keyword"> 
                            <span class="input-group-btn"> 
                                <button class="btn btn-default btn-search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </span>
                        </div>
                    </form>
                    <h3>Chuyên mục blog</h3>
                    <ul>
                        <?php if(isset($category) && $category != null): ?>
                            <?php foreach ($category as $key => $item): ?>
                                <li><i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp; <a href="<?php echo base_url("chuyen-muc/".@$item['Slug']); ?>"><?php echo @$item['Name']; ?></a></li>
                            <?php endforeach; ?>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
