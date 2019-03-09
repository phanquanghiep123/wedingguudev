<section class="section-firts" id="main-page">
    <div class="container">
        <div class="section-body">
            <div class="row">  
                <?php 
                    $colum1 = "";
                    $i = 0;
                    foreach ($mytheme as $key => $value):
                        $i++;
                        $date = date_create($value["created_at"]);
                        $created = date_format($date,"Y / m / d");
                        $thumb = $value["hero_image"] ;
                        $name = $value["name"];
                        $active =  $value["is_active"]== 1 ? "disabled" : "";
                        $activecl =  $value["is_active"]== 1 ? "active" : "";
                    ?>
                    <div class="col-md-4 item-card <?php echo ($value["is_active"]) ? 'is_active' : '';?>">
                        <div class="card-image relative <?php echo ($value["is_active"]) ? 'is_active' : '';?>" data-id="<?php echo $value["id"]; ?>" style="margin-bottom:20px;">
                            <div class="relative">
                            	<div style="background-image:url('<?php echo $value["hero_image"]; ?>');width:100%;height:200px;background-size: cover;background-position: center;background-repeat: no-repeat;"></div>
                            </div>
                            <div class="description-bottom">
                                <div class="description" style="padding: 10px 15px 0;border-bottom: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="text-center">
                                                <a href="<?php echo base_url("appthemes/view/".$value["slug"]); ?>" data-toggle="tooltip" data-html="true" title="<?php echo htmlentities($value["description"]); ?>">
                                                    <?php echo $value["name"]; ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-card">
                                    <div class="box-top text-center" id="action-theme" style="padding: 10px 0;">
                                        <a href="javascript:;" style="margin: 5px 0;" data-id="<?php echo $value["id"]; ?>" class="btn btn-primary" id="open-modal-domain">Xuất bản</a>
                                        <?php if($value["is_active"] != 1): ?>
                                            <a href="javascript:;" style="margin: 5px 0;" id="delete-theme" class="btn-delete btn btn-primary">Xóa</a>
                                        <?php endif;?>
                                        <a href="<?php echo base_url("appthemes/edit/".$value["slug"]); ?>" style="margin: 5px 0;" class="btn btn-primary btn-edit">Chỉnh sửa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>      
            </div>
        </div>
    </div>
