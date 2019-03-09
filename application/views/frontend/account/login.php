<section class="page-content">
	<div class="container">
		<div class="section-body">
			<div class="row">
				<div class="col-sm-12">
					<form class="form form-account" action="<?php echo base_url('/account/signin'); ?>">
						<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
						<div class="form-header">
					        <h1 class="modal-title text-center">Đăng nhập</h1>
					        <p class="text-center">Bạn chưa có tài khoản? <a  href="<?php echo base_url('/account/register'); ?>" >Đăng ký</a> ngay</p>
							<hr>
							<div style="height: 10px;"></div>
						</div>
						<div class="form-content">
							<div class="message" style="disaplay:none;margin-bottom: 30px;"></div>
				        	<div class="form-group">
				        		<input class="form-control inputText" type="email" name="email" required>
				        		<div class="pladehoder">Địa chỉ email</div>
				        	</div>

				        	<div class="form-group remove-margin">
				        		<input class="form-control inputText" type="password" name="pwd" required>
				        		<div class="pladehoder">Mật khẩu</div>
				        	</div>

				        	<div class="form-group">
				        		<div class="row">
				        			<div class="col-6">
				        				<div class="checkbox">
					        				<input id="remenber" type="checkbox" name="remember" value="1">
			                        		<label for="remenber">Lưu đăng nhập</label>
		                        		</div>
				        			</div>
				        			<div class="col-6 text-right">
				        				<a href="<?php echo base_url('/account/forgot'); ?>">Quên mật khẩu</a>
				        			</div>
				        		</div>
		                    </div>
				        	
				        	<div class="row">
				        		<div class="col-md-12 text-center">
				        			<button class="btn btn-primary btn-lg" type="submit" name="submit">Đăng nhập</button>
				        			<input type="hidden" name="redirect" value="<?php echo $this->input->get('redirect'); ?>">
				        		</div>
				        	</div>
						</div>
						<hr>
						<div class="form-footer">
							<div class="signin-social text-center">
				        		<p class="text-center">Đăng nhập qua mạng xã hội</p>
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
		           	   if(data['redirect'] != null){
		           	   	  window.location.href = data['redirect'];
		           	   }
		           	   else{
		           	   	 location.reload();
		           	   }
		            }
		            else if(data['status'] == 'fail'){
		           	   form.find('.message').html(data['message']).show();
		            }
		        },
		        error: function(data){
		            console.log(data['responseText']);
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