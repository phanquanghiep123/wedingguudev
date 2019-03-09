<div class="row">
	<div class="main-page <?php echo @$main_page;?>">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<form action="" method="get">
						<div class="row">
							<div class="col-sm-7">
						    	<h2>
						    		<?php echo @$title_page; ?>
						    		<?php $this->load->view(@$backend_asset.'/includes/add_new',array('is_add' => @$is_add,'base_controller' => @$base_controller)); ?>	
						    	</h2>
						    </div>
							<?php $this->load->view(@$backend_asset.'/includes/search',array('is_status' => false)); ?>
						</div>
					</form>
				</div>
				<div class="x_content">
					<div class="row">
		         		<div class="col-sm-8">
		         			<?php 
					            if($this->session->flashdata('message')){
					                echo  $this->session->flashdata('message');
					            }
					        ?>
							<div class="table-responsive">
								<table class="table table-bordered table-striped m-b-0">
									<thead>
									    <tr>
										    <th style="width:50px;padding-left:8px;"># </th>
										    <th style="padding-left:5px;">Tiêu đề</th>
										    <th style="padding-left:5px;">Ngày tạo</th>
										    <th style="width:200px;">&nbsp;</th>
									    </tr>
									</thead>
									<tbody>
									  <?php if(isset($menus) && $menus!=null ): ?>
									    <?php foreach ($menus as $key => $value) : ?>
										    <tr>
											    <th><?php echo($key+1); ?></th>
											    <td><?php echo @$value['Name']; ?></td>
											    <td><?php echo date('d/m/Y g:i A',strtotime(@$value['Create_at'])); ?></td>
											    <td>
											    	<a href="<?php echo backend_url('menu/group_menu/'.$value['Group_ID']); ?>">Xem menu</a>
											    	<?php if(@$is_edit == 1): ?>
											    		 | <a href="<?php echo backend_url('menu/index/'.$value['Group_ID']); ?>" >Chỉnh sửa</a>
											    	<?php endif; ?>
											    	<?php if(@$is_delete == 1): ?>
											    		 | <a href="<?php echo backend_url('menu/delete/'.$value['Group_ID']); ?>" onclick="return confirm('Bạn thật sự muốn xóa?');">Xóa</a>
											    	<?php endif; ?>
											    </td>
										    </tr>
										<?php endforeach;?>
									  <?php endif; ?>
									</tbody>
								</table>
							</div>
							<div class="row">
						 		<div class="col-sm-12">
						 			<?php echo $this->pagination->create_links(); ?>
						 		</div>
						 	</div>
		         		</div>
		         		<div class="col-sm-4">
		         			<form class="form-add-menu-group" method="post" action="" >
		         				<div class="form-group">
		         				   <label>Tiêu đề:</label>
		         				   <input type="text" name="name" value="<?php echo @$menu['Name']; ?>" class="form-control" placeholder="Tiêu đề" required>
		         				</div>
		         				<div class="form-group text-right">
		         					<button type="submit" name="save_menu" class="btn btn-primary"><?php echo @$menu == null ? "Thêm mới" : "Lưu thay đổi"; ?></button>
		         				</div>
		         			</form>
		         		</div>
		         	</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.form-add-menu-group{
		padding: 20px;
    	border: 1px solid #ccc;
	}
</style>