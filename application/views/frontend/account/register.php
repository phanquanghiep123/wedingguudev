<section class="page-content">
	<div class="container">
		<div class="section-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-account">
						<h1 class="text-center">[{]L_SIGNIN[}]</h1>
					    <p class="text-center">[{]L_SIGNIN_HAS_ACCOUNT[}] <a href="<?php echo base_url("account/login")?>" class="login-button">[{]L_LOGIN[}]</a></p>
						<form class="form" method="post" action="<?php echo base_url('/account/signup'); ?>">
				        	<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
				        	<div class="message" style="display:none;"></div>
				        	<div class="form-group">
				        		<input class="form-control inputText" type="email" name="email" required>
				        		<div class="pladehoder">[{]L_LOGIN_EMAIL[}]</div>
				        	</div>
				        	<div class="form-group remove-margin">
				        		<input class="form-control inputText" type="password" maxlength="50" name="pwd" required>
				        		<div class="pladehoder">[{]L_LOGIN_PASSWORD[}]</div>
				        	</div>
				        	<div class="form-group">
				        		<label style="font-size: 12px;">[{]L_SIGNIN_DOMAIN[}] </label>
				        		<div class="input-group input-domain">
		                            <input type="text" class="form-control" name="subdomain" placeholder="abc123" aria-describedby="basic-addon2" required>
		                            <span class="input-group-addon" id="basic-addon2">.weddingguu.com</span>
		                        </div>
				        	</div>
			
							<div class="checkbox checkbox-signup">
		                    	<div class="checkbox" style="padding-left: 0;">
			        				<input id="is_dealer" type="checkbox" name="is_dealer" value="1">
		                    		<label for="is_dealer">[{]L_SINGIN_CTV[}], <a target="_blank" href="<?php echo base_url('trang/cong-tac-vien'); ?>">[{]L_SINGIN_CTV_PRICE[}]</a></label>
		        				</div>
		                    </div>
		    
				        	<div class="checkbox checkbox-signup">
		                        <input id="checkbox" type="checkbox" required>
		                        <label for="checkbox">
		                        	[{]L_SINGIN_AGREE[}]
		                             <a href="<?php echo base_url('/trang/chinh-sach-bao-mat/'); ?>">[{]L_SINGIN_PRIVACY_POLICY[}]</a> [{]L_SINGIN_AND[}] <a href="<?php echo base_url('/trang/dieu-khoan-su-dung/'); ?>">[{]L_SINGIN_TERMS_OF_USER[}]</a>
		                        </label>
		                    </div>
				        	
				        	<div class="row">
				        		<div class="col-md-12 text-center">
				        			<button class="btn btn-primary btn-lg" type="submit" name="submit">[{]L_SIGNIN[}]</button>
				        		</div>
				        	</div>
				        	<hr>
				        	<div class="signin-social text-center">
				        		<p class="text-center">[{]L_SINGIN_FOR_SOCIAL[}]</p>
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
	</div>
</section>
<style type="text/css">
	body .form-account{
		max-width: 440px;
	}
</style>
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