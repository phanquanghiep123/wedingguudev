<!-- Modal -->
<!--SignUp-->
<div class="modal fade modal-signup-login" id="ModalSignup" tabindex="-1" role="dialog" aria-labelledby="ModalSignup">
    <div class="modal-dialog" role="document"  style="max-width:500px;">
        <form action="<?php echo base_url("account/signup"); ?>" method="post">
            <div class="modal-content">
                <div class="modal-body">
                    <button style="left: 20px;top: 5px;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <div style="height:20px;"></div>
                    <div class="group-before">
                        <div class="row">
                            <div class="col-sm-6">
                                <button class="btn btn-block btn-lg  btn-icon btn-facebook user-signup-facebook"><span><i class="fa fa-facebook" aria-hidden="true"></i></span>Facebook</button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-block btn-lg  btn-icon btn-google user-signup-google"><span><img src="<?php echo skin_frontend("images/ic_google.png"); ?>"></span>Google</button>
                            </div>
                        </div>
                    </div>

                    <div class="label-divider"><span>or</span></div>
                    <div class="message hidden"></div>
                    <a href="#" class="btn btn-block btn-lg btn-secondary btn-show-signup-email"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> Sign up with Email</a>
                    <div class="group-signup-email" style="display:none;">
	                    <div class="form-group">
	                        <input type="text" class="form-control" name="first_name" placeholder="First name" required>
	                    </div>
	                    <div class="form-group">
	                        <input type="text" class="form-control" name="last_name" placeholder="Last name" required>
	                    </div>
	                    <div class="form-group">
	                        <input type="text" class="form-control" name="address" placeholder="Address" required>
	                    </div>
	                    <div class="form-group">
	                        <input type="email" class="form-control" name="email" placeholder="Email address" required>
	                    </div>
	                    <div class="form-group">
	                        <input type="password" class="form-control" name="pwd" placeholder="Create a Password" required>
	                    </div>
	                    <h3>Birthday</h3>
	                    <p>To sign up, you must be 18 or order. Other people won't see your birthday.</p>
	                    <div class="row">
	                    	<div class="col-sm-4">
	                    		<div class="form-group">
			                        <select class="form-control" name="month" required>
			                        	<option value="">Month</option>
			                        	<?php for($i = 1; $i <= 12; $i++): ?>
			                        		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			                        	<?php endfor;?>
			                        </select>
			                    </div>
	                    	</div>
	                    	<div class="col-sm-4">
	                    		<select class="form-control" name="day" required>
		                        	<option value="">Day</option>
		                        	<?php for($i = 1; $i <= 31; $i++): ?>
		                        		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		                        	<?php endfor;?>
		                        </select>
	                    	</div>
	                    	<div class="col-sm-4">
	                    		<select class="form-control" name="year" required>
		                        	<option value="">Year</option>
		                        	<?php for($i = 1970; $i <= (date("Y") - 18); $i++): ?>
		                        		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		                        	<?php endfor;?>
		                        </select>
	                    	</div>
	                    </div>
	                    <!--/.row-->
	                    <div class="space-05"></div>
	                    <div class="checkbox checkbox-primary">
	                        <input id="receive-agree" class="styled" type="checkbox" checked="">
	                        <label for="receive-agree">
	                            I’d like to receive coupons, promotions, surveys, and updates via email about CouchStay and its partners.
	                        </label>
	                    </div>
	                    <div class="form-group">
                            <input type="hidden"  name="invite_code" value="<?php echo $this->input->get('invite_code'); ?>">
                            <button type="submit" class="btn btn-block btn-lg btn-secondary">Sign up</button>
	                    </div>
                    </div>
                    <div style="height:10px;"></div>
                    <p>By clicking Sign up or Continue with, I agree to CouchStay Terms of Service, Payments Terms of Service, Privacy Policy, and Nondiscrimination Policy. </p>
	                <hr>
	                <div class="row">
	                    <div class="col-sm-9">
	                        <div class="text-question">Already have an CouchStay account?</div>
	                    </div>
	                    <div class="col-sm-3 text-right">
	                        <button class="btn btn-secondary btn-login">Log in</button>
	                    </div>
	                </div>
	        	</div>
            </div>
        </form>
    </div>
