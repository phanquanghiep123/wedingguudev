<link rel="stylesheet" type="text/css" href="<?php echo skin_frontend('css/bootstrap-tagsinput.css'); ?>">  
<script src="<?php echo skin_frontend('js/bootstrap-tagsinput.js'); ?>"></script>
<div class="page-container" style="width: auto;padding: 0;margin-top: 0;">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="irefer-wrap">
                <div class="irefer-banner text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="type-account-wrap">
                                    <div class="avatar-bg" style="background-image:url('<?php echo @$user['avatar']; ?>');z-index:1;"></div>
                                </div>
                                <h3 class="text-white">Chia sẻ cho bạn bè về trang web</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10">
                            <div class="share-box">
                                <div style="height:20px;"></div>
                                <div id="refer">
                                    <div class="alert alert-success" style="display:none;">
                                        Send email successfully.
                                    </div>
                                    <div class="alert alert-danger" style="display:none;">
                                        Send email Error.
                                    </div>
                                    <div class="input-group">
                                         <input type="text" class="form-control tagsinput" name='text' data-role="tagsinput" placeholder="Nhập địa chỉ email">
                                         <span class="input-group-btn">
                                            <button class="btn btn-primary btn-send-invite" type='submit'>Gửi chia sẻ</button>
                                         </span>
                                    </div>
                                </div>
                                <div class="contact-importers" style="line-height: 25px;">
                                    Nhập email muốn chia sẻ từ: &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url('/invite/contact_google/'); ?>"><img width="20" src="<?php echo skin_frontend('/images/gmail.png'); ?>"> Gmail</a>  &nbsp;&nbsp;|&nbsp;&nbsp;
                                    <a href="<?php echo base_url('/invite/contact_yahoo/'); ?>" ><img width="20" src="<?php echo skin_frontend('/images/yahoo.png'); ?>"> Yahoo! Mail</a>  &nbsp;&nbsp;|&nbsp;&nbsp;
                                    <a href="<?php echo base_url('/invite/contact_outlook/'); ?>"><img width="20" src="<?php echo skin_frontend('/images/outlook.png'); ?>"> Outlook Mail </a>
                                </div>
                                <div class="or-separator">
                                    <span class="h6 or-separator--text">
                                        <span>Hoặc</span>
                                    </span>
                                    <hr>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <p style="line-height: 35px;">Chia sẻ liên kết:</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="input-copy" value="<?php echo base_url('account/register/'.@$record['promo_code']); ?>" readonly="">
                                            <span class="input-group-btn">
                                               <button class="btn btn-primary btn-copy" style="min-height:none; background-color: #428bca;border-color: #357ebd;">Copy</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary social-share-btn btn-facebook-messenger send-message-facebook">
                                           <i class="fa fa-weixin" aria-hidden="true"></i> Messenger
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary social-share-btn share-facebook btn-facebook " data-title="Invite user" data-url="<?php echo base_url('account/register/'.@$record['promo_code']); ?>" data-image="http://couchstay.kindusa.org/uploads/ckfinder/1/images/holder-4.jpg" data-appID="<?php echo @$facebook_app_id; ?>" data-redirct="<?php echo base_url(); ?>/closewindown" data-summary="It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)." href="#">
                                           <i class="fa fa-facebook" aria-hidden="true"></i> Facebook
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="results">
                                  <div class="row">
                                    <div class="col-md-5"><h4>Danh sách người dùng đăng ký</h4></div>
                                    <div class="col-md-7 text-right">
                                      <span>Tổng thành viên: <?php echo $dataPlus["numberMember"]?></span>,
                                      <span>Tổng phí hoa hồng: <?php echo $dataPlus["sum_money"]?>VND</span>
                                    </div>
                                  </div>
                                    

                                    <div style="height: 5px;"></div>
                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                                <tr class="headings">
                                                  <th>#</th>
                                                  <th>Họ và tên</th>
                                                  <th>Email</th>
                                                  <th>Số ngày cộng thêm</th>
                                                  <th>Phí hoa hồng</th>
                                                  <th>Lần thanh toán</th>
                                                  <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($results) && $results != null): ?>
                                                    <?php foreach ($results as $key => $item): ?>
                                                        <tr>
                                                            <td><?php echo ($key+1); ?></td>
                                                            <td><?php echo $item['last_name']; ?></td>
                                                            <td><?php echo $item['email']; ?></td>
                                                            <td><?php echo $item['plus_day']; ?></td>
                                                            <td><?php echo ($item['sum_money'] ? $item['sum_money'] : 0) ." VND"; ?></td>
                                                            <td><?php echo ($item['numberpay'] ? $item['numberpay'] : 0); ?></td>
                                                            <td><a href="<?php echo base_url("invite/detail/".$item["id"])?>">Chi tiết</a></td>
                                                        </tr>
                                                    <?php endforeach; ?> 
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <?php echo $this->pagination->create_links();?>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php if(isset($result) && count($result) > 0): ?>
    <!--Modal-->
    <div id="invite-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="max-width:100%;width:650px;">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-body" style="padding:0;">
                  <div class="panel-header">
                    <a href="#" class="panel-close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></a>
                    Chọn bạn bè muốn gửi
                </div>
                <div class="panel-header contact-search-wrapper">
                    <i class="fa fa-search contact-search-icon" aria-hidden="true"></i>
                    <input class="contact-search" id="contact-search" type="text" placeholder="Tìm kiếm...">
                </div>
                <div class="alert alert-success" style="display:none;">
                    Gửi thành công.
                </div>
                <div class="alert alert-danger" style="display:none;">
                    Lỗi không thể gửi được.
                </div>
                <div class="panel-body-scroll panel-body-fixed panel-body">
                   <div class="panel-body panel-body-list">
                      <ul class="row list-layout">
                           <li id="no-contact-found-message" class="contact-row hide">
                              Sorry, we cannot find contact from this account. Please use a different account.
                           </li>
                           <?php foreach ($result as $key => $item): ?>
                             <li class="col-sm-12">
                                  <div class="row">
                                      <div class="col-sm-6">
                                          <label class="checkbox text-left">
                                             <input class="contact-checkbox" type="checkbox" value="<?php echo @$item['email'] ?>" id="email-invite-<?php echo $key; ?>">
                                             <label for="email-invite-<?php echo $key; ?>"><?php echo @$item['name'] != null ? @$item['name'] : @$item['email'];  ?></label>
                                          </label>
                                      </div>
                                      <div class="contact-email contact-detail text-right col-sm-6">
                                        <label><?php echo @$item['email'] ?></label>
                                      </div>
                                  </div>
                             </li>
                         <?php endforeach; ?>
                         <li id="empty-message" class="contact-row hide">
                              Không tồn tại địa chỉ email.
                         </li>
                      </ul>
                   </div>
                </div>
              </div>
              <div class="modal-footer">
                  <div class="row">
                 <div class="col-sm-5 col-md-3">
                    <div style="height:10px;"></div>
                    <label class="checkbox text-left">
                        <input class="check-all-checkbox" id="invite-all" type="checkbox">
                        <label for="invite-all">Tất cả</label>
                    </label>
                 </div>
                 <div class="col-sm-7 col-md-9 text-right">
                    <div class="modal-status-section modal-sent hide icon-lima">
                       <h5>Chia sẻ.</h5>
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                    <button class="btn btn-primary send-invites" disabled style="border-color: #ff5a5f;background-color: #ff5a5f;">Chia sẻ đến 0 bạn bè</button>
                 </div>
              </div>
              </div>
          </div>
        </div>
    </div>
    <script type="text/javascript">
          $(document).ready(function(){
              $("#invite-modal").modal('show');
          });
    </script>
