<div class="page-content">
    <div class="container">
        <div class="row">
            <main class="site-main col-sm-10 col-sm-push-1 col-sm-pull-1 col-md-8 col-md-push-2 col-md-pull-2">
                <form class="form-horizontal form-profile" method="post" action="">
                    <input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
                    <div class="panel panel-default">
                        <div class="panel-heading">Thông tin cá nhân</div>
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
                                                    <small>Ảnh đại diện</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_last_name" class="col-sm-3 control-label">Họ và tên</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control required" value="<?php echo @$user['last_name']; ?>" maxlength="50" name="last_name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Ngày cưới</label>
                                <div class="col-sm-9">
                                    <input type="text" style="padding: .375rem .75rem;" class="form-control datepicker" value="<?php echo @$user['wedding_date'] != null && @$user['wedding_date'] != '0000-00-00' ? date('d/m/Y',strtotime($user['wedding_date'])) : ''; ?>" name="wedding_date" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 control-label">Địa chỉ email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control required" value="<?php echo @$user['email']; ?>" id="email" placeholder="Địa chỉ email" required readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_sex" class="col-sm-3 control-label">Giới tính</label>
                                <div class="col-sm-9">
                                    <div class="select-wrapper">
                                        <select id="user_sex" name="gender" class="form-control">
                                            <option value="1" <?php echo @$user['gender'] == 1 ? 'selected' : ''; ?>>Nam</option>
                                            <option value="0" <?php echo @$user['gender'] != null && @$user['gender'] == 0 ? 'selected' : ''; ?>>Nữ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user_phone" class="col-sm-3 control-label">Số điện thoại</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo @$user['phone']; ?>" name="phone" >
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="content-box-cented">
                                    <div class="row">
                                        <div class="col-sm-12"><p style="margin-bottom: 10px;">Bạn chưa có tên miền? Bạn có thể sử dụng tên miền phụ của weddingguu.<br> Vui lòng gõ tên mà bạn muốn vào ô dưới đây <br>(Ví dụ bạn gõ abc, hệ thống sẽ cung cấp cho bạn tên miền: abc.weddingguu.com)</p></div>   
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
                                                        echo '<input type="text" class="form-control is_has_string" id="subdomain-name" value="'.$sub_domain.'" placeholder="Vui lòng nhập tên" aria-describedby="basic-addon2" disabled="" readonly>';
                                                    }
                                                    else{
                                                        echo '<input type="text" class="form-control" id="subdomain-name" name="subdomain" placeholder="Vui lòng nhập tên" aria-describedby="basic-addon2" disabled>';
                                                    }
                                                ?>
                                                <span class="input-group-addon" id="basic-addon2">.weddingguu.com</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p style="margin-bottom: 10px;">Bạn đã có tên miền hoặc bạn muốn có tên miền riêng (ví dụ http://abc.com)<br>
                                            Hãy liên hệ với đội ngũ của chúng tôi qua số điện thoại <a href="tel:0234-629-6688">0234-629-6688</a>, chúng tôi sẽ hỗ trợ để website của bạn có tên miền riêng</p>
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
                                                            echo '<input type="text" class="form-control input-domain is_has_string" id="domain-name" value="'.$domain.'" placeholder="Vui lòng nhập domain(vd: example.com)" disabled readonly>';
                                                        }
                                                        else{
                                                            echo '<input type="text" class="form-control input-domain" id="domain-name" name="domain" placeholder="Vui lòng nhập domain (vd: abc.com)" disabled="">';
                                                        }
                                                    ?>
                                                    <p class="text-right" style="margin-top: 10px;"><a href="<?php echo base_url('trang/hoi-dap'); ?>?id=collapse-8" target="_blank">Xem hướng dẫn</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                            <div class="form-group text-right row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
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
                <h4 class="modal-title" id="modal-label">Đổi ảnh đại diện</h4>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker({ format: 'dd/mm/yyyy' });
        //------------------
        //Crop Image
        //------------------
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

        function ValidURL(str) {
	        var re = new RegExp(/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$/); 
	        return str.match(re);
	    }

        $('form.form-profile').submit(function(){
            var type      = $("input.theme-type").is(":checked") ? 1 : 0;
            var domain    = $("#domain-name").val();
            console.log(type + ' : ' + domain);
            if(type == 1 && domain.trim() == ""){
                alert("Vui lòng nhập vào một url");
                return false;
            }
            if(type == 1 && !ValidURL(domain.trim())){
                alert("Vui lòng nhập vào một url(vd: example.com)");
                return false;
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