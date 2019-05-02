<div class="page-content">
    <div class="container">
        <div class="row">
            <main class="site-main col-sm-10 col-sm-push-1 col-sm-pull-1 col-md-8 col-md-push-2 col-md-pull-2">
                <form class="form-horizontal form-profile form" method="post" action="<?php echo base_url("profile")?>">
                    <input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
                    <div class="panel panel-default">
                        <div class="panel-heading">
    						<div class="row">
    							<div class="col-sm-6">[{]PROFILE[}]</div>
    							<div class="col-sm-6 text-right">[{]PROFILE_DAY_END[}]: <?php echo date('d/m/Y', strtotime(@$user["expired_date"])); ?></div>
    						</div>
    					</div>
                        <div class="panel-body">
                            <?php 
                                if($this->session->flashdata('message')){
                                    echo  $this->session->flashdata('message');
                                }
                                $user = @$user1;
                            ?>
                            <div class="text-center">
                                <div class="box-avatar">
                                    <img class="blank" alt="" src="<?php echo (@$user["avatar"] != null) ? $user["avatar"] : skin_frontend('images/user_default.png'); ?>" id="image_avatar_prev" style="width: 120px;height: 120px;display: inline-block;" width="120" height="120">
                                    <div class="edit-avatar">
                                        <div class="box-table">
                                            <div class="box-table-cell box-table-cell-middle">
                                                <a class="text-white" href="#" onclick="$('#ImageUploader_image').click();return false;">
                                                    <i class="fa fa-3 fa-plus-circle"></i><br> 
                                                    <small>[{]PROFILE_AVATAR[}]</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="message"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_last_name" class="col-sm-3 control-label">[{]FULL_NAME[}]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control required" validate="true"data-validate="required|max:50" value="<?php echo @$user['last_name']; ?>" name="last_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">[{]PROFILE_WEDDING_DAY[}]</label>
                                <div class="col-sm-9">
                                    <input type="text" style="padding: .375rem .75rem;" class="form-control datepicker" value="<?php echo @$user['wedding_date'] != null && @$user['wedding_date'] != '0000-00-00' ? date('d/m/Y',strtotime($user['wedding_date'])) : ''; ?>" name="wedding_date" validate="true" data-validate="required|date">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 control-label">[{]PROFILE_MAIL[}]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control required" value="<?php echo @$user['email']; ?>" id="email" placeholder="[{]PROFILE_MAIL[}]" required readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_sex" class="col-sm-3 control-label">[{]PROFILE_GENDER[}]</label>
                                <div class="col-sm-9">
                                    <div class="select-wrapper">
                                        <select id="user_sex" name="gender" class="form-control" validate="true" data-validate="required">
                                            <option value="1" <?php echo @$user['gender'] == 1 ? 'selected' : ''; ?>>[{]PROFILE_GENDER_MALE[}]</option>
                                            <option value="0" <?php echo @$user['gender'] != null && @$user['gender'] == 0 ? 'selected' : ''; ?>>[{]PROFILE_GENDER_FEMALE[}]</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                            	<div class="checkbox" style="padding-left: 0;">
			        				<input id="remenber" type="checkbox" name="is_dealer" value="1" <?php echo @$user['is_dealer'] == 1 ? 'checked' : ''; ?>>
	                        		<label for="remenber">[{]PROFILE_SIGNUP_CUSTOMER[}]</label>
		        				</div>
                            </div>

                            <div class="form-group row">
                                <label for="user_phone" class="col-sm-3 control-label">[{]PHONE[}]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo @$user['phone']; ?>" name="phone" validate="true" data-validate="phone">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="content-box-cented">
                                    <div class="row">
                                        <div class="col-sm-12"><p style="margin-bottom: 10px;">[{]PROFILE_ADD_SUB_DOMAIN_EXPLAIN[}]</p></div>   
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1 text-center">
                                            <div class="checkbox" style="padding-left: 0;">
                                                <input id="theme-type1" type="checkbox" name="domain_sub_allow" value="2" <?php echo @$user['sub_domain'] != null ? 'checked disabled' : ''; ?>>
                                                <label for="theme-type1"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-11">
                                            <div class="input-group input-domain">
                                                <?php
                                                    $sub_domain = @$user['sub_domain'];
                                                    if(@$sub_domain){
                                                        $sub_domain = str_replace(".weddingguu.com","", $sub_domain);
                                                        echo '<input type="text" class="form-control is_has_string" id="subdomain-name" value="'.$sub_domain.'" placeholder="[{]PROFILE_ENTER_NAME[}]" aria-describedby="basic-addon2" disabled="" readonly>';
                                                    }
                                                    else{
                                                        echo '<input type="text" class="form-control" id="subdomain-name" name="subdomain" placeholder="[{]PROFILE_ENTER_NAME[}]" aria-describedby="basic-addon2" disabled>';
                                                    }
                                                ?>
                                                <span class="input-group-addon" id="basic-addon2">.weddingguu.com</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p style="margin-bottom: 10px;">
                                                [{]PROFILE_ADD_DOMAIN_EXPLAIN|<a href="tel:0234-629-6688">0234-629-6688</a>[}]
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-1 text-center">
                                                    <div class="checkbox" style="padding-left: 0;">
                                                        <input class="theme-type" id="theme-type0" type="checkbox" name="type" value="1" <?php echo @$user['domain'] != null ? 'checked disabled' : ''; ?>>
                                                        <label for="theme-type0"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-11">
                                                    <?php
                                                        $domain = @$user['domain'];
                                                        if(@$domain){
                                                            echo '<input type="text" class="form-control input-domain is_has_string" validate="true" data-validate="url" id="domain-name" value="'.$domain.'" placeholder="[{]PROFILE_PLEASE_ENTER_DOMAIN[}]" disabled readonly>';
                                                        }
                                                        else{
                                                            echo '<input type="text" class="form-control input-domain" id="domain-name" validate="true" data-validate="url" name="domain" placeholder="[{]PROFILE_PLEASE_ENTER_DOMAIN[}]" disabled="">';
                                                        }
                                                    ?>
                                                    <p class="text-right" style="margin-top: 10px;"><a href="<?php echo base_url('trang/hoi-dap'); ?>?id=collapse-8" target="_blank">[{]PROFILE_SEE_GUIDE[}]</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                            <div class="form-group text-right row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">[{]PROFILE_SAVE[}]</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal" id="imageCropper-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form class="custom" enctype="multipart/form-data" id="crop-avatar-forms" action="<?php echo base_url("profile/save_media"); ?>" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="modal-label">[{]PROFILE_CHANGE_AVATAR[}]</h4>
            </div>
            <div class="modal-body" style="position: relative;">
                <input type="hidden" id="x" name="x">
                <input type="hidden" id="y" name="y">
                <input type="hidden" id="w" name="w">
                <input type="hidden" id="h" name="h">
                <input type="hidden" value="" name="image_w" id="image_w">
                <input type="hidden" value="" name="image_h" id="image_h">
                <input style="display:none;" accept="image/*" onchange="readURL(this);" name="fileupload" id="ImageUploader_image" type="file">
                <img id="uploadPreview" src="" style="display:none; max-width:100%;">
            </div>
            <div class="modal-footer text-right">
                <input id="btnSaveView2" disabled="disabled" class="btn btn-primary" type="submit" name="yt2" value="Lưu thay đổi">
            </div>
         </form>
      </div>
   </div>
