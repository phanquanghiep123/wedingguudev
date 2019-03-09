
<div id="<?php echo ($this->input->get("is_iframe") == "true") ? "is_iframe" : "is_page" ; ?>">
  <div class="row demo-columns">
      <div class="col-md-5 iframe-hidden" id="box-chose-file">
        <!-- D&D Zone-->
        <div id="drag-and-drop-zone" class="uploader">
           <div>Drag &amp; Drop Images Here</div>
           <div class="or">-or-</div>
           <div class="browser">
              <label>
              <span>Click to open the file Browser</span>
              <input type="file" id="input-upload-file" name="files[]" multiple="multiple" title='Click to add Files'>
              </label>
           </div>
        </div> 
      </div>
     <!-- / Left column -->
      <div class="col-md-7 iframe-hidden" id="box-log-upload">
        <div class="panel panel-default">
           <div class="panel-heading">
              <h3 class="panel-title">Uploads</h3>
           </div>
           <div class="panel-body demo-panel-files" id='demo-files'>
              <span class="demo-note">No Files have been selected/droped yet...</span>
           </div>
        </div>
      </div>
      <div class="col-md-12">
        <div id="action-allmediall" style="margin-bottom: 30px;">
          <a href="javascript:;" data-id="0" href="javascript:;" id="backFolder" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"> Trở lại</i></a>
          <a href="javascript:;" onclick="return $('#input-upload-file').trigger('click');" class="none btn btn-primary iframe-show"><i class="fa fa-upload" aria-hidden="true"> Tải tệp lên</i></a>
          <a href="javascript:;" data-toggle="modal" data-target="#modal-add-folder" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"> Thêm thư mục</i></a>
          <a href="javascript:;" id="delete-list-media" class="btn btn-warning"><i class="fa fa-trash-o" aria-hidden="true"> Xóa Lựa Chọn</i></a>         
          <?php if (@$user["is_system"] == 1) :?>
            <a href="javascript:;" data-type="1" class="list-action-media btn btn-info"><i class="fa fa-copy" aria-hidden="true"> Sao Chép Lựa Chọn</i></a>
            <a href="javascript:;" data-type="2" class="list-action-media btn btn-info"><i class="fa fa-cut" aria-hidden="true"> Chuyển Tệp Lựa Chọn</i></a>
            <a href="javascript:;" data-type="3" class="list-action-media btn btn-info disabled"><i class="fa fa-paste" aria-hidden="true"> Dán</i></a>
          <?php endif;?>
          <a href="javascript:;" id="selecte-all" class="btn btn-info"><i class="fa fa-check-square" aria-hidden="true"> Chọn tất cả tệp</i></a>
          <a href="javascript:;" id="choose-select" class="none btn btn-info iframe-show"><i class="fa fa-plus-square" aria-hidden="true"> Áp dụng lựa chọn</i></a>
        </div>
      </div>
     <!-- / Right column -->
     <div id="modal-add-folder" class="modal fade" role="dialog">
      <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add new folder</h4>
          </div>
          <div class="modal-body">
            <div class="input-group input-group-sm">
              <label class="input-group-addon" for="media-name">Folder name</label>
              <input class="form-control" id="folder-name" type="text" required="required" maxlength="255" placeholder="Enter folder name">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="add-folder-now">Add</button>
          </div>
        </div>
      </div>
     </div>
  </div>
  <div id="filemanager-page-main">
  <div class="row">
    <?php if (@$user["is_system"] == 1) :?>
    <div class="col-md-12">
      <ul class="breadcrumb" id="path_folder">
        <li class="active"><img src="<?php echo skin_url("themes/skins/images/1_open.png")?>"><span> root</span></li>
      </ul>
    </div>
    <?php endif;?>
    <?php if (@$user["is_system"] == 1) :?>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><ul id="treeDemo" class="ztree"></ul></div>
    <?php endif;?>
    <?php if (@$user["is_system"] == 1) :?>
    <div class="col-xs-9 col-md-9 col-lg-9">
    <?php else: ?>
      <div class="col-xs-12">
    <?php endif;?>
        <div class="row custom-row">
          <div id="contaner-media">
            <?php
              if(@$list_media != null){
                foreach ($list_media as $key => $value) {
                  $sizestring = "";
                  if($value["type_name"] != "folder"){
                    foreach ($sizeData as $key_1 => $value_1) {
                      if(((int)$value_1["value"]) < $value["size"]){
                          $sizestring = "(" .round(($value["size"] / ((int)$value_1["value"])),2) .  $value_1["key_id"] .")";
                      }
                    }
                  }
                  ?>
                  <?php if (@$user["is_system"] == 1) :?>
                  <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 item-colums">
                  <?php else: ?>
                    <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 item-colums">
                  <?php endif;?>
                    <div id="contaner-item" data-folder ="<?php echo $value['folder_id'];?>" data-type="<?php echo $value["type_name"]?>" class="<?php echo $value["type_name"]?>" data-id="<?php echo $value["id"]?>" data-typeid="<?php echo $value["type_id"]?>">
                      <div class="action" data-id="<?php echo $value["id"]?>" data-type="<?php echo $value["type_id"]?>"  data-type-name="<?php echo $value["type_name"]?>">
                        <a href="javascript:;" id="select-media"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                        <a href="javascript:;" id="delete-media"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        <a href="javascript:;" id="edit-media"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                      </div>
                      <div class="bg-info">
                        <p><?php echo  $value["name"]?> <?php echo $sizestring;?></p>
                      </div>
                      <?php 
                        if($value["icon"] == null && $value["icon"] == ""){
                          echo '<img class="thumb-media" src="'.base_url( $value["thumb"]).'">';
                        }else{
                          echo '<i class="thumb-media '.$value["icon"].'" ></i>';
                        }
                      ?>
                    </div>
                  </div>
                <?php }
              }else{
                echo '<div class="empty-folder"><p><i class="fa fa-thermometer-empty" aria-hidden="true"></i></p><p>Folder is emty</p></div>';
              }
            ?>
          </div>
        </div>
    </div>
  </div>
  </div>
  <div id="modal-edit-media" class="modal fade edit-from" role="dialog">
      <div class="modal-dialog full-custom">
        <form id="save-edit" method="post" enctype="multipart/form-data">
        <input type="hidden" id="base64image" name="base64image"> 
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
        </form>
      </div>
  </div>
   <div id="modal-edit-media-text" class="modal fade edit-from" role="dialog">
      <div class="modal-dialog full-custom">
        <form id="save-edit" method="post" enctype="multipart/form-data">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
        </form>
      </div>
  </div>
  <div id="modal-edit-media-not-img" class="edit-from modal fade" role="dialog">
    <form id="save-edit" method="post" enctype="multipart/form-data">  
      <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit media</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<link href="<?php echo skin_url("themes/cropper-master/dist/cropper.css");?>" rel="stylesheet">
