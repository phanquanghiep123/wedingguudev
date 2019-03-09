<!--Profile Photo-->
<div class="modal fade" id="ModalLastThing" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document"  style="max-width:400px;">
        <div class="modal-content">
            <div class="modal-body" style="padding: 20px;">
            	<p class="text-center" style="color: #ccc;">
            		<i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>
                    <i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>
            		<i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>
                    <i class="fa fa-circle-o" aria-hidden="true"></i>
            	</p>
                <div style="height:20px;"></div>
                <p class="text-center">
                    <img class="img-avatar" src="<?php echo @$user['avatar']; ?>" width="120" height="120" style="border-radius:50%;">
                </p>
            	<h3 style="margin-top: 10px;" class="text-center">One last thing</h3>
            	<p class="text-center">You can sync your contacts with CouchStay to make sharing you itinerary or referring friends easier. This is just for you we won't contact anyone without your permission.</p>
                <p class="text-center">You can remove your contacts at any time from your <a href="<?php echo base_url('/profile/'); ?>">account setting</a>.</p>
                <div class="contact-importers text-center" style="line-height: 25px;background-color: #ccc;padding: 5px 10px;">
                   <a href="<?php echo base_url('/invite/contact_google/'); ?>"><img width="20" src="<?php echo skin_url(); ?>/frontend/images/gmail.png"> Gmail</a>  &nbsp;&nbsp;|&nbsp;&nbsp;
                   <a href="<?php echo base_url('/invite/contact_yahoo/'); ?>"><img width="20" src="<?php echo skin_url(); ?>/frontend/images/yahoo.png"> Yahoo! Mail</a>  &nbsp;&nbsp;|&nbsp;&nbsp;
                   <a href="<?php echo base_url('/invite/contact_outlook/'); ?>"><img width="20" src="<?php echo skin_url(); ?>/frontend/images/outlook.png"> Outlook Mail </a>
                </div>
                <div style="height:20px;"></div>
                <p class="text-center">
                    <a href="#"  class="btn-do-this-later">I'll do this later</a>
                </p>
        	</div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalAllSet" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document"  style="max-width:400px;">
        <div class="modal-content">
            <div class="modal-body" style="padding: 20px;">
                <p class="text-center" style="color: #ccc;">
                    <i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>
                    <i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>
                    <i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>
                    <i class="fa fa-circle-o" aria-hidden="true"></i>
                </p>
                <div style="height:100px;"></div>
                <p class="text-center">
                    <i class="fa fa-check-circle" aria-hidden="true" style="color:green;font-size:60px;"></i>
                </p>
                <h3 style="margin-top: 10px;" class="text-center">You're all set!</h3>
                <p class="text-center">You can now travel the world and host your own home on CouchStay.</p>
                <div style="height:20px;"></div>
                <p class="text-center">
                    <a href="<?php echo base_url('/profile/'); ?>"  style="display: block;" class="btn btn-secondary">Start Exploring</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#ModalLastThing").modal('show');
        $("#ModalLastThing .btn-do-this-later").click(function(){
            $("#ModalLastThing").modal('toggle');
            setTimeout(function(){
                $("#ModalAllSet").modal('show');
            },500);
            return false;
        });
    }); 
</script>