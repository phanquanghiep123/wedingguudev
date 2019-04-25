<link rel="stylesheet" type="text/css" href="<?php echo skin_frontend('css/bootstrap-tagsinput.css'); ?>">  
<script src="<?php echo skin_frontend('js/bootstrap-tagsinput.js'); ?>"></script>
<div class="page-container" style="width: auto;padding: 0;margin-top: 0;">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="irefer-wrap">
                <section class="section-firts">
                <div class="container">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="results">
                            <div style="height: 5px;"></div>
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings text-center">
                                            <th>#</th>
                                            <th>Họ và tên</th>
                                            <th>Email</th>
                                            <th>Số người join</th>
                                            <th>Ngày đăng ký</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($results) && $results != null): ?>
                                            <?php foreach ($results as $key => $item): ?>
                                                <tr class="text-center">
                                                    <td><?php echo ($key+1); ?></td>
                                                    <td><?php echo $item['last_name']; ?></td>
                                                    <td><?php echo $item['email']; ?></td>
                                                    <td><?php echo $item['number_inver']; ?></td>
                                                    <td><?php echo date("d/m/Y, g:i A",strtotime($item["created_at"])); ?></td>
                                                </tr>
                                            <?php endforeach; ?> 
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <?php echo $this->pagination->create_links();?>
                                </div>
                            </div>
                        </div> 
                      </div>
                    </div>
                </div>
            </section>
            </div>
        </main>
    </div>
</div>
 
<style type="text/css">
    table.jambo_table thead{background: rgba(52, 73, 94, .94);color: #ECF0F1;}
    .bootstrap-tagsinput .tag{background-color: #fe5e57;padding: 3px 5px;}
</style>