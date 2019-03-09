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
									<th>Slug</th>
									<th>Trạng thái</th>
									<th>Ngày tạo</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							    <?php if (isset($html_category)): ?>
						        	<?php echo $html_category; ?>
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