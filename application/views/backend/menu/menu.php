<script type="text/javascript">
    var group_id = '<?php echo $id; ?>';
</script>
<link rel="stylesheet" href="<?php echo skin_backend('css/menu.css'); ?>" />
<script src="<?php echo skin_backend('js/menu.js');?>"></script>
<script src="<?php echo skin_backend('js/jquery.1.4.1.min.js');?>"></script>
<script src="<?php echo skin_backend('js/interface-1.2.js'); ?>"></script>
<script src="<?php echo skin_backend('js/inestedsortable.js'); ?>"></script>
<script src="<?php echo skin_backend('js/update_menu.js'); ?>"></script>
<div class="row">
    <div class="main-page <?php echo @$main_page;?>">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                  <div class="row">
                      <div class="col-sm-6">
                          <h2><?php echo @$record['Name']; ?> </h2>
                      </div>
                      <div class="col-sm-6 text-right">
                          <a class="btn btn-success create-item" href="<?php echo backend_url(@$base_controller);?>">Quay lại</a>
                      </div>
                  </div>
              </div>
              <div class="x_content">
                     <div class="row">
                         <div class="col-sm-9">
                            <div class="ns-row" id="ns-header">
                                <div class="ns-actions">Action</div>
                                <div class="ns-class">Class</div>
                                <div class="ns-url">Url</div>
                                <div class="ns-title">Name</div>
                            </div>
                            <?php
                                if(isset($menu) && $menu!=null){
                                    echo $menu;
                                }
                                else{
                                    echo '<ul id="easymm"></ul>';
                                }
                            ?>
                            <div id="ns-footer">
                               <button type="submit" disabled="disabled" class="btn btn-save btn-primary" id="btn-save-menu">Cập nhật</button>
                               <span class="image-load" style="display:none;"><img style="width:15px;" src="<?php echo skin_url('/images/loading.gif'); ?>"></span>
                            </div>
                         </div>
                         <div class="col-sm-3">
                            <div class="panel-group">
                  						  <div class="panel panel-default item-collaps">
                  							   <div class="panel-heading" >
                  							      <h4 class="panel-title">
                  								        <a role="button" href="#" class="active">
                                            Menu
                                            <span class="pull-right" style="font-size: 20px;line-height: 20px;">
                                                <i class="fa fa-angle-up" aria-hidden="true"></i>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </span>
                                          </a>
                  							      </h4>
                  							   </div>
                  							   <div class="panel-collapse collapse" style="display:block;">
                  							      	<div class="panel-body">
                  							        	  <div id="form-add-menu">
                                                <div class="form-group">
                                                    <label for="exampleInputName2">Tiêu đề</label>
                                                    <input type="text" class="form-control" id="add-title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputName2">Liên kết</label>
                                                    <input type="text" class="form-control" id="add-url">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputName2">Class</label>
                                                    <input type="text" class="form-control" id="add-class">
                                                </div>
                                      				  <div class="form-group">
                                          					 <div class="checkbox">
                              											  		<label><input type="checkbox" value="_blank" id="add-target">Mở cửa sổ mới</label>
                              											 </div>
                                                </div>
                                                <div class="form-group text-right">
                                                    <button id="add-menu" type="submit" class="btn btn-primary">Thêm mới</button>
                                                    <span class="image-load" style="display:none;"><img style="width:15px;" src="<?php echo skin_url('/images/loading.gif'); ?>"></span>
                                                </div>
                                            </div>
                  							      	</div>
                  							   </div>
                  						  </div>
                                <div class="panel panel-default item-collaps">
                                   <div class="panel-heading" >
                                      <h4 class="panel-title">
                                        <a role="button" href="#">
                                            Trang tỉnh
                                            <span class="pull-right" style="font-size: 20px;line-height: 20px;">
                                                <i class="fa fa-angle-up" aria-hidden="true"></i>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                      </h4>
                                   </div>
                                   <div class="panel-collapse collapse" >
                                        <div class="panel-body">
                                           <form method="post" action="">
                                               <div class="form-group">
                                                  <input type="text" class="form-control" name="keyword" placeholder="Từ khóa...">
                                               </div>
                                               <div class="list-item">
                                                   <ul>
                                                      <?php if(isset($page) && $page): ?>
                                                          <?php foreach ($page as $key => $item): ?> 
                                                              <li>
                                                                  <input type="checkbox" id="checkbox-page-<?php echo $item['ID'] ?>" name="item[]" value="/trang/<?php echo $item['Key_Identify'] ?>/|||<?php echo $item['Title']; ?>">
                                                                  <label for="checkbox-page-<?php echo $item['ID'] ?>"><?php echo $item['Title']; ?></label>
                                                              </li>
                                                          <?php endforeach; ?>
                                                      <?php endif; ?>
                                                   </ul>
                                               </div>
                                               <div style="height:10px;"></div>
                                               <div class="text-right">
                                                    <input type="hidden" name="type" value="page">
                                                    <input type="hidden" name="group_id" value="<?php echo $id; ?>">
                                                    <button type="button" class="btn btn-primary add-menu-list">Thêm mới</button>
                                               </div>
                                           </form> 
                                        </div>
                                   </div>
                                </div>
                                <div class="panel panel-default item-collaps">
                                   <div class="panel-heading" >
                                      <h4 class="panel-title">
                                        <a role="button" href="#">
                                            Bài viết
                                            <span class="pull-right" style="font-size: 20px;line-height: 20px;">
                                                <i class="fa fa-angle-up" aria-hidden="true"></i>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                      </h4>
                                   </div>
                                   <div class="panel-collapse collapse" >
                                        <div class="panel-body">
                                           <form method="post" action="">
                                               <div class="form-group">
                                                  <input type="text" class="form-control" name="keyword" placeholder="Từ khóa...">
                                               </div>
                                               <div class="list-item">
                                                   <ul>
                                                      <?php if(isset($post) && $post): ?>
                                                          <?php foreach ($post as $key => $item): ?> 
                                                              <li>
                                                                  <input type="checkbox" id="checkbox-post-<?php echo $item['ID'] ?>" name="item[]" value="/bai-viet/<?php echo $item['Slug'] ?>/|||<?php echo $item['Name']; ?>">
                                                                  <label for="checkbox-post-<?php echo $item['ID'] ?>"><?php echo $item['Name']; ?></label>
                                                              </li>
                                                          <?php endforeach; ?>
                                                      <?php endif; ?>
                                                   </ul>
                                               </div>
                                               <div style="height:10px;"></div>
                                               <div class="text-right">
                                                    <input type="hidden" name="group_id" value="<?php echo $id; ?>">
                                                    <input type="hidden" name="type" value="post">
                                                    <button type="button" class="btn btn-primary add-menu-list">Thêm mới</button>
                                               </div>
                                           </form> 
                                        </div>
                                   </div>
                                </div>
                                <div class="panel panel-default item-collaps">
                                   <div class="panel-heading" >
                                      <h4 class="panel-title">
                                        <a role="button" href="#">
                                            Chuyên mục bài viết
                                            <span class="pull-right" style="font-size: 20px;line-height: 20px;">
                                                <i class="fa fa-angle-up" aria-hidden="true"></i>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                      </h4>
                                   </div>
                                   <div class="panel-collapse collapse" >
                                        <div class="panel-body">
                                           <form method="post" action="">
                                               <div class="form-group">
                                                  <input type="text" class="form-control" name="keyword" placeholder="Từ khóa...">
                                               </div>
                                               <div class="list-item">
                                                   <ul>
                                                      <?php if(isset($category) && $category): ?>
                                                          <?php foreach ($category as $key => $item): ?> 
                                                              <li>
                                                                  <input type="checkbox" id="checkbox-category-<?php echo $item['ID'] ?>" name="item[]" value="/chuyen-muc/<?php echo $item['Slug'] ?>|||<?php echo $item['Name']; ?>">
                                                                  <label for="checkbox-category-<?php echo $item['ID'] ?>"><?php echo $item['Name']; ?></label>
                                                              </li>
                                                          <?php endforeach; ?>
                                                      <?php endif; ?>
                                                   </ul>
                                               </div>
                                               <div style="height:10px;"></div>
                                               <div class="text-right">
                                                   <input type="hidden" name="type" value="category">
                                                   <input type="hidden" name="group_id" value="<?php echo $id; ?>">
                                                   <button type="button" class="btn btn-primary add-menu-list">Thêm mới</button>
                                               </div>
                                           </form> 
                                        </div>
                                   </div>
                                </div>
                					  </div>
                         </div>
                     </div>
              </div>
            </div>
        </div>
    </div>
