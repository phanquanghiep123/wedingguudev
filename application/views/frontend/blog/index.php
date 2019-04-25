<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="list-post">
                    <?php if(isset($data) && $data != null): ?>
                       <?php foreach ($data as $key => $item): ?>
                            <article class="post-item">
                                <div class="row">
                                    <div class="col-sm-4 block-content">
                                        <div class="bg-post" style="background-image:url('<?php echo $item['Media']; ?>');"></div>
                                    </div>
                                    <div class="col-sm-8">
                                        <h3><a href="<?php echo base_url(); ?>bai-viet/<?php echo $item['Slug']; ?>"><?php echo $item['Name']; ?></a></h3>
                                        <p class="meta">
                                            <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d/m/Y',strtotime(@$item['Created_At'])); ?></span>
                                            <?php if(@$item['category'] != null): ?>
                                                <span class="category"><i class="fa fa-tags" aria-hidden="true"></i> 
                                                    <?php foreach ($item['category'] as $key1 => $item1): ?>
                                                        <a href="<?php echo base_url(); ?>chuyen-muc/<?php echo @$item1['Slug']; ?>"><?php echo @$item1['Name']; ?></a>
                                                        <?php if($key1 < count($item['category']) - 1): ?>
                                                            , 
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </span> 
                                            <?php endif; ?>
                                            <span class="view"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo @$item['View']; ?> </span>
                                        </p>
                                        <div class="description" style="margin-bottom:10px;"><?php echo substr(strip_tags(@$item['Summary']),0,400); ?></div>
                                        <p class="remove-margin"><a href="<?php echo base_url(); ?>bai-viet/<?php echo $item['Slug']; ?>">[{]COMMON_L_DETAIL[}] <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></p>
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
                        <input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
                        <div class="input-group">
                            <input class="form-control" value="<?php echo $this->input->get('keyword'); ?>" placeholder="[{]BLOG_STRING_003[}]..." name="keyword"> 
                            <span class="input-group-btn"> 
                                <button class="btn btn-default btn-primary btn-search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </span>
                        </div>
                    </form>
                    <h3>[{]BLOG_STRING_001[}]</h3>
                    <ul>
                        <?php if(isset($category) && $category != null): ?>
                            <?php foreach ($category as $key => $item): ?>
                                <li><i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp; <a href="<?php echo base_url(); ?>chuyen-muc/<?php echo @$item['Slug']; ?>"><?php echo @$item['Name']; ?></a></li>
                            <?php endforeach; ?>
                        <?php endif;?>
                    </ul>
                    <h3>[{]BLOG_STRING_002[}]</h3>
                    <ul class="remove-margin">
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
