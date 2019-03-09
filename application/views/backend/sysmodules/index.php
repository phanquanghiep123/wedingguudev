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
					<form method="post">
						<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
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
										<th>Tên chức năng</th>
										<th>Đường dẫn</th>
										<th>Thứ tự</th>
										<th>Trạng thái</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								   <?php echo (isset($html_modules)) ? $html_modules : "";?>
								</tbody>
							</table>
						</div>
						<div class="text-right"><button id="send" type="submit" class="btn btn-success">Cập nhật thứ tự</button></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>