<script src="<?php echo skin_url("themes/cropper-master/dist/cropper.js");?>"></script>
<link rel="stylesheet" href="<?php echo skin_url("themes/zTree_v3-master/css/demo.css");?>" type="text/css">
<link rel="stylesheet" href="<?php echo skin_url("themes/zTree_v3-master/css/zTreeStyle/zTreeStyle.css");?>" type="text/css">
<link href="<?php echo skin_url("themes/filemanager/filemanager.css");?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo skin_url("themes/zTree_v3-master/js/jquery.ztree.core.js");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/zTree_v3-master/js/jquery.ztree.excheck.js");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/zTree_v3-master/js/jquery.ztree.exedit.js");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/uploader-master/js/demo-preview.js");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/uploader-master/src/dmuploader.js");?>"></script>
<script type="text/javascript">
  var max_file   = "<?php echo @$this->input->get("max_file");?>";
  var type_file  = "<?php echo @$this->input->get("type_file");?>";
  var ext_filter = "<?php echo @$this->input->get("ext_filter");?>";
  var _selector  = "<?php echo @$this->input->get("selector");?>";
  var file_size  = "<?php echo @$this->input->get("file_size");?>";
  var zTree  = null;
  var string = '<?php echo json_encode(@$mediatype);?>';
  var $cropperBox = null;
  var extensions = JSON.parse(string);
  var base_url  = '<?php echo base_url();?>';
  var folder = <?php echo @$folder_id;?>;
  var id     = 0;
  var type   = null;
  var ids    = [];
  var action_current = false;
  var currentnode = null;
  var upload_status = 0;
  var listOld = [folder];
  var curentIndex = 1;
  var $dataX =  $dataY =  $dataHeight =  $dataWidth =  $dataRotate = $dataScaleX = $dataScaleY = null;
  $(document).ready(function(){
    var setting = {
      async: {
        enable: true,
        url: getUrl
      },
      check: {
        enable: false
      },
      data: {
        simpleData: {
          enable: true
        }
      },
      view: {
        expandSpeed: true,
        dblClickExpand: false,
        showLine: true,
        selectedMulti: false
      },
      callback: {
        beforeExpand: beforeExpand,
        onAsyncSuccess: onAsyncSuccess,
        onAsyncError: onAsyncError,
        beforeMouseUp  : onMouseDown,
        onClick : function(event, treeId, treeNode, clickFlag){
          currentnode = treeNode;
          var node = currentnode.getPath();
          var lengthnode = Object.keys(node).length - 1;
          var breadcrumb = "";
          $.each(node,function(k,v){
            if(k < lengthnode){
              breadcrumb += '<li><a href="javascript:;" data-type="folder" id="contaner-item" data-id="'+v.id+'" class="breadcrumb-item"><img src="'+v.iconOpen+'"><span> '+v.name+'</span></a></li>';
            }else{
              breadcrumb += '<li class="active" ><img src="'+v.iconOpen+'"><span> '+v.name+'</li>';
            }
          });
          $("#path_folder").html(breadcrumb);
          zTree.selectNode(currentnode);
        },
        beforeClick:function(treeId, treeNode, clickFlag){
          currentnode = treeNode;
          zTree.selectNode(currentnode);
        }

      }
    };
    var zNodes = JSON.parse('<?php echo json_encode(@$list_folder)?>');
    var log, className = "dark",
    startTime = 0, endTime = 0, perCount = 100, perTime = 100;
    startTime = new Date();
    function getUrl(treeId, treeNode) {
      currentnode = treeNode;
      var param = "id="+treeNode.id;
      return "<?php echo( base_url("filemanager/get_folder_by_id?"))?>" + param;
    }
    function getTime() {
      var now= new Date(),
      h=now.getHours(),
      m=now.getMinutes(),
      s=now.getSeconds(),
      ms=now.getMilliseconds();
      return (h+":"+m+":"+s+ " " +ms);
    }
    function onMouseDown(treeId, treeNode){
      currentnode = treeNode;
      if(typeof treeNode != "undefined" && treeNode != null && treeNode.id != null)
      {
        folder = treeNode.id;
        var zTree     = $.fn.zTree.getZTreeObj("treeDemo");
        treeNode.icon = "<?php echo skin_url("themes/zTree_v3-master/css/zTreeStyle/img/loading.gif");?>";
        zTree.updateNode(treeNode);
        addloadding();
        $.ajax({
          url : "<?php echo base_url("filemanager/get")?>",
          type : "post",
          dataType:"json",
          data:{
            folder : treeNode.id,
            type : "folder",
            file_size : file_size,
            type_file :type_file,
            ext_filter:ext_filter
          },
          success : function (r){
            if(r.status == "success"){
              var item = (r.response);
              $("body #contaner-media").html(item); 
              zTree.reAsyncChildNodes(treeNode, "refresh", true);
              set_action_copy_cut();
              set_select_all();
            }else{
              alert("Error ! Please try again your action");
            }
            remove_loadding();
          },
          error : function(e){
            alert("Error ! Please try again your action");
            remove_loadding();
          }
        });
      }
    }
    function beforeExpand(treeId, treeNode) {
      currentnode = treeNode;
      if (!treeNode.isAjaxing) { 
        treeNode.times = 1;
        ajaxGetNodes(treeNode, "refresh");
        return true;
      } else {
        alert("Downloading data, Please wait to expand node...");
        return false;
      }
      zTree.selectNode(currentnode);
    }
    function onAsyncSuccess(event, treeId, treeNode, msg) {
      currentnode = treeNode;
      if (!msg || msg.length == 0) {
        return;
      }
      var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
      totalCount = treeNode.count;
      if (treeNode.children.length < totalCount) {
        setTimeout(function() {ajaxGetNodes(treeNode);}, perTime);
      } else {
        treeNode.icon = "";
        zTree.updateNode(treeNode);
        zTree.selectNode(treeNode.children[0]);
        endTime = new Date();
        var usedTime = (endTime.getTime() - startTime.getTime())/1000;
        className = (className === "dark" ? "":"dark");
        showLog("[ "+getTime()+" ]&nbsp;&nbsp;treeNode:" + treeNode.name );
        showLog("Child node has finished loading, a total of "+ (treeNode.times-1) +" times the asynchronous load, elapsed time: "+ usedTime + " seconds ");
      }
    }
    function onAsyncError(event, treeId, treeNode, XMLHttpRequest, textStatus, errorThrown) {
      currentnode = treeNode;
      alert("ajax error...");
      treeNode.icon = "";
      zTree.updateNode(treeNode);
    }
    function ajaxGetNodes(treeNode, reloadType) {
      currentnode = treeNode;
      if (reloadType == "refresh") {
        treeNode.icon = "<?php echo skin_url("themes/zTree_v3-master/css/zTreeStyle/img/loading.gif");?>";
        zTree.updateNode(treeNode);
      }
      zTree.reAsyncChildNodes(treeNode, reloadType, true);
    }
    function showLog(str) {
      if (!log) log = $("#log");
      log.append("<li class='"+className+"'>"+str+"</li>");
      if(log.children("li").length > 4) {
        log.get(0).removeChild(log.children("li")[0]);
      }
    }
    <?php if (@$user["is_system"] == 1) :?>
    $(document).ready(function(){
      $.fn.zTree.init($("#treeDemo"), setting, zNodes);
      zTree = $.fn.zTree.getZTreeObj("treeDemo");
      currentnode = zTree.getNodeByTId("treeDemo_1");
    });
    <?php endif;?>
    $("#modal-add-folder #add-folder-now").click(function(){
      var folder_name = $("#modal-add-folder #folder-name").val();
      if(folder_name != null && folder_name.trim() != ""){
        addloadding();
        $.ajax({
          url : "<?php echo base_url("filemanager/add/folder")?>",
          type : "post",
          dataType:"json",
          data:{name : folder_name,folder: folder },
          success : function (r){
            if(r.status == "success"){
              var item = (r.response);
              $("body #contaner-media").prepend(item);
              $("#modal-add-folder").modal("hide");
              $("#modal-add-folder #folder-name").val("");
              <?php if (@$user["is_system"] == 1) :?>
              	zTree.addNodes(currentnode,0,r.record);
              <?php endif;?>
              $("#contaner-media .empty-folder").remove();
            }else{
              alert("Error ! "+r.message);
            }   
            remove_loadding();
          },error : function(e){
            alert("Error ! Please try again your action");
            remove_loadding();
          }
        });
      }else{
        alert("Please enter folder name");
      }
    });
  });
  var upload =  $('#drag-and-drop-zone').dmUploader({
    url: "<?php echo base_url ("filemanager/upload");?>",
    dataType: 'json',
    extFilter : '<?php echo $allow_uploads;?>',
    OnsentData : function(){
      if(upload_status == 0){
        upload_status++;
        addloadding();
      }
      var fd = new FormData();
      fd.append("folder", folder);
      return fd;
    },
    onInit: function(){

      //$.danidemo.addLog('#demo-debug', 'default', 'Plugin initialized correctly');
    },
    onBeforeUpload: function(id){
      
      //$.danidemo.DataSent({folder : folder})
      //$.danidemo.addLog('#demo-debug', 'default', 'Starting the upload of #' + id);
      try{
        $.danidemo.updateFileStatus(id, 'default', 'Uploading...');
      }catch(e){
      }

    },
    onNewFile: function(id, file){
      $.danidemo.addFile('#demo-files', id, file);
      var exe = file.name.replace(/^.*\./, '');
      var extension = null;
      $.each (extensions,function(k,v){
        if(v.extension.indexOf("/"+exe.toLowerCase()+"/")!=-1){
          extension = v;
          return false;
        }
      });
      if(extension == null){
        $.each (extensions,function(k,v){
          if(v.name == "file"){
            extension = v;
            return false;
          }
        });
      }
      if(extension.name == "image"){
        if (typeof FileReader !== "undefined"){
          var reader = new FileReader();
          var img = $('#demo-files').find('.demo-image-preview').eq(0);
          reader.onload = function (e) {
            img.attr('src', e.target.result);
          }
          reader.readAsDataURL(file);
        } else {
          $('#demo-files').find('.demo-image-preview').remove();
        }
      }else{
        $('#demo-files').find('.demo-image-preview').eq(0).parent().prepend('<i class="'+extension.icon+'"></i>');
        $('#demo-files').find('.demo-image-preview').eq(0).remove();
      }
      
      /*** Ends Image preview loader ***/
    },
    onComplete: function(id,percent){
      remove_loadding();
      upload_status = 0;
      //$.danidemo.addLog('#demo-debug', 'default', 'All pending tranfers completed');
    },
    onUploadProgress: function(id, percent){
      var percentStr = percent + '%';
      try{
        $.danidemo.updateFileProgress(id, percentStr);
      }catch(e){

      }
    },
    onUploadSuccess: function(id, data){
      var item = (data.response);
      $("body #contaner-media").prepend(item);
      $("#contaner-media .empty-folder").remove();
      try{
        delete data.response.show_view;
      }catch (err){

      }
      //$.danidemo.addLog('#demo-debug', 'success', 'Upload of file #' + id + ' completed');
     // $.danidemo.addLog('#demo-debug', 'info', 'Server Response for file #' + id + ': ' + JSON.stringify(data));
     try{
        $.danidemo.updateFileStatus(id, 'success', 'Upload Complete');
      }catch(e){

      }
      $.danidemo.updateFileStatus(id, 'success', 'Upload Complete');
      $.danidemo.updateFileProgress(id, '100%');
      $('#demo-file' + id).find('div.progress-bar').addClass("progress-bar-success");
      setTimeout(function(){ $('#demo-file' + id).animate({opacity : 0},2000,function(){
        $(this).remove();
      }) }, 3000);

    },
    onUploadError: function(id, message){
      try{
        $.danidemo.updateFileStatus(id, 'error', message);
        alert('Failed to Upload file #' + id + ': ' + message);
      }catch(e){

      }
     
    },
    onFileTypeError: function(file){
      //alert('File' + file.name + ' cannot be added: must be an image');
    },
    onFileExtError: function(file){
      alert('File extension of ' + file.name + ' is not allowed');
    },
    onFileSizeError: function(file){
      //$.danidemo.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' cannot be added: size excess limit');
    },
    onFallbackMode: function(message){
      //$.danidemo.addLog('#demo-debug', 'info', 'Browser not supported(do something else here!): ' + message);
    }
  });
  $(document).on("click","#filemanager-page-main #contaner-item",function(){
      type = $(this).attr("data-type");
      id   = $(this).attr("data-id");
      if(type == "folder") {
        listOld.push (id);
        curentIndex++;
      }
      if(type == "folder"){
        folder = id;
        var breadcrumb = "";
        <?php if (@$user["is_system"] == 1) :?>
        currentnode = zTree.getNodeByParam('id',id);
        var node = currentnode.getPath();
        var lengthnode = Object.keys(node).length - 1;
        $.each(node,function(k,v){
          if(k < lengthnode){
            breadcrumb += '<li><a href="javascript:;" data-type="folder" id="contaner-item" data-id="'+v.id+'" class="breadcrumb-item"><img src="'+v.iconOpen+'"><span> '+v.name+'</span></a></li>';
          }else{
            breadcrumb += '<li class="active" ><img src="'+v.iconOpen+'"><span> '+v.name+'</li>';
          }
        });
        <?php endif;?>
        $("#path_folder").html(breadcrumb);
        get_file_on_folder({
          folder : id,
          type : type,
          file_size : file_size,
          type_file :type_file,
          ext_filter :ext_filter
        });
      } 
      else{
        $(this).find("#select-media").trigger("click");
      } 
  });
  function get_file_on_folder (data){
      addloadding();
      $.ajax({
        url : "<?php echo base_url("filemanager/get")?>",
        type : "post",
        dataType:"json",
        data:data,
        success : function (r){
          if(r.status == "success"){
            var item   = (r.response);
            var record =(r.record); 
            $("body #contaner-media").html(item); 
            set_select_all();
            set_action_copy_cut();
            <?php if (@$user["is_system"] == 1) :?>
              zTree.expandNode(currentnode,true); 
              zTree.selectNode(currentnode);
            <?php endif;?>
          }else{
            alert(r.message);
          }
          remove_loadding();
        },
        error : function(e){
          alert("Error ! Please try again your action");
          remove_loadding();
        }
      });
  }
  $(document).on("click","#contaner-item .action #select-media",function(event){
    event.stopPropagation();
    var id_on = $(this).parent(".action").attr("data-id");
    if($(this).hasClass("selected") == false){
      $(this).addClass("selected");
      $(this).find("i").removeClass("fa-square-o").addClass("fa-check-square");
    }else{
      $(this).removeClass("selected");
      $(this).find("i").removeClass("fa-check-square").addClass("fa-square-o");
    }
    ids = [];
    $.each($("#contaner-item .action #select-media.selected"),function(k,v){
      ids.push( $(this).parent(".action").attr("data-id") );
    });
    return false;
  });
  $(document).on("click","#action-allmediall #delete-list-media",function(event){
    event.stopPropagation();
    ids = [];
    $.each($("#contaner-item .action #select-media.selected"),function(k,v){
      ids.push( $(this).parent(".action").attr("data-id") );
    });
    if(ids.length == 0){
      alert("Please select at least a item!");
    }else{
      var c = confirm("Do you really want to delete the things you selected?");
      if(c){
        addloadding();
        $.ajax({
          url : "<?php echo base_url("filemanager/delete")?>",
          type : "post",
          dataType : "json",
          data : {data : ids},
          success : function(r){
            if(r.status != "success"){
              alert("Error ! Please try again your action");
            }else{
              
              $.each(ids,function(k,v){
              	<?php if (@$user["is_system"] == 1) :?>
                var node = zTree.getNodeByParam('id',v);
                if(node != null)
                  zTree.removeNode(node,function(){return false;});
                <?php endif;?>
                $("#contaner-media .item-colums #contaner-item[data-id='"+v+"']").parent(".item-colums").remove();
              });
              
            }
            set_action_copy_cut();
            set_select_all();
            remove_loadding();
          },error:function(e){
            alert("Error ! Please try again your action");
            remove_loadding();
          }
        });
      }
    }
    return false;
  });
  $(document).on("click","#action-allmediall .list-action-media",function(event){
    if(ids.length < 1){ alert("Please select at least a item!"); return false;}
    if($(this).attr("data-type") != 3 && ids.length > 0){
      action_current = $(this).attr("data-type");
    }
    $("#action-allmediall .list-action-media").removeClass("disabled");
    if($(this).attr("data-type") == 3){
      $(this).addClass("disabled");
      addloadding();
      $.ajax({
        url : "<?php echo base_url("filemanager/actions")?>",
        type : "post",
        dataType : "json",
        data : {data : ids,type : action_current ,folder : folder},
        success : function(r){
          var new_node = r.new_node;
          var item = (r.response);
          <?php if (@$user["is_system"] == 1) :?>
          if(new_node != null){
            $.each(new_node,function(k,v){
              if(action_current == 2){
                var node = zTree.getNodeByParam('id',v.id);
                zTree.removeNode(node,function(){return false;});
              }
              zTree.addNodes(currentnode,0,v);
            }); 
          }
          <?php endif;?>
          action_current = false;
          ids = [];
          $("#contaner-media .empty-folder").remove();
          $("body #contaner-media").prepend(item); 
          remove_loadding();
        },error:function(e){
          alert("Error ! Please try again your action");
          remove_loadding();
        }
      });
    }
    return false;
  });
  $(document).on("click","#contaner-item .action #edit-media",function(){
    var id = $(this).parent().attr("data-id");
    addloadding();
    $.ajax({
      url : "<?php echo base_url("filemanager/edit")?>",
      type :"post",
      dataType :"json",
      data : {id : id},
      success : function(r){
        if(r.status == "success"){ 
          if(r.mediatype.name == "image"){
            $("#modal-edit-media .modal-body").html(r.response);
            $("#modal-edit-media").modal();
          }else if(r.mediatype.name == "text"){
            $("#modal-edit-media-text .modal-body").html(r.response);
            $("#modal-edit-media-text").modal();
          }
          else{
            $("#modal-edit-media-not-img .modal-body").html(r.response);
            $("#modal-edit-media-not-img").modal();
          }
          remove_loadding();
        }
      },
      error : function(e){
        remove_loadding();
      }
    })
    return false;
  });
  $(document).on("click","#contaner-item .action #delete-media",function(){
    event.stopPropagation();
    id = [$(this).parent().attr("data-id")];
    if(id.length == 0){
      alert("Please select at least a item!");
    }else{
      var c = confirm("Do you really want to delete the things you selected?");
      if(c){
        addloadding();
        $.ajax({
          url : "<?php echo base_url("filemanager/delete")?>",
          type : "post",
          dataType : "json",
          data : {data : id},
          success : function(r){
            if(r.status != "success"){
              alert("Error ! Please try again your action");
            }else{
                $.each(id,function(k,v){
                  <?php if (@$user["is_system"] == 1) :?>
                  var node = zTree.getNodeByParam('id',v);
                  if(node != null)
                    zTree.removeNode(node,function(){return false;});
                  <?php endif;?>
                $("#contaner-media .item-colums #contaner-item[data-id='"+v+"']").parent(".item-colums").remove();
              });
            }
            remove_loadding();
          },error:function(e){
            alert("Error ! Please try again your action");
            remove_loadding();
          }
        });
      }
    }
    return false;
  });
  $(document).on("click","#action-allmediall #selecte-all",function(){
      if($(this).hasClass("all_check")){
        $.each($("#contaner-media .item-colums"),function(){
          $(this).find("#select-media").removeClass("selected");
          $(this).find("#select-media i").removeClass("fa-check-square");
          $(this).find("#select-media i").addClass("fa-square-o");
        });
        $(this).removeClass("all_check");
        $(this).find("i").removeClass("fa-square-o");
        $(this).find("i").addClass("fa-check-square");
        $(this).find("i").text(" Chọn tất cả");
      }else{
        $.each($("#contaner-media .item-colums"),function(){
          $(this).find("#select-media").addClass("selected");
          $(this).find("#select-media i").removeClass("fa-square-o");
          $(this).find("#select-media i").addClass("fa-check-square");
        });
        $(this).addClass("all_check");
        $(this).find("i").removeClass("fa-check-square");
        $(this).find("i").addClass("fa-square-o");
        $(this).find("i").text(" Bỏ chọn tất cả");
      }
      ids = [];
      $.each($("#contaner-item .action #select-media.selected"),function(k,v){
        ids.push( $(this).parent(".action").attr("data-id") );
      });
  });
  function addloadding(){
    $("body").append('<div id="loading-ajax" class="display-table"><div class="display-cell"><div class="loader"></div></div></div>');
  }
  function remove_loadding(){
    $("body #loading-ajax").remove();
  }
  function set_action_copy_cut(){
    $("#action-allmediall .list-action-media[data-id=1]").removeClass("disabled");
    $("#action-allmediall .list-action-media[data-id=2]").removeClass("disabled");
    $("#action-allmediall .list-action-media[data-id="+action_current+"]").addClass("disabled");
    if(action_current != false)$("#action-allmediall .list-action-media[data-id=3]").removeClass("disabled");
    if(action_current == false)$("#action-allmediall .list-action-media[data-id=3]").addClass("disabled");
  }
  function set_select_all(){
    $("#action-allmediall #selecte-all").removeClass("all_check");
    $("#action-allmediall #selecte-all").find("i").removeClass("fa-square-o");
    $("#action-allmediall #selecte-all").find("i").addClass("fa-check-square");
    $("#action-allmediall #selecte-all").find("i").text(" Chọn tất cả");
  }
  $("#modal-edit-media-not-img").on('hidden.bs.modal', function() {
    $(this).find(".modal-body").html("");
  });
  $("#modal-edit-media").on('hidden.bs.modal', function() {
    $(this).find(".modal-body").html("");
  });
  $("#modal-edit-media-text").on('hidden.bs.modal', function() {
    $(this).find(".modal-body").html("");
  });
  <?php
  if($this->input->get("is_iframe") == "true"){ ?>
    $("#modal-edit-media").on('show.bs.modal', function() {
      var modal_filemanager = window.parent.$('#modal-filemanager'); 
      $(modal_filemanager).find(".close").hide();
    });
    $("#modal-edit-media").on('hidden.bs.modal', function() {
      var modal_filemanager = window.parent.$('#modal-filemanager'); 
      $(modal_filemanager).find(".close").show();
    });
    $("#modal-edit-media-text").on('show.bs.modal', function() {
      var modal_filemanager = window.parent.$('#modal-filemanager'); 
      $(modal_filemanager).find(".close").hide();
    });
    $("#modal-edit-media-text").on('hidden.bs.modal', function() {
      var modal_filemanager = window.parent.$('#modal-filemanager'); 
      $(modal_filemanager).find(".close").show();
    });
  <?php } ?>