<?php endif; ?>
<script type="text/javascript">
    $(document).ready(function(){        
        $(".tagsinput").on('beforeItemAdd', function(event) {
            var email = event.item;
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            if(email == '' || email == null || !pattern.test(email) ){
               alert('Vui lòng nhập đúng định dạng email.');
               event.cancel = true;
            }     
        });

        $(document).on('keydown',function(e){
            var tag = e.target.tagName.toLowerCase();
            var id  = e.target.id;
            //console.log(e.keyCode);
            if (id == 'contact-search') {
                var searchString = $('#contact-search').val();
                if(searchString != null && searchString != ''){
                    $('.panel-body-list li').hide();
                    var results = $('.panel-body-list li label:contains("' + searchString + '")');
                    results.each(function(i){
                        $(this).parents('li').show();
                    });
                }
                else{
                    $('.panel-body-list li').show();
                }
            } 
        });

        $("#refer button[type='submit']").click(function(){
            var email = $(".tagsinput").val()
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            if(email == '' || email == null){
                $("#refer .bootstrap-tagsinput").addClass('border-error');
                return false;
            }
            else{
                $("#refer .bootstrap-tagsinput").removeClass('border-error');
            }
            $('.custom-loading').show();
            $("#refer .alert").hide();
            $.ajax({
                url: "<?php echo base_url('/invite/send_invite'); ?>",
                type: "post",
                dataType: 'json',
                data: { 'email' : email},
                success: function (data) {
                    //console.log(data);
                    if(data['status'] == 'success'){
                        $("#refer .alert-success").show();
                        $("#refer input[name='email']").val('');
                        $("#refer .bootstrap-tagsinput .tag").remove();
                    }
                    else if(data['status'] == 'fail'){
                        $("#refer .alert-danger").html(data['message']).show();
                    }
                    else{
                        $("#refer .alert-danger").show();
                    }
                },
                error: function(data){
                    console.log(data['responseText']);
                    $("#refer .alert-danger").show();
                },
                complete: function(){
                    $('.custom-loading').hide();
                }
            });
            return false;
        });
        
        $("#invite-modal .send-invites").click(function(){
            var list_email = '';
            $("#invite-modal .panel-body-list input[type='checkbox']:checked").each(function(i){
                if($(this).is(':checked')){
                    list_email += $(this).val() ;
                    if(i < $("#invite-modal .panel-body-list input[type='checkbox']:checked").length - 1){
                        list_email += ',';
                    }
                }
            });
            if(list_email != ''){
                $('.custom-loading').show();
                $("#invite-modal .alert").hide();
                $.ajax({
                    url: "<?php echo base_url('/invite/send_invite'); ?>",
                    type: "post",
                    dataType: 'json',
                    data: { 'email' : list_email },
                    success: function (data) {
                        if(data['status'] == 'success'){
                            $("#invite-modal .alert-success").show();
                            $("#invite-modal .panel-body-list input[type='checkbox']").each(function(){
                                $(this).prop('checked',false);
                            });
                            $(".send-invites").text('Chia sẻ đến 0 bạn bè').attr('disabled','disabled');
                        }
                        else if(data['status'] == 'fail'){
                            $("#invite-modal .alert-danger").html(data['message']).show();
                        }
                        else{
                            $("#invite-modal .alert-danger").show();
                        }
                    },
                    error: function(data){
                        console.log(data['responseText']);
                        $("#invite-modal .alert-danger").show();
                    },
                    complete: function(){
                        $('.custom-loading').hide();
                    }
                });
            }
            else{
               alert('Please choose send mail.');
            }
            return false;
        });
        
        $(".send-message-facebook").click(function(){
            var winWidth = 650, winHeight = 350;
            var winTop = (screen.height / 2) - (winHeight / 2);
            var winLeft = (screen.width / 2) - (winWidth / 2);
            window.open('http://www.facebook.com/dialog/send?app_id=<?php echo @$facebook_app_id; ?>&link=<?php echo base_url('account/register/'.@$record['promo_code']); ?>&redirect_uri=<?php echo base_url(); ?>/close-windown', 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
            return false;
        });

        $(".check-all-checkbox").click(function(){
            if($(this).is(':checked')){
                var index = 0;
                $("#invite-modal .panel-body-list input[type='checkbox']").each(function(){
                    index++;
                    $(this).prop('checked',true);
                });
                $(".send-invites").text('Send '+index+' Invitations').removeAttr('disabled');
            }
            else{
                $("#invite-modal .panel-body-list input[type='checkbox']").each(function(){
                    $(this).prop('checked',false);
                });
                $(".send-invites").text('Chia sẻ đến 0 bạn bè').attr('disabled','disabled');
            }
        });

        $("#invite-modal .panel-body-list input[type='checkbox']").click(function(){
            var index = 0;
            $("#invite-modal .panel-body-list input[type='checkbox']").each(function(){
                if($(this).is(':checked')){
                   index++;
                }
            });
            $(".send-invites").text('Chia sẻ đến '+index+' bạn bè').removeAttr('disabled');
            if(index == 0){
                $(".send-invites").attr('disabled','disabled');
            }
        });

        $(document).on("click", ".share-facebook", function(){
            var title = '',url = '',image = '',summary = '';
            var winWidth = 520, winHeight = 350;
            title = $(this).data("title");
            url = $(this).data("url");
            image = $(this).data("image");
            summary = $(this).data("summary");
            var app_id = $(this).attr('data-appID');
            var redirct = $(this).attr('data-redirct');
            var winTop = (screen.height / 2) - (winHeight / 2);
                var winLeft = (screen.width / 2) - (winWidth / 2);
                window.open('http://www.facebook.com/dialog/feed?app_id='+app_id+'&redirect_uri='+redirct+'&description=' + summary + '&name=' + title + '&link=' + url + '&picture='+image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
            return false;
        });

        $('.btn-copy').click(function(){
            if(copyToClipboard(document.getElementById("input-copy"))){
                alert('Copy thành công.');
            }
            return false;
        });

        function copyToClipboard(elem) {
            var targetId = "_hiddenCopyText_";
            var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
            var origSelectionStart, origSelectionEnd;
            if (isInput) {
                // can just use the original source element for the selection and copy
                target = elem;
                origSelectionStart = elem.selectionStart;
                origSelectionEnd = elem.selectionEnd;
            } else {
                // must use a temporary form element for the selection and copy
                target = document.getElementById(targetId);
                if (!target) {
                    var target = document.createElement("textarea");
                    target.style.position = "absolute";
                    target.style.left = "-9999px";
                    target.style.top = "0";
                    target.id = targetId;
                    document.body.appendChild(target);
                }
                target.textContent = elem.textContent;
            }
            // select the content
            var currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);

            // copy the selection
            var succeed;
            try {
                  succeed = document.execCommand("copy");
            } catch(e) {
                succeed = false;
            }
            // restore original focus
            if (currentFocus && typeof currentFocus.focus === "function") {
                currentFocus.focus();
            }

            if (isInput) {
                // restore prior selection
                elem.setSelectionRange(origSelectionStart, origSelectionEnd);
            } else {
                // clear temporary content
                target.textContent = "";
            }
            return succeed;
        }
    });
</script>
<style type="text/css">
    table.jambo_table thead{background: rgba(52, 73, 94, .94);color: #ECF0F1;}
    .bootstrap-tagsinput .tag{background-color: #fe5e57;padding: 3px 5px;}
</style>