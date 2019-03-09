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
						    		<?php $this->load->view(@$backend_asset.'/includes/add_new',array('is_add' => @$is_add,'base_controller' => @$base_controller)); ?>	
						    	</h2>
						    </div>
							<?php $this->load->view(@$backend_asset.'/includes/search'); ?>
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
									<th>Tiêu đề</th>
									<th>Chuyên mục</th>
									<th>Loại</th>
									<th>Trạng thái</th>
									<th>Ngày tạo</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							    <?php if (isset($gallery)): ?>
						        	<?php foreach ($gallery as $key => $item) : ?>
							    		<tr>
											<td><?php echo ($key+1);?> </td>
											<td><?php echo $item["name"]; ?></td>
											<td><?php echo $item["category"]; ?></td>
											<td><?php echo $item["type"] == 1 ? 'Hệ thống' : 'Người dùng'; ?></td>
											<td><?php echo @$item["status"] == 1 ? 'Hoạt động' : 'Ngưng hoạt động'; ?></td>
											<td><?php echo date("d/m/Y, g:i A",strtotime($item["create_at"])); ?></td>
											<td>
												<?php $this->load->view(@$backend_asset.'/includes/edit_delete',array('id' => @$item["id"],'is_edit' => @$is_edit,'is_delete' => @$is_delete,'base_controller' => @$base_controller)); ?>
											</td>
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