</div>

<!--Login-->
<div class="modal fade modal-signup-login" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="ModalLogin">
    <div class="modal-dialog" role="document" style="max-width:450px;">
        <form action="<?php echo base_url("account/signin"); ?>" method="post">
            <div class="modal-content">
                <div class="modal-body">
                    <button style="left: 20px;top: 5px;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <div style="height:20px;"></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="<?php echo base_url("social/facebook"); ?>" class="btn btn-block btn-lg  btn-icon btn-facebook user-signup-facebook"><span><i class="fa fa-facebook" aria-hidden="true"></i></span>Facebook</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="<?php echo base_url("social/facebook"); ?>" class="btn btn-block btn-lg  btn-icon btn-google user-signup-google"><span><img src="<?php echo skin_frontend("images/ic_google.png") ?>"></span>Google</a>
                        </div>
                    </div>
                    <div class="label-divider"><span>or</span></div>
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
                        <div class="form-group">
                            <input class="form-control input-lg" type="email" name="email" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <input class="form-control input-lg" type="password" name="pwd" placeholder="Password">
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="checkbox checkbox-primary">
                                    <input id="remember-me" class="styled" name="remember" value="1" type="checkbox" checked="">
                                    <label for="remember-me">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 text-right">
                                <div class="space-10"></div>
                                <a href="#" class="btn-forgot">Forgot password?</a>
                            </div>
	                        <div class="form-group">
		                    	<input type="hidden" id="redirect"  name="redirect">
                                <button type="submit" class="btn btn-block btn-lg btn-secondary">Login</button>
		                    </div>
	                    </div>
	                    <hr>
	                    <div class="row">
	                        <div class="col-sm-8">
	                            <div class="text-question">Don’t have an account?</div>
	                        </div>
	                        <div class="col-sm-4 text-right">
                                <button class="btn btn-secondary-o btn-sign-up">Sign Up</button>
	                        </div>
	                    </div>
	            	</div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Forgot-->
<div class="modal fade modal-forgot" id="ModalForgot" tabindex="-1" role="dialog" aria-labelledby="ModalLogin">
    <div class="modal-dialog" role="document" style="max-width:450px;">
        <form action="<?php echo base_url("account/forgot") ?>" method="post">
            <div class="modal-content">
                <div class="modal-body">
                        <button style="left: 20px;top: 5px;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    	<div style="height:20px;"></div>
                    	<div class="alert alert-success" style="display:none;"></div>
                        <div class="alert alert-danger" style="display:none;"></div>
                        <div class="form-group">
                            <h3>Forgot Password</h3>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Your Email:</label>
                            <input class="form-control input-lg" type="email" name="email" required placeholder="Please enter your email">
                        </div>
                        <div class="form-group">
	                    	<button type="submit" class="btn btn-block btn-secondary">Send Mail</button>
	                    </div>
	            	</div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Reset-->
