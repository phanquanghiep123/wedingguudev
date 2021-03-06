<div class="page-content">
    <div class="container">
        <div class="row">
            <main class="site-main col-sm-10 col-sm-push-1 col-sm-pull-1">
                <div class="panel panel-default">
                    <div class="panel-heading">[{]payment_history[}]</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>[{]payment_histor_package[}]</th>
                                        <th>[{]payment_number_month[}]</th>
                                        <th>[{]payment_total_price[}]</th>
                                        <th>[{]payment_start_day[}]</th>
                                        <th>[{]payment_end_day[}]</th>
                                        <th>[{]payment_status[}]</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($package)): ?>
                                        <?php foreach ($package as $key => $item) : ?>
                                            <tr>
                                                <td><?php echo ($key+1);?> </td>
                                                <td><?php echo $item["name"]; ?></td>
                                                <td><?php echo $item["months"]; ?></td>
                                                <td><?php echo number_format($item["total_price"]); ?> VNĐ</td>
                                                <td><?php echo date("d/m/Y",strtotime($item["start_date"])); ?></td>
                                                <td><?php echo date("d/m/Y",strtotime($item["expired_at"])); ?></td>
                                                <td>
                                                    <?php 
                                                        if(@$item["status"] == 1) {
                                                            echo '[{]payment_status_finish[}]';
                                                        }
                                                        else if(@$item["status"] == 2){
                                                            echo '[{]payment_status_cancelled[}]';
                                                        }
                                                        else{
                                                            echo '[{]payment_status_pedding[}]';
                                                        } 
                                                    ?>
                                                </td>
                                                <td><a href="<?php echo backend_url('profile/payment/'.@$item['id'])?>">[{]L_MESS_MORE[}]</a></td>
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
            </main>
        </div>
    </div>
</div>