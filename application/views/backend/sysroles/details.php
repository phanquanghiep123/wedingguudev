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
					<form class="form-horizontal form-label-left" method="post" action="">
					    <div class="table-responsive">
							<table class="table table-striped jambo_table bulk_action">
								<thead>
									<tr>
										<th>#</th>
										<th>Chức năng</th>
										<th>Đường dẫn</th>
										<th class="text-center">Xem</th>
										<th class="text-center">Thêm mới</th>
										<th class="text-center">Sửa</th>
										<th class="text-center">Xóa</th>
										<th class="text-center">Tất cả</th>
									</tr>
								</thead>
								<tbody>
						    		<?php echo @$html_modules;?>								
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col-xs-12 text-right">
								<a href="<?php echo backend_url(@$base_controller);?>" class="btn btn-primary">Quay lại</a>
								<button type="submit" class="btn btn-success">Lưu thanh đổi</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('input.all').click(function(){
			if($(this).is(":checked")){
				$(this).parents('tr').find('input[type="checkbox"]').each(function(){
					$(this).prop('checked',true);
				});
			}
			else{
				$(this).parents('tr').find('input[type="checkbox"]').each(function(){
					$(this).prop('checked',false);
				});
			}
		});

		$('input[type="checkbox"]').click(function(){
			if($(this).is(":checked")){
				var check = true;
				$(this).parents('tr').find('input[type="checkbox"]').not('.all').each(function(){
					if(!$(this).is(":checked")){
						check = false;
					}
				});
				$(this).parents('tr').find('input.all').prop('checked',check);
			}
			else{
				$(this).parents('tr').find('input.all').prop('checked',false);
			}
		});
	});
</script>