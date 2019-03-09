<div class="main-page <?php echo @$main_page;?>">
	<div class="row">
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
								<tr>
									<th>#</th>
									<th>Họ tên</th>
									<th>Email</th>
									<th>Quyền</th>
									<th>Status</th>
									<th>Ngày đăng ký</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							    <?php if(isset($table_data)): ?>
							       <?php foreach ($table_data as $key => $item):?>
							    		<tr>
											<td><?php echo ($key+1);?> </td>
											<td><?php echo $item["User_Name"]?></td>
											<td><?php echo $item["User_Email"]?></td>
											<td><?php if(isset($role)){
												foreach($role as $k => $v){
													if($v["ID"] == $item["Role_ID"]){
														echo $v["Role_Title"];
													}
												}
										    }?></td>
										    <td><?php echo date("d/m/Y, g:i A",strtotime($item["Createdat"])); ?></td>
										    <td><?php echo ($item["Status"] == "1") ? "Hoạt động" : "Ngừng hoạt động";?></td>
											<td>
												<?php $this->load->view(@$backend_asset.'/includes/edit_delete',array('id' => @$item["ID"],'is_edit' => @$is_edit,'is_delete' => @$is_delete,'base_controller' => @$base_controller)); ?>
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