</section>
<div class="modal" id="modal-domain" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog export-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Xuất tên miền</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12"><div class="text-center" id="message-box"></div></div>
                </div>
                <?php /*
                <div class="form-group">
                    <div class="content-box-cented">
                    	<div class="row">
	                        <div class="col-sm-12"><p class="mb-0">Bạn chưa có tên miền? Bạn có thể sử dụng tên miền phụ của Wedding.<br> Vui lòng gõ tên mà bạn muốn vào ô dưới đây <br>(Ví dụ bạn gõ abc, hệ thống sẽ cung cấp cho bạn tên miền: abc.weddingguu.com)</p></div>   
	                    </div>
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="checkbox">
                                    <input id="theme-type1" type="checkbox" name="domain_sub_allow" value="2" checked="" readonly disabled>
                                    <label for="theme-type1"></label>
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <div class="input-group input-domain">
                                    <?php
                                    if(@$sub_domain){
                                        $sub_domain = str_replace(".weddingguu.com","", $sub_domain);
                                        echo '<input type="text" class="form-control is_has_string" id="subdomain-name" value="'.$sub_domain.'" placeholder="Vui lòng nhập tên" aria-describedby="basic-addon2" disabled="" readonly>';
                                    }
                                    else
                                    {
                                        echo '<input type="text" class="form-control" id="subdomain-name" placeholder="Vui lòng nhập tên" aria-describedby="basic-addon2">';
                                    }
                                    ?>
                                    <span class="input-group-addon" id="basic-addon2">.weddingguu.com</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
	                        <div class="col-sm-12">
	                            <p class="mb-0">Bạn đã có tên miền hoặc bạn muốn có tên miền riêng(ví dụ http://abc.com)<br>
	                            Hãy liên hệ với đội ngũ của chúng tôi qua số điện thoại <a href="tel:0234-629-6688">0234-629-6688</a>, chúng tôi sẽ hổ trợ để website của bạn có tên miền riêng</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-sm-12">
	                            <div class="row">
	                                <div class="col-sm-1">
	                                    <div class="checkbox">
	                                        <input class="theme-type" id="theme-type0" type="checkbox" name="type" value="1" >
	                                        <label for="theme-type0"></label>
	                                    </div>
	                                </div>
	                                <div class="col-sm-11">
	                                    <?php
	                                        if(@$domain){
	                                            echo '<input type="text" class="form-control input-domain is_has_string" id="domain-name" value="'.$domain.'" placeholder="Vui lòng nhập domain(vd:http://example.com)" disabled readonly>';
	                                        }
	                                        else
	                                        {
	                                            echo '<input type="text" class="form-control input-domain" id="domain-name" placeholder="Vui lòng nhập domain(vd:http://example.com)" disabled="">';
	                                        }
	                                    ?>
	                                    
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-sm-12">
	                            <p><a href="<?php echo base_url('trang/hoi-dap'); ?>?id=collapse-10" target="_blank">Xem hướng dẫn</a></p>
	                        </div>
	                    </div>
                    </div>
                </div> */ ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="theme-slug" value="">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .input-domain{margin: 18px 0;}
    .tooltip.fade{opacity: 1;}
    .content-show-page{margin-top: 42px;}
    .item-card{padding-left: 5px;padding-right: 5px;}
    .item-card .card-image {background-color: #fff;margin-bottom: 20px;border: 1px solid #ccc;}
    .item-card .card-image.is_active{border: 2px solid rgb(254,94,87);}
    .item-card img.src_img {width: 100%; height: auto; border-bottom: 1px solid #f1f1f1;}
    .card-image .top-card {position: absolute;top: 0;left: 0;padding: 5px;display: none;right: 0;z-index: 10;background-color: rgba(0, 0, 0, 0.29);}
    .card-image:hover .top-card {display: block;}
    .left-info-member{float: left;width: 65px;}
    .card-image .top-card .avatar {width: 50px;}
    .card-image .top-card p{margin-bottom: 0; font-size: 13px; color: #fff;}
    .card-image .top-card p a{margin-bottom: 0; font-size: 13px; color: #fff;}
    .card-image .bottom-card .box-top {padding: 5px 0px;border-bottom: 1px solid #f1f1f1;background-color: #fff;}
    .card-image .bottom-card .box-top p {color: #37a7a7;font-size: 11px;margin-bottom: 0;}
    .card-image .bottom-card .box-top p span{color: #37a7a7;font-size: 11px; margin-bottom: 0;}
    .card-image .bottom-card .box-bottom {padding: 5px 0;background-color: #fff;}
    .card-image .description{padding: 5px 0;border-bottom: 2px solid #f1f1f1;}
    .section-body>div>.col-md-4 {margin-bottom:10px;}
    .card-image .bottom-card .box-bottom i{color: rgba(127, 127, 127, 0.63);font-size: 24px;cursor: pointer;}
    .card-image .bottom-card .box-bottom i.active{color: #37a7a7;    }
    .card-image .bottom-card .box-bottom i:hover{color: #37a7a7;}
    .card-image:hover .top-card {display: block;}
    .relative{position: relative;}
    .card-image .description p {margin-bottom: 0 ;font-size:11px; color: rgba(127, 127, 127, 0.63);}
    #masthead,#colophon{display: block !important;}
    #modal-domain .modal-header {background-color: #fc7f73!important;color: #fff!important;}
    #modal-domain .modal-content {border-radius: 0;border: none!important;}
    #modal-domain .modal-title {margin: 0;line-height: 1;font-size: 25px;margin-bottom: 0;padding: 0;}
    .tab-content{padding: 30px 10px;border: 1px solid #ddd;border-top: none;}
    .export-dialog {
        max-width: 560px;
        margin: 30px auto;
    }
    button{
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $("#action-theme #active-theme").click(function(){
            var _this = $(this);
            var r = confirm("Bạn muốn theme này sẽ là tường của bạn!");
            if (r == true) {
                var id = $(this).parents(".card-image").attr("data-id");
                if($.isNumeric(id)){
                    $.ajax({
                        url : "<?php echo base_url("themes/active")?>",
                        type:"post",
                        dataType:"json",
                        data:{id:id},
                        success:function(res){
                            if(res["status"] == "success"){
                                $("#action-theme button").removeClass("active").removeAttr("disabled");
                                $.each(_this.parents("#action-theme").find("button"),function(){
                                    $(this).addClass("active");
                                    $(this).attr("disabled",true);
                                });
                                location.reload();
                            }
                        }
                    })
                } 
            } 
            return false;
        });
        $("#action-theme #delete-theme").click(function(){
            var _this = $(this);
            var r = confirm("Bạn muốn xóa theme này!");
            if (r == true) {
                var id = $(this).parents(".card-image").attr("data-id");
                if($.isNumeric(id)){
                    $.ajax({
                        url : "<?php echo base_url("themes/delete")?>",
                        type:"post",
                        dataType:"json",
                        data:{id:id},
                        success:function(res){
                            if(res["status"] == "success"){
                                _this.parents(".card-image").parent().remove();
                            }
                        }
                    })
                } 
            } 
            return false;
        });
        $("#action-theme #open-modal-domain").click(function(){
            $("#modal-domain #message-box").html("");
            var _this = $(this);
            var id = $(this).attr("data-id");
            $.ajax({
                type:"post",
                dataType : "json",
                url : "<?php echo base_url("themes/export")?>",
                data : {
                    "id" : id
                },
                success : function(r){
                    if(r.status != "success"){
                        $("#modal-domain #message-box").html("Có lỗi xãy ra vui lòng thử lại!");
                        return false;
                    }else{
                        $("#domain-name").addClass("is_has_string");
                        $("#domain-name").prop('disabled', true);
                    }
                    var html = "";
                    $.each(r.message,function($key,$value){
                        html += '<p>'+$value+'</p>';
                    });
                    $("#modal-domain #message-box").html(html);
                    $("#modal-domain").modal();
                    $("#main-page .item-card.is_active").removeClass("is_active");
                    $("#main-page .card-image.is_active").removeClass("is_active");
                    _this.closest(".card-image").addClass("is_active");
                    _this.closest(".item-card").addClass("is_active");
                },error:function(e){
                    console.log(e);
                }
            });
        })
    });
</script>