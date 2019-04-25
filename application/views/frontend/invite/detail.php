<link rel="stylesheet" type="text/css" href="<?php echo skin_frontend('css/bootstrap-tagsinput.css'); ?>">  
<script src="<?php echo skin_frontend('js/bootstrap-tagsinput.js'); ?>"></script>
<section class="page-head banner-page">
    <div class="page-head-opacity">
        <div class="page-head-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title text-center" style="padding-top: 10px;">Chi tiết thanh toán</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="page-container" style="width: auto;padding: 0;margin-top: 0;">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <section class="section-firts">
                <div class="irefer-wrap">
                    <div class="container">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="results">
                                <div style="height: 5px;"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings text-center">
                                                <th>Thông tin thành viên</th>
                                                <th>Gói</th>
                                                <th>Giá</th>
                                                <th>% hoa hồng</th>
                                                <th>Phí hoa hồng</th>
                                            </tr>
                                        </thead>
                                        <tbody>   
                                            <?php if(isset($payments) && $payments != null): ?>
                                                <?php foreach ($payments as $key => $item): ?>
                                                    <?php
                                                        if($key == 0){
                                                            echo '<tr>
                                                                <td rowspan="'.count($payments).'">
                                                                    <p>Email: '.$member["email"].'</p>
                                                                    <p>Họ và tên'.$member["first_name"]. ' ' .$member["last_name"].'</p>
                                                                    <p>sub_domain: '.$member["sub_domain"].'.weddingguu.com</p>
                                                                    <p>domain: '.$member["domain"].'</p>
                                                                    <p>Ngày tạo: '.date("d/m/Y, g:i A",strtotime($member["created_at"])).'</p>
                                                                </td>';
                                                        }
                                                    ?>
                                                        <td class="text-center"><?php echo $item["name"]?></td>
                                                        <td class="text-center"><?php echo $item["total_price"]?> VND</td>
                                                        <td class="text-center"><?php echo $item["commission"]?> %</td>
                                                        <td class="text-center"><?php echo $item["commission_money"]?> VND</td>
                                                    </tr>
                                                <?php endforeach; ?> 
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                          </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
 
<style type="text/css">
    table.jambo_table thead{background: rgba(52, 73, 94, .94);color: #ECF0F1;}
    .bootstrap-tagsinput .tag{background-color: #fe5e57;padding: 3px 5px;}
</style>