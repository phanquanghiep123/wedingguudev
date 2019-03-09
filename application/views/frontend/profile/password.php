<div class="page-content">
    <div class="container">
        <div class="row">
            <main class="site-main col-sm-10 col-sm-push-1 col-sm-pull-1 col-md-8 col-md-push-2 col-md-pull-2">
                <form class="form-horizontal" method="post" action="">
                    <input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
                    <div class="panel panel-default">
                        <div class="panel-heading">Thay đổi mật khẩu</div>
                        <div class="panel-body">
                            <?php 
                                if($this->session->flashdata('message')){
                                    echo  $this->session->flashdata('message');
                                }
                            ?>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Mật khẩu hiện tại</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control required" value="" maxlength="50" name="password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Mật khẩu mới</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control required" value="" maxlength="50" name="new_password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Xác nhận lại mật khẩu</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control required" value="" maxlength="50" name="configure_new_password" required>
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