</div>
<link href="<?php echo skin_backend('bootstrap-datepicker/css/bootstrap-datepicker.css'); ?>" rel="stylesheet">
<link href="<?php echo skin_frontend('css/jquery.Jcrop.css'); ?>" rel="stylesheet">
<script src="<?php echo skin_frontend('js/jquery.form.js'); ?>" type="text/javascript"></script>
<script src="<?php echo skin_frontend('js/jquery.Jcrop.js'); ?>"></script>
<script type="text/javascript" src="<?php echo skin_backend('bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo skin_frontend('js/form-validation.js'); ?>"></script>
<script src="<?php echo skin_frontend('js/jquery.form.js'); ?>"></script>
<script type="text/javascript">
    function ValidURL(str) {
        var re = new RegExp(/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$/); 
        return str.match(re);
    }
     
    $(document).ready(function() {
        var form = $(".form.form-profile");
        var validate = form.validateform({
            message : {
                "email" : _LANG.VALIDATE_EMAIL_COREET,
                "required" : _LANG.VALIDATE_REQUIRED, 
                "min" : _LANG.VALIDATE_MIN_LENGTH,
                "url" : _LANG.VALIDATE_URL,
                "date" : _LANG.VALIDATE_DATE,
                "phone" : _LANG.VALIDATE_PHONE
            },
            phone : function($pramte1,$pramte2,$pramte3,$pramte4){
                var filter = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
                return filter.test($pramte2);
            }
        });
        form.submit(function(){  
            var url  = $(this).attr('action');
            if(validate.checkInvalid()){
                $(".custom-loading").show();
                $(this).ajaxSubmit({
                    dataType:"json",
                    type:"post",
                    success: function(response){
                        if(response['status'] == 1){
                            var tt = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                              <strong>`+_LANG.MESSAGER+`! </strong>`+response['message']+`
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>`;
                            form.find('.message').html(tt); 
                        }
                        else if(response['status'] == 0){
                            $.each(response['message'],function(k,v){
                                validate.addError(k,v);
                            })
                            validate.showError();
                        }
                        $(".custom-loading").hide();
                    }
                });
            }
            return false;
        })
        $('.datepicker').datepicker({ format: 'dd/mm/yyyy' });
        $("#crop-avatar-forms").submit(function(){
            $(".custom-loading").show();
            var options = {
                dataType:'json',
                beforeSend: function(){
                },
                uploadProgress: function(event, position, total, percentComplete){
                },
                success: function(data){
                    console.log(data);
                    if(data['status']=='success'){
                        $("#image_avatar_prev").attr('src',data['name']);
                        $(".nav-profile img").attr('src',data['name']);
                        $('#imageCropper-modal').modal('toggle');
                    }
                },
                complete: function(response){
                    $(".custom-loading").hide();
                },
                error: function(data){
                    console.log(data['responseText']);
                    alert('Lỗi.');
                }
            }; 
            $(this).ajaxSubmit(options);
            return false;
        });
        $(".theme-type").change(function(){
            if($(this).is(":checked")){
                $("#domain-name").prop('disabled', false).val("");
            }else{
                $("#domain-name").prop('disabled', true).val("");
            }
        });
        $("#theme-type1").change(function(){
            if($(this).is(":checked")){
                $("#subdomain-name").removeAttr('disabled');
            }else{
                $("#subdomain-name").attr('disabled','');
            }
        });
        
    });

    //---------------------
    //Upload file
    //--------------
    var supportsFile = true;
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        supportsFile = true;
    } else {
        supportsFile = false;
    }

    var jcrop_api=null;
    function readURL(input) {
        if (supportsFile && input.files && input.files[0]) {
            if (!checkUploadSize(input)) {
                return false;
            }
            var p = $("#imageCropper-modal #uploadPreview");
            $("#imageCropper-modal").modal("show");
            p.fadeOut();

            // prepare HTML5 FileReader
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("ImageUploader_image").files[0]);

            oFReader.onload = function(oFREvent) {
                p.attr("src", oFREvent.target.result).fadeIn();
                p.css('max-width','100%');
                //p.css('max-height', $(window).height());
                //p.class('large-11 large-centered columns');
            };
            $(".custom-loading").show();
            if (jcrop_api!=null && typeof jcrop_api != 'undefined') {
                jcrop_api.destroy();
                jcrop_api=null;
            }
            setTimeout(function(){
                p.Jcrop({
                    setSelect: [0,0,400,400],
                    minSize:[200,200],
                    onChange:  setInfo,
                    onRelease: clearCoords,
                    boxWidth: 600,
                    aspectRatio: 1/1,
                }, function(){
                    jcrop_api = this;
                });
                $(".custom-loading").hide();
            },1000);
        }// end if
    }
    $('#imageCropper-modal').on('hidden.bs.modal', function () {
        if (jcrop_api!=null && typeof jcrop_api != 'undefined') {
            jcrop_api.destroy();
            jcrop_api=null;
        }
        $('#imageCropper-modal #uploadPreview').removeAttr('style');
        $('body').addClass('modal-open');
    });

    // set info for cropping image using hidden fields
    function setInfo(c) {
        $("#x").val(c.x);
        $("#y").val(c.y);
        $("#w").val(c.w);
        $("#h").val(c.h);
        $('#image_w').val($('#imageCropper-modal .jcrop-holder').width());
        $('#image_h').val($('#imageCropper-modal .jcrop-holder').height());
        $("#imageCropper-modal #btnSaveView2").removeAttr('disabled');
    }

    function clearCoords(){
        $("#imageCropper-modal #btnSaveView2").attr('disabled','disabled');
    }

    function checkUploadSize(input) {

        if (input.files[0].size > 8400000) {
            alert("Image size exceeds limit.");
            return false;
        }
        var legal_types = Array("image/jpeg", "image/png", "image/jpg");
        if (!inArray(input.files[0].type, legal_types)) {
            alert("File format is invalid. Only upload jpeg or png");
            return false;
        }
        return true;
    }

    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (typeof haystack[i] == 'object') {
                if (arrayCompare(haystack[i], needle))
                    return true;
            } else {
                if (haystack[i] == needle)
                    return true;
            }
        }
        return false;
    }
</script>
<style type="text/css">
	#imageCropper-modal .modal-header{background-color: #fe5e57;}
	.form-profile .checkbox label:after{left: -1px;}
</style>