<section class="page-content">
	<div class="container">
		<div class="section-body">
			<div class="row">
				<div class="col-sm-12">
					<form class="form form-account" action="<?php echo base_url('/account/signup'); ?>">
						<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
						<div class="form-header">
					        <h1 class="modal-title text-center">Đăng ký tài khoản</h1>
					        <p class="text-center">Bạn đã có tài khoản? <a href="<?php echo base_url('/account/login'); ?>">Đăng nhập</a> ngay</p>
							<hr>
							<div style="height: 10px;"></div>
						</div>
						<div class="form-content">
							<div class="message" style="disaplay:none;margin-bottom: 30px;"></div>
				        	<!--<div class="form-group">
				        		<input class="form-control inputText" type="text" name="first_name" maxlength="50" required>
				        		<div class="pladehoder">Họ đệm</div>
				        	</div>

				        	<div class="form-group">
				        		<input class="form-control inputText" type="text" name="last_name" maxlength="50">
				        		<div class="pladehoder">Họ và tên</div>
				        	</div>-->

				        	<div class="form-group">
				        		<input class="form-control inputText" type="email" name="email" required>
				        		<div class="pladehoder">Địa chỉ Email</div>
				        	</div>

				        	<!--
				        	<div class="form-group">
				        		<input class="form-control inputText" type="text" maxlength="12" name="phone_number">
				        		<div class="pladehoder">Số điện thoại</div>
				        	</div>-->

				        	<div class="form-group remove-margin">
				        		<input class="form-control inputText" type="password" maxlength="50" name="pwd" required>
				        		<div class="pladehoder">Mật khẩu</div>
				        	</div>

				        	<div style="height: 10px;"></div>
				        	<div class="row">
				        		<div class="col-xs-12">
						        	<div class="form-group">
		                            	<div class="checkbox" style="padding-left: 15px;">
					        				<input id="is_dealer" type="checkbox" name="is_dealer" value="1">
			                        		<label for="is_dealer">Đăng ký Cộng tác viên => <a href="<?php echo base_url('trang/cong-tac-vien'); ?>"> Xem thêm</a></label>
				        				</div>
		                            </div>
		                   		</div> 
		                   	</div>

				        	<div class="form-group">
				        		<label style="font-size: 12px;">TÊN WEBSITE CƯỚI</label>
				        		<div class="input-group input-domain">
		                            <input type="text" class="form-control" name="subdomain" placeholder="abc123" aria-describedby="basic-addon2" required>
		                            <span class="input-group-addon" id="basic-addon2">.weddingguu.com</span>
		                        </div>
				        	</div>

				        	<div class="checkbox checkbox-signup">
		                        <input id="checkbox" type="checkbox" required>
		                        <label for="checkbox">
		                            Tôi đồng ý với <a href="<?php echo base_url('/trang/chinh-sach-bao-mat/'); ?>">chính sách bảo mật</a> và <a href="<?php echo base_url('/trang/dieu-khoan-su-dung/'); ?>">điều khoản sử dụng</a>
		                        </label>
		                    </div>
				        	
				        	<div class="row">
				        		<div class="col-md-12">
				        			<input type="hidden" name="promo_code" value="<?php echo @$promo_code; ?>">
				        			<button class="btn btn-primary btn-lg" type="submit" name="submit">Đăng ký</button>
				        		</div>
				        	</div>
				        	<input type="hidden" name="fbclid" value="<?php echo $this->input->get("fbclid")?>">
						</div>
						<hr>
						<div class="form-footer">
							<div class="signin-social text-center">
				        		<p class="text-center">Đăng ký qua mạng xã hội</p>
				        		<ul class="list-inline text-center">
				        			<li><a href="<?php echo base_url('/social/facebook'); ?>" class="btn btn-facebook">&nbsp;<i class="fa fa-facebook" ></i> Facebook&nbsp;</a></li>
				        			<li><a href="<?php echo base_url('/social/google'); ?>" class="btn btn-google"><i class="fa fa-google-plus"></i> Google +</a></li>
				        		</ul>
				        	</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$("form.form-account").submit(function(){
			$(".custom-loading").show();
			var data_form = $(this).serialize();
			var url = $(this).attr('action');
			var form = $(this);
		    form.find('.message').hide();
		    $.ajax({
		        type: 'POST',
		        dataType:'json',
		        url: url,
		        data: data_form,
		        success: function(data) {
		            if(data['status'] == 'success'){
		           	   form.find('.message').html(data['message']).show();
		            	form.find('input').each(function(){
		            		var type = $(this).attr('type');
		            		if(type != 'checkbox'){
		            			$(this).val('');
		            		}
		            		else{
		            			$(this).prop('checked',false);
		            		}
		            	});
		            }
		            else if(data['status'] == 'fail'){
		           	    form.find('.message').html(data['message']).show();
		            }
		        },
		        error: function(data){
		            //console.log(data['responseText']);
		        },
		        complete:function(){
		            $(".custom-loading").hide();
		        }
		    });
			return false;
		});
	});
</script>
<style type="text/css">
	#myNavbar .btn-account{display: none;}
</style>