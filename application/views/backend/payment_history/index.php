<div class="row">
	<div class="main-page <?php echo @$main_page;?>">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<form action="" method="get">
						<div class="row">
							<div class="col-sm-4">
						    	<h2>
						    		<?php echo @$title_page; ?>
						    	</h2>
						    </div>
						</div>
					</form>
				</div>
				<div class="x_content">
					<?php 
                        if($this->session->flashdata('message')){
                            echo $this->session->flashdata('message');
                        } 
                    ?>
					<div class="table-responsive">
						<table class="table table-striped jambo_table bulk_action">
							<thead>
								<tr class="headings">
									<th>#</th>
									<th>Người dùng</th>
									<th>Gói dịch vụ</th>
									<th>Số tháng</th>
									<th>Tổng tiền</th>
									<th>Ngày bắt đầu</th>
									<th>Ngày hết hạn</th>
									<th>Trạng thái</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							    <?php if (isset($package)): ?>
						        	<?php foreach ($package as $key => $item) : ?>
							    		<tr>
											<td><?php echo ($key+1);?> </td>
											<td><?php echo $item["last_name"]; ?></td>
											<td><?php echo $item["name"]; ?></td>
											<td><?php echo $item["months"]; ?></td>
											<td><?php echo number_format($item["total_price"]); ?> VNĐ</td>
											<td><?php echo date("d/m/Y",strtotime($item["start_date"])); ?></td>
											<td><?php echo date("d/m/Y",strtotime($item["expired_at"])); ?></td>
											<td>
												<?php 
													if(@$item["status"] == 1) {
														echo 'Hoàn thành';
													}
													else if(@$item["status"] == 2){
														echo 'Đã Hủy';
													}
													else{
														echo 'Đang chờ';
													} 
												?>
											</td>
											<td><a href="<?php echo backend_url(@$base_controller.'/view/'.@$item['id'])?>">Xem chi tiết</a></td>
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
</div>