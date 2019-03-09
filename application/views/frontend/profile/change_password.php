<?php $this->load->view('frontend/profile/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/profile/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form class="form-horizontal" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">Change Password</div>
                    <div class="panel-body">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
                        <div class="form-group">
                            <label for="user_first_name" class="col-sm-3 control-label">Password <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control required"  name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_last_name" class="col-sm-3 control-label">Confirm Password <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control required"   name="confirm_password">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-md btn-secondary">Save</button>
            	
            	<div class="modal fade" id="comfirm-password-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static">
				    <div class="modal-dialog" role="document" style="max-width: 330px;">
				        <div class="modal-content">
				         	<div class="modal-header">
				               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				               <h4 class="modal-title" id="modal-label">Confirm Password to Continue</h4>
				            </div>
				            <div class="modal-body">
				            	<div class="alert alert-danger" style="display: none;"></div>
				               	<input type="password" class="form-control" name="password" id="comfirm-password-val" placeholder="Password" value="" autocomplete>
				            </div>
				            <div class="modal-footer text-right">
				                <input class="btn btn-secondary btn-submit" type="button" value="Confirm Password">
				            </div>
				        </div>
				    </div>
				</div>
            </form>
        </main>
    </div>
</div>