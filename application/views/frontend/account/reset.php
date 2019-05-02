<section class="page-content">
	<div class="container">
		<div class="section-body">
			<div class="row">
				<div class="col-sm-12">
					<form class="form form-account" action="<?php echo base_url('/account/send_reset'); ?>">
	
						<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
						<div class="form-header">
					        <h1 class="modal-title text-center">[{]L_RESET[}]</h1>
					        <p class="text-center"> [{]L_LOGIN_NOT_ACCOUNT[}]<a  href="<?php echo base_url('/account/register'); ?>" > [{]L_SIGNIN_NOW[}]</a></p>
							<hr>
							<div style="height: 10px;"></div>
						</div>
						<div class="form-content">
							<div class="message"></div>
				        	<div class="form-group">
				        		<input class="form-control inputText" type="password" name="password" minlength="6" required>
				        		<div class="pladehoder">[{]L_LOGIN_PASSWORD[}]</div>
				        	</div>
				        	<div class="form-group">
				        		<input class="form-control inputText" type="password" name="confirm_password" minlength="6" required>
				        		<div class="pladehoder">[{]L_RESET_PASSWORD_CF[}]</div>
				        	</div>
				        	<div class="row">
				        		<div class="col-md-12 text-center">
				        			<input type="hidden" name="email" value="<?php echo $this->input->get('email'); ?>">
				        			<input type="hidden" name="token" value="<?php echo $this->input->get('token'); ?>">
				        			<button class="btn btn-primary btn-lg" type="submit" name="submit">[{]L_RESET_SAVE_CHANGE[}]</button>
				        		</div>
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
		        	console.log(data);
		            form.find('.message').html(data['message']);
		            form.find('.message').show();
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