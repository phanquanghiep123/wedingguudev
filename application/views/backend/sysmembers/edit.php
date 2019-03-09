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
					<form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
						<div class="item form-group"> 
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Name">Họ và tên <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12"> 
								<input id="User_Name" class="form-control col-md-7 col-xs-12" value="<?php echo @$record["User_Name"];?>" name="User_Name" required="required" type="text"> 
							</div>
						</div>
						<div class="item form-group"> 
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Email">Email <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12"> 
								<input id="User_Email" class="form-control col-md-7 col-xs-12" value="<?php echo @$record["User_Email"];?>" placeholder="Email" type="email" required="required" <?php echo @$record != null ? 'disabled' : ''; ?>>
							</div>
						</div>
						<div class="item form-group"> 
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Pwd">Mật khẩu</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input id="User_Pwd" minlength = "6" class="form-control col-md-7 col-xs-12" value="" name="User_Pwd" placeholder="If you do not want to change your password please leave it blank" type="password" autocomplete="false">
							</div>
						</div>
						<div class="item form-group"> 
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Avatar">Ảnh đại diện</label>
							<div class="col-md-6 col-sm-6 col-xs-12"> 
							    <?php if(@$record["User_Avatar"] != null && @$record["User_Avatar"] != ""):?>
							    	<div class="row">
							    		<div class="col-md-4 col-xs-12"><img style="max-width: 100%;" src="<?php echo base_url($record["User_Avatar"])?>"></div>
										<div class="col-md-8 col-xs-12"><input id="User_Avatar" class="form-control" name="User_Avatar" placeholder="Avatar" type="file" accept="image/*"></div> 
									</div>
								<?php else :?>
									<input id="User_Avatar" class="form-control col-md-7 col-xs-12" name="User_Avatar" placeholder="Avatar" type="file" accept="image/*">
								<?php endif; ?>
							</div>
						</div>
						<div class="item form-group"> 
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Role_ID">Quyền <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12"> 
								<select id="Role_ID" class="form-control col-md-7 col-xs-12" name="Role_ID" required="required">   
							    	<?php if(isset($role)){
							    		foreach ($role as $key => $value) {
							    			if(@$value["ID"] == @$record["Role_ID"])
							    				echo '<option value="'.$value["ID"].'" selected >'.$value["Role_Title"].'</option>';
							    			else
							    				echo '<option value="'.$value["ID"].'">'.$value["Role_Title"].'</option>';
							    		}
							    	}?>
								</select>
							</div>
						</div>
						<div class="item form-group"> 
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Status">Trạng thái <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12"> 
								<select id="Status" class="form-control col-md-7 col-xs-12" name="Status" required="required">   
							    	<option value="1" <?php echo @$record['Status'] == 1 ? 'selected' : ''; ?>>Hoạt động</option>
                                	<option value="0" <?php echo @$record['Status']!= null && @$record['Status'] == 0 ? 'selected' : ''; ?>>Ngưng hoạt động</option>					    	
								</select>
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