</div>


<!--model chang menu item-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Menu</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                   <label>Tiêu đề</label>
                   <input type="text" name="title" class="form-control" id="edit-title">
                </div>
                <div class="form-group">
                   <label>Liên kết</label>
                   <input type="text" name="url" class="form-control" id="edit-url">
                </div>
                <div class="form-group">
                   <label>Class</label>
                   <input type="text" name="class" class="form-control" id="edit-class">
                </div>
          	    <div class="form-group">
            			  <div class="checkbox">
            			  		<label><input type="checkbox" id="edit-target" value="_blank">Mở cửa sổ mới</label>
            			  </div>
                </div>
            </div>
            <div class="modal-footer">
      	        <input type="hidden" name="class" class="form-control" id="edit-id">
      	        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Hủy bỏ</button>
      	        <button type="button" class="btn btn-primary btn-edit">Lưu thay đổi</button>
      	        <span class="image-load" style="display:none;"><img style="width:15px;" src="<?php echo skin_url('/images/loading.gif'); ?>"></span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
      $(".panel-group .item-collaps .panel-title a").click(function(){
           var parents = $(this).parents('.item-collaps').parent();
           //parents.find('.item-collaps .panel-collapse').slideUp('slow');
           if($(this).hasClass('active')){
              $(this).removeClass('active');
              $(this).parents('.item-collaps').find('.panel-collapse').stop().slideUp('slow');
           }
           else{
              $(this).addClass('active');
              $(this).parents('.item-collaps').find('.panel-collapse').stop().slideDown('slow');
           }
           return false;
      });
   });
</script>
<style>
    .box {
      border: 1px solid #e5e5e5;
      background: #fafafa;
      margin-bottom: 10px;
      max-width: 245px;
      padding: 0 20px;
      margin-top: 0px;
    }
    .form-group label{font-weight: 0;}
    .border-error{border: 1px solid red !important;}
</style>
