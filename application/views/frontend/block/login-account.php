<!-- modal singup -->
<div id="modal-signup" class="modal" role="dialog">
  	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">x</button>
		        <h1 class="modal-title text-center">Đăng ký</h1>
		        <p class="text-center">Bạn đã có tài khoản? <a href="#" class="login-button">Đăng nhập</a> ngay</p>
	      	</div>
	      	<div class="modal-body">
		        <form class="form" method="post" action="<?php echo base_url('/account/signup'); ?>">
		        	<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
		        	<div class="message" style="display:none;"></div>
		        	<!--<div class="form-group">
		        		<input class="form-control inputText" type="text" name="first_name" maxlength="50" required>
		        		<div class="pladehoder">Họ đệm</div>
		        	</div>
		        	<div class="form-group">
		        		<input class="form-control inputText" type="text" name="last_name" maxlength="50" required>
		        		<div class="pladehoder">Họ và tên</div>
		        	</div>-->
		        	<div class="form-group">
		        		<input class="form-control inputText" type="email" name="email" required>
		        		<div class="pladehoder">Địa chỉ Email</div>
		        	</div>
		        	<!--
		        	<div class="form-group">
		        		<input class="form-control inputText" type="text" maxlength="12" name="phone" required>
		        		<div class="pladehoder">Số điện thoại</div>
		        	</div>-->
		        	<div class="form-group remove-margin">
		        		<input class="form-control inputText" type="password" maxlength="50" name="pwd" required>
		        		<div class="pladehoder">Mật khẩu</div>
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
		        			<button class="btn btn-primary btn-lg" type="submit" name="submit">Đăng ký</button>
		        		</div>
		        	</div>
		        	<hr>
		        	<div class="signin-social text-center">
		        		<p class="text-center">Hoặc đăng ký qua mạng xã hội</p>
		        		<ul class="list-inline text-center">
		        			<li><a href="<?php echo base_url('/social/facebook'); ?>" class="btn btn-facebook">&nbsp;<i class="fa fa-facebook" ></i> Facebook&nbsp;</a></li>
		        			<li><a href="<?php echo base_url('/social/google'); ?>" class="btn btn-google"><i class="fa fa-google-plus"></i> Google +</a></li>
		        		</ul>
		        	</div>
		        </form>
	      	</div>
	    </div>

  	</div>
</div>
<!-- /. close modal signup -->

<!-- modal login -->
<div id="modal-login" class="modal" role="dialog">
  	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">x</button>
		        <h1 class="modal-title text-center">Đăng nhập</h1>
		        <p class="text-center">Bạn chưa có tài khoản? <a href="#" class="signup-button">Đăng ký</a> ngay</p>
	      	</div>
	      	<div class="modal-body">
		        <form class="form" method="post" action="<?php echo base_url('/account/signin'); ?>">
		        	<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
		        	<div class="message" style="disaplay:none;"></div>
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
		        		<div class="col-md-12">
		        			<button class="btn btn-primary btn-lg" type="submit" name="submit">Đăng nhập</button>
		        			<input type="hidden" name="redirect" value="<?php echo $this->input->get('redirect'); ?>">
		        		</div>
		        	</div>
		        	<hr>
		        	<div class="signin-social text-center">
		        		<p class="text-center">Đăng nhập qua mạng xã hội</p>
		        		<ul class="list-inline text-center">
		        			<li><a href="<?php echo base_url('/social/facebook'); ?>" class="btn btn-facebook">&nbsp;<i class="fa fa-facebook" ></i> Facebook&nbsp;</a></li>
		        			<li><a href="<?php echo base_url('/social/google'); ?>" class="btn btn-google"><i class="fa fa-google-plus"></i> Google +</a></li>
		        		</ul>
		        	</div>
		        </form>
	      	</div>
	    </div>
  	</div>
</div>
<!-- /. close modal login -->

<script type="text/javascript">
	$(document).ready(function(){
		$("#myNavbar .btn-login > a").click(function(){
			$('#modal-login').modal('show');
			return false;
		});

		$("#myNavbar .btn-signup > a").click(function(){
			$('#modal-signup').modal('show');
			return false;
		});

		$("#modal-login .signup-button").click(function(){
			$('#modal-login').modal('toggle');
			setTimeout(function(){
				$('#modal-signup').modal('show');
			},200);
			return false;
		});

		$("#modal-signup .login-button").click(function(){
			$('#modal-signup').modal('toggle');
			setTimeout(function(){
				$('#modal-login').modal('show');
			},200);
			return false;
		});

		$("#modal-login form").submit(function(){
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
		            //console.log(data['responseText']);
		        },
		        complete:function(){
		            $(".custom-loading").hide();
		        }
		    });
			return false;
		});

		$("#modal-signup form").submit(function(){
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