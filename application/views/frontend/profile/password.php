<div class="page-content">
    <div class="container">
        <div class="row">
            <main class="site-main col-sm-10 col-sm-push-1 col-sm-pull-1 col-md-8 col-md-push-2 col-md-pull-2">
                <form class="form-horizontal form form-profile" method="post" action="<?php echo base_url("profile/change_password");?>">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="message"></div>
                        </div>
                    </div>
                    <input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
                    <div class="panel panel-default">
                        <div class="panel-heading">[{]UPDATE_PASSWORD[}]</div>
                        <div class="panel-body">
                            <?php 
                                if($this->session->flashdata('message')){
                                    echo  $this->session->flashdata('message');
                                }
                            ?>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">[{]UPDATE_OLD_PASSWORD[}]</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control required" name="pwd" validate="true"data-validate="required|min:6|max:50">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">[{]UPDATE_NEW_PASSWORD[}]</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control required" value="" maxlength="50" name="new_password" validate="true"data-validate="required|min:6|max:50|match:configure_new_password:[{]UPDATE_CF_PASSWORD[}]">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">[{]UPDATE_CF_PASSWORD[}]</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control required" value="" maxlength="50" name="configure_new_password" validate="true"data-validate="required|min:6|max:50">
                                </div>
                            </div>
                            <div class="form-group text-right row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">[{]UPDATE_SAVE_PASSWORD[}]</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>
</div>
<script src="<?php echo skin_frontend('js/form-validation.js'); ?>"></script>
<script src="<?php echo skin_frontend('js/jquery.form.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var form = $(".form.form-profile");
        var validate = form.validateform({
            message : {
                "required" : _LANG.VALIDATE_REQUIRED, 
                "match" : _LANG.VALIDATE_MATCH,
                "min" : _LANG.VALIDATE_MIN,
                "max" : _LANG.VALIDATE_MAX,
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
        });
    })
</script>