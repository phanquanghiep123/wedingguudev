<div class="x_title">
    <form action="" method="get">
        <div class="row">
            <div class="col-sm-4">
                <h2>
                    Danh sách theme người dùng 
                </h2>
            </div>
            <input type="hidden" name="ci_csrf_token" value="">
            <div class="col-sm-3">
                <div class="form-group">
                    <input type="text" name="keyword" placeholder="Từ khóa" class="form-control" maxlength="200" value="">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <select class="form-control" name="status">
				<option value="">Trạng thái</option>
				<option value="1">Hoạt động</option>
				<option value="0">Ngưng hoạt động</option>
			</select>
                </div>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
    </form>
</div>
<div class="x_content">
	<table class="table table-striped jambo_table bulk_action">
		<thead>
			<tr class="headings">
				<th>#</th>
				<th>Tên</th>
				<th>Trạng thái</th>
				<th>Trạng xóa</th>
				<th>Ngày tạo</th>
				<th>Hành động</th>
			</tr>
		</thead>
		<tbody>
			<?php if(@$tables != null){
				$i = 1;
				foreach ($tables as $key => $value) {
					$active = ($value["is_show_home"] == 1) ? "active" : "";
					echo '<tr>';
					echo '<td>'. ($i++) .'</td>';
					echo '<td>'. $value["name"] .'</td>';
					echo '<td>'. ($value["status"] == 1 ? "hiện": " ẩn") .'</td>';
					echo '<td>'. ($value["is_delete"] == 1 ? "có": " không") .'</td>';
					echo '<td>'. $value["created_at"] .'</td>';
					echo '<td>
						<a href="'.backend_url("themes/themes/edit/".$value["id"]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | 
						<a href="'.backend_url($_cname."/delete/".$value["id"]).'" id="action-delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a> | 
						<a id="showhome" data-is="'.$value["is_show_home"].'"  href="'.backend_url("member_themes/showhome/".$value["id"]).'"><i class="fa fa-heart '.$active.'" aria-hidden="true"></i></a> | 
						<a  href="'.base_url("appthemes/view/".$value["slug"]).'"><i class="fa fa-eye" aria-hidden="true"></i>
					</td>';
					echo '</tr>';
				}
			}?>
		</tbody>
	</table>
	<?php echo $this->pagination->create_links(); ?>
</div>
<div id="bx-iframe">
	<form method="post" action="" id="form-file-theme" enctype="multipart/form-data">
		<input class="none" style="display: none;" type="file" id="file-theme" name="theme"/>
	</form>
</div>
<style type="text/css">
	.active{
		color: red !important;
	}
</style>
<script type="text/javascript">
	$("#file-theme").change(function(){
		//alert("Đang nhập thêm vui lòng chờ tải xuống");
		var from = $("#form-file-theme")[0];
		var formData = new FormData(from);
		$.ajax({
			url : "<?php echo base_url("backend/theme/import")?>",
			type : "post",
			dataType : "json",
			processData: false,
            contentType: false,
			data : formData,
			success : function(data){
				alert("Nhập thành công");
			},error:function(e){
	          alert("Error ! Please try again your action");
	        }
		})
	})
	$("body #action-delete").click(function(){
		var url = $(this).attr("href");
		var c = confirm("Are you want delete it!");
		if(c){
			$.ajax({
				url : url,
				type : "post",
				data :{ id : 0},
				success : function(r){
					if(r.status == "success"){
						window.location.reload();
					}else{
						alert("Error ! Please try again your action");
					}
				},error:function(e){
		          alert("Error ! Please try again your action");
		        }
			})
		}	
		return false;
	});
	$("body #action-export").click(function(){
		var id  = $(this).attr("data-id");
		//alert("Đang xuất thêm vui lòng chờ tải xuống");
		$.ajax({
			type:"post",
			dataType:"json",
			url : "<?php echo base_url('backend/theme/export')?>",
			data : {
				id : id,
			},
			success : function(data){
				var link = document.createElement('a');
			    link.href = data.url;
			    link.setAttribute('download', data.name);
			    document.getElementsByTagName('body')[0].appendChild(link);
			    if (document.createEvent) {
			    var event = document.createEvent('MouseEvents');
			    event.initEvent('click', true, true);
			      link.dispatchEvent(event);
			    }
			    else if (link.click) {
			      link.click();
			    }
			    link.parentNode.removeChild(link);
			}
		});
		return false;
	})
	
	$("body #showhome").click(function(){
		var url = $(this).attr("href");
		var isData = ($(this).attr("data-is") == 1 ) ? 'hidden' : 'show';
		var c = confirm("Are you want "+isData+" it at home page!");
		if(c){
			$.ajax({
				url : url,
				type : "post",
				data :{ id : 0},
				success : function(r){
					if(r == "success"){
						window.location.reload();
					}else{
						alert("Error ! Please try again your action");
					}
				},error:function(e){
		          alert("Error ! Please try again your action");
		        }
			})
		}	
		return false;
	});
</script>