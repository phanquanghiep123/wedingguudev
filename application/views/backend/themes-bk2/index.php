<div class="x_title">
    <form action="" method="get">
        <div class="row">
            <div class="col-sm-4">
                <h2>
                    Chuyên mục <a class="btn btn-success create-item" href="<?php echo $action_create;?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Thêm mới</a>
                </h2>
            </div>
            <input type="hidden" name="ci_csrf_token" value="">
            <div class="col-sm-2">
                <div class="form-group">
                    <input alue="<?php echo $this->input->post("keyword")?>" statustype="text" name="keyword" placeholder="Từ khóa" class="form-control" maxlength="200" value="">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                <select value="<?php echo $this->input->post("is_system")?>" class="form-control" name="is_system">
					<option value="">--Loại theme --</option>
					<option value="1">Admin theme</option>
					<option value="0">Member theme</option>
				</select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                <select value="<?php echo $this->input->post("status")?>"  class="form-control" name="status">
					<option value="">Trạng thái</option>
					<option value="1">Hoạt động</option>
					<option value="0">Ngưng hoạt động</option>
				</select>
                </div>
            </div>
            <div class="col-sm-2 text-right">
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
				<th>Ngày tạo</th>
				<th>Hành động</th>
			</tr>
		</thead>
		<tbody>
			<?php if(@$tables != null){
				$i = 1;
				foreach ($tables as $key => $value) {
					echo '<tr>';
					echo '<td>'. ($i++) .'</td>';
					echo '<td>'. $value["name"] .'</td>';
					echo '<td>'. ($value["status"] == 0 ? "ẩn": " hiện") .'</td>';
					echo '<td>'. $value["created_at"] .'</td>';
					echo '<td><a  href="'.base_url($_cname."/edit/".$value["id"]).'">edit</a> | <a  href="'.base_url("themes/view/".$value["slug"]).'">view</a> | <a href="'.base_url($_cname."/delete/".$value["id"]).'" id="action-delete">delete</a></td>';
					echo '</tr>';
				}
			}?>
		</tbody>
	</table>
	<?php echo $this->pagination->create_links(); ?>
</div>
<script type="text/javascript">
	$("body #action-delete").click(function(){
		var url = $(this).attr("href");
		var c = confirm("Are you want delete it!");
		if(c){
			$.ajax({
				url : url,
				type : "post",
				dataType : "json",
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
</script>