<div class="modal fade modal-reset" id="ModalReset" tabindex="-1" role="dialog" aria-labelledby="ModalLogin">
    <div class="modal-dialog" role="document" style="max-width:450px;">
        <form action="<?php echo base_url("account/reset") ?>" method="post">
            <div class="modal-content">
                <div class="modal-body">
                	<button style="left: 20px;top: 5px;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <div style="height:20px;"></div>
                	<div class="alert alert-success" style="display:none;"></div>
                    <div class="alert alert-danger" style="display:none;"></div>
                    <div class="form-group">
                        <h3>Reset Password</h3>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password:</label>
                        <input type="password" class="form-control input-lg" name="password" required placeholder="Please enter your password">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Confirm Password:</label>
                        <input type="password" class="form-control input-lg" name="confirm_password" required placeholder="Please enter your confirm password">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="email" value="<?php echo @$_GET['email']; ?>">
                        <input type="hidden" name="token" value="<?php echo @$_GET['token']; ?>">
                        <button type="submit" class="btn btn-block btn-secondary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        <?php if(isset($_GET['login']) && $_GET['login'] == true): ?>
            $("#ModalLogin").modal('show');
        <?php endif; ?>

        <?php if(isset($_GET['signup']) && $_GET['signup'] == true): ?>
            $("#ModalSignup").modal('show');
        <?php endif; ?>

        <?php if(isset($_GET['reset']) && $_GET['reset'] == 'reset' && isset($_GET['email']) && $_GET['email'] != null && isset($_GET['token']) && $_GET['token'] != null): ?>
            $("#ModalReset").modal('show');
        <?php endif; ?>

        var href = window.location.href;
        $("#ModalLogin #redirect").val(href);

        $("#ModalLogin .btn-sign-up").click(function(){
        	$("#ModalLogin").modal('toggle');
        	setTimeout(function(){
        		$("#ModalSignup").modal('show');
        	},500);
        	return false;
        });

        $("#ModalLogin .btn-forgot").click(function(){
        	$("#ModalLogin").modal('toggle');
        	setTimeout(function(){
        		$("#ModalForgot").modal('show');
        	},500);
        	return false;
        });

        $("#ModalSignup .btn-login").click(function(){
        	$("#ModalSignup").modal('toggle');
        	setTimeout(function(){
        		$("#ModalLogin").modal('show');
        	},500);
        	return false;
        });

        $("#ModalSignup form").submit(function(){
            var form = $(this);
            var data = $(this).serialize();
            $(".custom-loading").show();
            form.find(".message").addClass('hidden');
            $.ajax({
                "url": form.attr("action"),
                "type":"post",
                "dataType":"json",
                "data":data,
                success:function(data){
                    console.log(data);
                    return false;
                    if(data["status"] == "success"){
                        form.find(".message").html(data['message']);
                        form.find(".message").removeClass('hidden');
                        $("#ModalConfirmEmail input[nam='verify_email']").val(form.find('input[name="email"]').val());
                        $("#ModalSignup").modal('toggle');
                        setTimeout(function(){
                            $("#ModalJoin").modal('show');
                        },500);
                    }
                    else if(data["status"] == "fail"){
                        form.find(".message").html(data['message']);
                        form.find(".message").removeClass('hidden');
                    }
                },
                error: function(data){
                    console.log(data['responseText']);
                },
                complete: function(){
                    $(".custom-loading").hide();
                }
            });
            return false;
        });

        $("#ModalForgot form").submit(function(){
        	var form = $(this);
            var data = $(this).serialize();
            $(".custom-loading").show();
            form.find(".alert").hide();
            $.ajax({
                "url": form.attr("action"),
                "type":"post",
                "dataType":"json",
                "data":data,
                success:function(data){
                    console.log(data);
                    if(data["status"] == "success"){
                        form.find(".alert-success").html("Send mail successfully.").show();
                    }
                    else if(data["status"] == "fail"){
                        form.find(".alert-danger").html(data["message"]).show();
                    }
                },
                error: function(data){
                    console.log(data['responseText']);
                },
                complete: function(){
                    $(".custom-loading").hide();
                }
            });
        	return false;
        });

        $("#ModalReset form").submit(function(){
            var form = $(this);
            var data = $(this).serialize();
            $(".custom-loading").show();
            form.find(".alert").hide();
            $.ajax({
                "url": form.attr("action"),
                "type":"post",
                "dataType":"json",
                "data":data,
                success:function(data){
                    console.log(data);
                    if(data["status"] == "success"){
                        form.find(".alert-success").html("Save successfully. Please login.").show();
                        setTimeout(function(){
                           location.href = "<?php echo base_url(); ?>?login=true";
                        },500);
                    }
                    else if(data["status"] == "fail"){
                        form.find(".alert-danger").html(data["message"]).show();
                    }
                },
                error: function(data){
                    console.log(data['responseText']);
                },
                complete: function(){
                    $(".custom-loading").hide();
                }
            });
            return false;
        });

		$("#ModalSignup .btn-show-signup-email").click(function(){
			$("#ModalSignup .group-signup-email").show();
			$(this).hide();
			return false;
		});
    }); 
</script>