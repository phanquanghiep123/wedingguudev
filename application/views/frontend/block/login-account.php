<!-- modal singup -->
<div id="modal-signup" class="modal" role="dialog">
  	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">x</button>
		        <h1 class="modal-title text-center">[{]L_SIGNIN[}]</h1>
		        <p class="text-center">[{]L_SIGNIN_HAS_ACCOUNT[}] <a href="#" class="login-button">[{]L_LOGIN[}]</a></p>
	      	</div>
	      	<div class="modal-body">
		        <form class="form" method="post" action="<?php echo base_url('/account/signup'); ?>">
		        	<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
		        	<div class="message" style="display:none;"></div>
		        	<div class="form-group">
		        		<input class="form-control inputText" type="text" name="email" validate="true" data-validate="required|email">
		        		<div class="pladehoder">[{]L_LOGIN_EMAIL[}]</div>
		        	</div>
		        	<div class="form-group remove-margin">
		        		<input class="form-control inputText" type="password" name="pwd" validate="true" data-validate="required|min:6">
		        		<div class="pladehoder">[{]L_LOGIN_PASSWORD[}]</div>
		        	</div>
		        	<div class="form-group">
		        		<label style="font-size: 12px;">[{]L_SIGNIN_DOMAIN[}] </label>
		        		<div class="input-group input-domain">
                            <input type="text" class="form-control" name="subdomain" placeholder="abc123" aria-describedby="basic-addon2" validate="true" data-validate="required">
                            <span class="input-group-addon" id="basic-addon2">.weddingguu.com</span>
                        </div>
		        	</div>
					<div class="checkbox checkbox-signup" style="padding-left: 0;">
                    	<div class="checkbox" style="padding-left: 0;">
	        				<input id="is_dealer" type="checkbox" name="is_dealer" value="1">
                    		<label for="is_dealer">[{]L_SINGIN_CTV[}], <a target="_blank" href="<?php echo base_url('trang/cong-tac-vien'); ?>">[{]L_SINGIN_CTV_PRICE[}]</a></label>
        				</div>
                    </div>
    
		        	<div class="checkbox checkbox-signup" style="padding-left: 0;">
                        <input id="checkbox" type="checkbox" validate="true" data-validate="required">
                        <label for="checkbox">
                        	[{]L_SINGIN_AGREE[}]
                            <a href="<?php echo base_url('/trang/chinh-sach-bao-mat/'); ?>">[{]L_SINGIN_PRIVACY_POLICY[}]</a> [{]L_SINGIN_AND[}] <a href="<?php echo base_url('/trang/dieu-khoan-su-dung/'); ?>">[{]L_SINGIN_TERMS_OF_USER[}]</a>
                        </label>
                    </div>
		        	
		        	<div class="row">
		        		<div class="col-md-12">
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
<!-- /. close modal signup -->

