<div class="main-page <?php echo @$main_page;?>">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>
						<?php echo @$label; ?>
						<?php $this->load->view(@$backend_asset.'/includes/add_new',array('is_add' => @$is_add,'base_controller' => @$base_controller)); ?>	
					</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<?php 
                        if($this->session->flashdata('message')){
                            echo $this->session->flashdata('message');
                        }
                        if($this->session->flashdata('record') && @$record == null){
                            $record = $this->session->flashdata('record');
                        } 
                    ?>
					<form class="form-horizontal form-label-left" method="post">
						<div class="item form-group"> 
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Role_Title">Tên quyền <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12"> 
								<input id="Role_Title" class="form-control col-md-7 col-xs-12" value="<?php echo @$record["Role_Title"];?>" name="Role_Title" required="required" type="text">
							</div>
						</div>
						<div class="item form-group"> 
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Role_Description">Mô tả</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input id="Role_Description" class="form-control col-md-7 col-xs-12" value="<?php echo @$record["Role_Description"];?>" name="Role_Description"  type="text">
							</div>
						</div>
						<div class="ln_solid"></div>
						<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>