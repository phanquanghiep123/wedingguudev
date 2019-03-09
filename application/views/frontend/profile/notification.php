<?php $this->load->view('frontend/profile/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/profile/sidebar_setting'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form class="form-horizontal" method="post" action="">
                <?php 
                    if($this->session->flashdata('message')){
                        echo  $this->session->flashdata('message');
                    }
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Push Notification Settings</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <p>Receive Push Notification to your iPhone, iPad or Android device</p>
                            </div>
                            <div class="col-sm-7">
                                <p>Download the CouchStay App to receive push notification instead of plain text messages. Once you enbable push notification on your mobile device, the settings will appear here.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Text Message Settings</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <p>Receive mobile updates by regular SMS text message.</p>
                                <p><strong>Note:</strong> For more information, text HELP to 247262. To cancel mobile notification, reply STOP to 247262. Message and Data rates may apply.</p>
                            </div>
                            <div class="col-sm-7">
                                <div class="row" style="margin:0;">
                                    <div class="col-sm-6">
                                        Receive SMS notification to:
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="phone" class="form-control" value="<?php echo @$notification['Phone']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox checkbox-primary">
                                        <input id="messages" <?php echo @$notification['is_message_text'] == 1 ? 'checked' : ''; ?> class="styled" name="messages" value="1" type="checkbox">
                                        <label for="messages">
                                            <b>Messages</b><br>
                                            From hosts and guests
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox checkbox-primary">
                                        <input id="reservation" <?php echo @$notification['is_reservation_updates_text'] == 1 ? 'checked' : ''; ?> class="styled" name="reservation" value="1" type="checkbox">
                                        <label for="reservation">
                                            <b>Reservation Updates</b><br>
                                            Requests, confirmations, changes and more
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox checkbox-primary">
                                        <input id="other" <?php echo @$notification['is_other_text'] == 1 ? 'checked' : ''; ?> class="styled" name="other" value="1" type="checkbox">
                                        <label for="other">
                                            <b>Other</b><br>
                                            Feature updates and more
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Email Settings</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <p><strong>I want to receive:</strong></p>
                                <p>You can disable these at any time.</p>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class="checkbox checkbox-primary">
                                        <input id="promotional" <?php echo @$notification['is_promotional_email'] == 1 ? 'checked' : ''; ?> class="styled" name="promotional" value="1" type="checkbox">
                                        <label for="promotional">
                                            <b>General and promotional emails</b><br>
                                            General promotions, updates, news about CouchStay or general promotions for partner campaigns and services, user surveys, inspiration, and love from CouchStay
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox checkbox-primary">
                                        <input id="reservation_review" <?php echo @$notification['is_reservation_email'] == 1 ? 'checked' : ''; ?> class="styled" name="reservation_review" value="1" type="checkbox">
                                        <label for="reservation_review">
                                            <b>Reservation and review reminders</b><br>
                                            Notification about upcoming trips and review periods.
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox checkbox-primary">
                                        <input id="account_activity" <?php echo @$notification['is_account_activity_email'] == 1 ? 'checked' : ''; ?> class="styled" name="account_activity" value="1" type="checkbox">
                                        <label for="account_activity">
                                            <b>Account activity</b><br>
                                            Payment notices, reservation confirmations, review activity, and security alerts. These are required to services your account. You may not opt out of these notices.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Phone Preferences</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <p><strong>I want to receive:</strong></p>
                                <p>You can change this at any time.</p>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class="checkbox checkbox-primary">
                                        <input id="community" <?php echo @$notification['is_calls_phone'] == 1 ? 'checked' : ''; ?> class="styled" name="community" value="1" type="checkbox">
                                        <label for="community">
                                            <b>Calls about my account, listings, reservations, or the CouchStay community</b><br>
                                            If you opt out, we may still call you about your account if it's urgent or if previous emails didn't reach you.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-md btn-secondary">Save</button>
                </div>

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
<script type="text/javascript">
    $(document).ready(function(){
        $('a.add-more').click(function(){
            $(this).parent().find('.group').toggleClass('hidden');
            return false;
        });
    });
</script>