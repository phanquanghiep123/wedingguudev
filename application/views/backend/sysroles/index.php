<div class="main-page <?php echo @$main_page;?>">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>
			    		<?php echo @$title_page; ?>
			    		<?php $this->load->view(@$backend_asset.'/includes/add_new',array('is_add' => @$is_add,'base_controller' => @$base_controller)); ?>	
			    	</h2>
					<div class="clearfix"></div>
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
									<th># </th>
									<th>Tên phân quyền</th>
									<th>Mô tả</th>
									<th>Ngày tạo</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							    <?php if(isset($table_data)): ?>
							        <?php foreach ($table_data as $key => $value): ?>
							    		<tr>
											<td><?php echo ($key+1);?> </td>
											<td><?php echo $value["Role_Title"]?></td>
											<td><?php echo $value["Role_Description"]?></td>
											<td><?php echo date("d/m/Y, g:i A",strtotime($value["Createdat"])); ?></td>
											<td>
												<?php $this->load->view(@$backend_asset.'/includes/edit_delete',array('id' => @$value["ID"],'is_edit' => @$is_edit,'is_delete' => @$is_delete,'base_controller' => @$base_controller)); ?>
												<?php if($value["System"] != '1'):?> 
													| <a href="<?php echo backend_url(@$base_controller.'/details/'.$value["ID"])?>">Xem quyền</a>
												<?php endif;?>
											</td>
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