</script>
<script src="<?php echo skin_url("themes/cropper-master/dist/main.js");?>"></script>
<?php if($this->input->get("is_iframe") == "true"):?>
<script type="text/javascript" src="<?php echo skin_url("themes/filemanager/filemanager.js")?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    addloadding();
  });
  $(window).load(function(){
    remove_loadding();
  });
  var is_iframe = $('#is_iframe').Scfilemanagers({
    _media : true
  });
  function backFolder(id){
      var type = "folder";
      if(curentIndex - 2 < 0 ) return false;
      var id   =  listOld[curentIndex - 2];
      if(curentIndex > 1){
      	curentIndex--;
      }
      if(type == "folder"){
        folder = id;
        var breadcrumb = "";
        <?php if (@$user["is_system"] == 1) :?>
        currentnode = zTree.getNodeByParam('id',id);
        var node = currentnode.getPath();
        var lengthnode = Object.keys(node).length - 1;
        $.each(node,function(k,v){
          if(k < lengthnode){
            breadcrumb += '<li><a href="javascript:;" data-type="folder" id="contaner-item" data-id="'+v.id+'" class="breadcrumb-item"><img src="'+v.iconOpen+'"><span> '+v.name+'</span></a></li>';
          }else{
            breadcrumb += '<li class="active" ><img src="'+v.iconOpen+'"><span> '+v.name+'</li>';
          }
        });
        <?php endif;?>
        $("#path_folder").html(breadcrumb);
        get_file_on_folder({
          folder : id,
          type : type,
          file_size : file_size,
          type_file : type_file,
          ext_filter : ext_filter
        });
      } 
      else{
        $(this).find("#select-media").trigger("click");
      } 
      return true;
  }
  $(document).on("click","#backFolder",function(){
    return backFolder($(this).attr("data-id"));
  })
  $(document).on("click","#is_iframe #choose-select",function(){
    var _filemanager_setting = window.parent._filemanager_setting.list_filemanager[_selector];
    var max_length  = _filemanager_setting.options.query.max_file;
    var data_add_id = [];
    $.each($("#contaner-item .action #select-media.selected"),function(k,v){
      try{
        if($(this).closest("#contaner-item").attr("data-type") != "folder"){
          data_add_id.push( $(this).parent(".action").attr("data-id") );
        }else if(_filemanager_setting.options.query.ext_filter == "folder"){
          data_add_id.push( $(this).parent(".action").attr("data-id") );
        }
      }catch(e){

      } 
    });
    if(data_add_id.length < 1) {
      alert("Please select at least 1 media file");
      return false;
    }
    if(data_add_id.length > max_length){
      alert("Please select up to "+max_length+" media file");
      return false;
    }
    addloadding();
    $.ajax({
      url : "<?php echo base_url("filemanager/get_by_ids")?>",
      type : "post",
      dataType : "json",
      data : {
        ids       : data_add_id,
        file_size : file_size,
        type_file : type_file,
        ext_filter: ext_filter
      },
      success : function(r){
        if(r.status == "success"){
          if(Object.keys(r.response).length < 1){
            alert("Please select a media file of the correct format");
          }else{
            is_iframe.actionchange(_selector,r.response);
          }
          
        }else{
          alert("Error ! Please try again your action");
        }
        remove_loadding();
      },error:function(e){
        alert("Error ! Please try again your action");
        remove_loadding();
      }
    });
    return false;
  });
   $(document).on("dblclick","#is_iframe #contaner-item",function(){
    if($(this).attr("data-type") == "text"){
      var _filemanager_setting = window.parent._filemanager_setting.list_filemanager[_selector];
      var max_length  = _filemanager_setting.options.query.max_file;
      var data_add_id = [$(this).attr("data-id")];
      if(data_add_id.length < 1) {
        alert("Please select at least 1 media file");
        return false;
      }
      if(data_add_id.length > max_length){
        alert("Please select up to "+max_length+" media file");
        return false;
      }
      addloadding();
      $.ajax({
        url : "<?php echo base_url("filemanager/get_by_ids")?>",
        type : "post",
        dataType : "json",
        data : {
          ids       : data_add_id,
          file_size : file_size,
          type_file : type_file,
          ext_filter: ext_filter
        },
        success : function(r){
          if(r.status == "success"){
            if(Object.keys(r.response).length < 1){
              alert("Please select a media file of the correct format");
            }else{
              if(max_length == 1){
                is_iframe.actionchange(_selector,r.response[0]);
              }else{
                is_iframe.actionchange(_selector,r.response);
              } 
            } 
          }else{
            alert("Error ! Please try again your action");
          }
          remove_loadding();
        },error:function(e){
          alert("Error ! Please try again your action");
          remove_loadding();
        }
      });
      return false;
    }
  });
</script>
<?php endif;?>