<!-- modal login -->
<div id="modal-login" class="modal" role="dialog">
  	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">x</button>
		        <h1 class="modal-title text-center">[{]L_LOGIN[}]</h1>
		        <p class="text-center">[{]L_LOGIN_NOT_ACCOUNT[}] <a href="#" class="signup-button"> [{]L_SIGNIN_NOW[}]</a></p>
	      	</div>
	      	<div class="modal-body">
		        <form class="form" method="post" action="<?php echo base_url('/account/signin'); ?>">
		        	<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
		        	<div class="message" style="disaplay:none;"></div>
		        	<div class="form-group">
		        		<input class="form-control inputText" type="text" validate="true" data-validate="required|email" name="email">
		        		<div class="pladehoder">[{]L_LOGIN_EMAIL[}]</div>
		        	</div>
		        	<div class="form-group remove-margin">
		        		<input class="form-control inputText" type="password" name="pwd" validate="true" data-validate="required|min:6">
		        		<div class="pladehoder">[{]L_LOGIN_PASSWORD[}]</div>
		        	</div>
		        	<div class="form-group">
		        		<div class="row">
		        			<div class="col-6">
		        				<div class="checkbox" style=" padding-left: 0; ">
			        				<input id="remenber" type="checkbox" name="remember" value="1">
	                        		<label for="remenber">[{]L_LOGIN_REMIMEMBER[}]</label>
		        				</div>
		        			</div>
		        			<div class="col-6 text-right">
		        				<a href="<?php echo base_url('/account/forgot'); ?>">[{]L_LOGIN_FORGOT[}]</a>
		        			</div>
		        		</div>
                    </div>
		        	
		        	<div class="row">
		        		<div class="col-md-12">
		        			<button class="btn btn-primary btn-lg" type="submit" name="submit">[{]L_LOGIN[}]</button>
		        			<input type="hidden" name="redirect" value="<?php echo $this->input->get('redirect'); ?>">
		        		</div>
		        	</div>
		        	<hr>
		        	<div class="signin-social text-center">
		        		<p class="text-center">[{]L_LOGIN_FOR_SOCIAL[}]
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
<script type="text/javascript" src="<?php echo skin_url("frontend/js/form-validation.js")?>"></script>
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
			var data_form = $(this).serialize();
			var url  = $(this).attr('action');
			var form = $(this);
			var validate = form.validateform({
				message : {
					"email" : _LANG.VALIDATE_EMAIL_COREET,
					"required" : _LANG.VALIDATE_REQUIRED, 
					"min" : _LANG.VALIDATE_MIN_LENGTH
				},
				beforeadderror:function(check,options,_childe,message,validatefunction){
					_childe.closest(".form-group").find(".validate-error").remove();
					_childe.closest(".form-group").append('<p class="validate-error error" style="color:'+this.colorString+'; font-size:'+this.fontsizeString+'"><span>'+message+"<span></p>");
					return false;
				},
			});

			if(validate.checkInvalid()){
				$(".custom-loading").show();
		    	$.ajax({
			        type: 'POST',
			        dataType:'json',
			        url: url,
			        data: data_form,
			        success: function(data) {
			            if(data['status'] == 1){
			           	   form.find('.message').html(data['message']).show();
			           	   if(data['redirect'] != null){
			           	   	  window.location.href = data['redirect'];
			           	   }
			           	   else{
			           	   	  location.reload();
			           	   }
			            }
			            else if(data['status'] == 0){
			            	$.each(data['message'],function(k,v){
			            		validate.addError(k,v);
			            	})
			           	    validate.showError();
			            }
			            form.find('.message').hide();
			        },
			        error: function(data){
			            //console.log(data['responseText']);
			        },
			        complete:function(){
			            $(".custom-loading").hide();
			        }
			    });
			}
			return false;
		});
		$("#modal-signup form").submit(function(){
			var data_form = $(this).serialize();
			var url = $(this).attr('action');
			var form = $(this);
		    var validate = form.validateform({
				message : {
					"email" : _LANG.VALIDATE_EMAIL_COREET,
					"required" : _LANG.VALIDATE_REQUIRED, 
					"min" : _LANG.VALIDATE_MIN_LENGTH
				},
				beforeadderror:function(check,options,_childe,message,validatefunction){
					if(_childe.attr("type") == "checkbox"){ 
						_childe.closest(".checkbox").find(".validate-error").remove();
						_childe.closest(".checkbox").append('<p class="validate-error error" style="color:'+this.colorString+'; font-size:'+this.fontsizeString+'"><span>'+_LANG.VALIDATE_AGREE+"<span></p>");
					}else{
						_childe.closest(".form-group").find(".validate-error").remove();
						_childe.closest(".form-group").append('<p class="validate-error error" style="color:'+this.colorString+'; font-size:'+this.fontsizeString+'"><span>'+message+"<span></p>");
					}
					return false;
				},
			});
			if(validate.checkInvalid()){
				$(".custom-loading").show();
			    $.ajax({
			        type: 'POST',
			        dataType:'json',
			        url: url,
			        data: data_form,
			        success: function(data) {
			            if(data['status'] == 1){
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
			            else if(data['status'] == 0){
			            	$.each(data['message'],function(k,v){
			            		validate.addError(k,v);
			            	})
			           	    validate.showError();
			            }
			            form.find('.message').hide();
			        },
			        error: function(data){
			            //console.log(data['responseText']);
			        },
			        complete:function(){
			            $(".custom-loading").hide();
			        }
			    });
			}
			return false;
		});
	});
</script>