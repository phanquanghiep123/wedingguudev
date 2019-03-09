<div class="is_page" id="page_parts">
  <div class="main-page <?php echo @$main_page;?>">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><?php echo (@$post["id"]) ? "Edit ": "Add new "?> theme sections</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
    <form method="post" action="<?php echo ($action_save)?>">
      <div class="form-group">
        <label for="name" class="col-sm-4 col-form-label">Section name</label>
        <div class="col-sm-8">
          <input type="text" name="name" class="form-control" id="name" value="<?php echo @$post["name"]?>" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="path_html" class="col-sm-4 col-form-label">Full content</label>
        <div class="col-sm-8">
          <select name="is_full" value="<?php echo @$post["is_full"]?>" class="form-control" required="required">
            <option value="">--select a item--</option>
            <option value="0">no</option>
            <option value="1">yes</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="show_title" class="col-sm-4 col-form-label">Show title</label>
        <div class="col-sm-8">
          <select name="show_title" value="<?php echo @$post["show_title"]?>" class="form-control" required="required">
            <option value="1" selected="selected">yes</option>
            <option value="0">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="class_name" class="col-sm-4 col-form-label">Class name</label>
        <div class="col-sm-8">
          <input type="text" name="class_name" class="form-control" id="class_name" value="<?php echo @$post["class_name"]?>">
        </div>
      </div>
      <div class="form-group">
        <label for="id_name" class="col-sm-4 col-form-label">Id name</label>
        <div class="col-sm-8">
          <input type="text" name="id_name" class="form-control" id="id_name" value="<?php echo @$post["id_name"]?>">
        </div>
      </div>
      <div class="form-group">
        <label for="sort" class="col-sm-4 col-form-label">Sort</label>
        <div class="col-sm-8">
          <input type="number" name="sort" class="form-control" id="sort" value="<?php echo @$post["sort"]?>">
        </div>
      </div>
      <div class="form-group">
        <label for="id_name" class="col-sm-4 col-form-label">Allow actions</label>
        <div class="col-sm-8">
          <div class="lable">
            <?php if(@$post["actions"]){
              foreach ($post["actions"] as $key => $value) {
                $active = "";
                if($value["active"] == 1){
                  $active = 'checked = "checked" ';
                }
                echo '<label><input id="action-item" name="actions[]" type="checkbox" value="'.$value["id"].'" '.$active.'>'.$value["name"].'</label>';
              }
            }?>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="id_name" class="col-sm-4 col-form-label">Allow style</label>
        <div class="col-sm-8">
          <div class="lable">
            <?php if(@$post["styles"]){
              foreach ($post["styles"] as $key => $value) {
                $active = "";
                if($value["active"] == 1){
                  $active = 'checked = "checked" ';
                }
               echo '<label><input id="action-item" name="styles[]" type="checkbox" value="'.$value["id"].'" '.$active.'>'.$value["key_name"].'</label>';
              }
            }?>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="path_html" class="col-sm-4 col-form-label">Number row item</label>
        <div class="col-sm-8">
          <select name="ncolum_block" value="<?php echo @$post["ncolum_block"]?>" class="form-control">
            <option value="0">--select a item--</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="6">6</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="ncolum_show_block" class="col-sm-4 col-form-label">Number show item (click load more item)</label>
        <div class="col-sm-8">
          <select name="ncolum_show_block" value="<?php echo @$post["ncolum_show_block"]?>" class="form-control">
            <option value="0">--select a item--</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="path_html" class="col-sm-4 col-form-label">Default add block</label>
        <div class="col-sm-8">
          <select name="default_block" value="<?php echo @$post["default_block"]?>" class="form-control">
            <option value="0">--select a item--</option>
            <?php if(@$post["blocks"]){
              foreach (@$post["blocks"] as $key => $value) {
                echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
              }
            }?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="path_html" class="col-sm-4 col-form-label">Status</label>
        <div class="col-sm-8">
          <select name="status" value="<?php echo @$post["status"]?>" class="form-control" required="required">
            <option value="1" selected="selected">show</option>
            <option value="0">hidden</option>  
          </select>
        </div>
      </div>
      <div class="col-sm-12">
          <div class="content-right">
            <div class="content-show-parts">
              <h3 class="text-center">Section content </h3>
              <div class="row">
                <div id="container-block">
                <?php if(@$post["my_blocks"] != null){
                  $html = "";
                  foreach ($post["my_blocks"] as $key => $value) {
                    $b = $value;
                    if($b){ 
                        $sbId  = $b["section_block_id"];
                        if($sbId){       
                            $html .= '<div data-colum="'.$value["ncolum"].'" data-id="'.$sbId.'" class="block-item col-md-'.$value["ncolum"].' ui-sortable-handle"><div class="wrapper-block">
                            <h4 class="block-title text-center">'.$b["name"].'</h4>
                            <div class="menu-action" id="support_block">
                              <ul class="menu-block">
                                <li><a href="javascript:;" id="edit-block"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                <li><a href="javascript:;" id="add-part"><i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
                                <li><a href="javascript:;" id="delete-block"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                              </ul>
                              <input type="hidden" value="'.$sbId.'" name="section_block_id[]">
                            </div>
                            <div id="list-part">';
                            $ps = $value["ps"];
                            if($ps){
                              foreach ($ps as $key_1 => $value_1) {    
                                $html .= '
                                <div data-colum="'.$value_1["ncolum"].'" data-id="'.$value_1["block_part_id"].'" class="item-part-block col-md-'.$value_1["ncolum"].' ui-sortable-handle"> 
                                  <div class="block-part">
                                    <h3 class="title-block">'.$value_1["name"].'</h3>
                                    <div class="menu-action" id="support_part">
                                      <ul class="menu-block"> 
                                        <li><a href="javascript:;" id="edit-part"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                        <li><a href="javascript:;" id="delete-part"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>'; 
                              }
                            }
                            $html .= '</div>';
                        }
                      }
                      $html .= '</div></div>';
                  }
                  echo $html;
                }?>          
                </div>
                <h3 class="text-center block-add-new"><a id="add-block" href="javascript:;">+ add block</a></h3>
              </div>
              <input type="hidden" name="ramkey" value="<?php echo $ramkey?>">
            </div>
            <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<div id="modal-page">
  <div id="modal-edit-block" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <!-- Modal content-->
      <div class="modal-content">
        <form id="edit-block-form">
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="save-block-part">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="modal-edit-part" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <!-- Modal content-->
      <div class="modal-content">
        <form id="edit-part-form">
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="save-block-part">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="modal-all-block" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <ul class="nav-parts">
            <?php if(@$post["blocks"] != null){
              foreach ($post["blocks"] as $key => $value) {
                echo '<li class="item-part" data-id="'.$value["id"].'" >
                <p data-id="'.$value["id"].'">'.$value["name"].'</p>
              </li>';
              }
            }?>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="add-block">Add</button>
        </div>
      </div>
    </div>
  </div>
  <div id="modal-all-part" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <ul class="nav-parts">
            <?php if(@$post["parts"] != null){
              foreach ($post["parts"] as $key => $value) {
                echo '<li class="item-part" data-id="'.$value["id"].'" >
                <p data-id="'.$value["id"].'">'.$value["name"].'</p>
              </li>';
              }
            }?>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="add-part">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="<?php echo skin_url("themes/skins/css/style.css");?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/datetimepicker/build/jquery.datetimepicker.min.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/jquery-ui/jquery-ui.min.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/validate/validatefrom.css")?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("themes/skins/css/style.css")?>">
<script type="text/javascript" src="<?php echo skin_url("themes/jquery-ui/jquery-ui.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/tinymce/jquery.tinymce.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/tinymce/tinymce.min.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/filemanager/filemanager.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/validate/validatefrom.js")?>"></script>
<script type="text/javascript" src="<?php echo skin_url("themes/datetimepicker/build/jquery.datetimepicker.full.min.js")?>"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_rQqp15I-s5F0f9gmPp2G3bFeFaeHE1k&libraries=places"></script>
<script type="text/javascript">
  var ramkey = "<?php echo $ramkey;?>";
  var id = $(".modal #box-info-part [name='id']").val();
  var section_id = <?php echo @$post["id"] ? $post["id"] : 0;?>;
  var section_block_id = 0;
  var _this;
  var markers = [];
  var geolocation = {
    lat: 21.028511,
    lng: 105.804817
  };
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
    });
  }
  $("#container-block").sortable({
    connectWith: "#content-list",
  });
  var stop_ui_part = function( event, ui ){
    var p = ui.item.closest(".block-item");
    var part_ids = [];
    var sb_id    = p.attr("data-id");
    $.each(p.find("#list-part .item-part-block"),function(){
      part_ids.push($(this).attr("data-id"));
    });
    $.ajax({
      url : "<?php echo backend_url("themes/blocks/sort")?>",
      type:"post",
      dataType:"json",
      data : {sb : sb_id , items : part_ids,ramkey:ramkey},
      success : function(r){
        //console.log(r);
      },error:function(){

      }
    });
  }
  $("#container-block #list-part").sortable({
    connectWith: "#list-part",
    stop : stop_ui_part
  });
  $(document).on("change","#minbeds", function() {
    var handle = $(this).parent().find( "#custom-handle" );
    handle.text( $(this).val() );
  });
  $.each($("select[value]"),function(){
    $(this).val($(this).attr("value"));
  });
  var beforchoose = function (val){
    var max_file = this.query.max_file;
    var id = $(".modal #box-info-part [name='id']").val();
    $.ajax({
      url  : "<?php echo backend_url("themes/blocks/value_part")?>",
      type : "post",
      dataType : "json",
      data : {id : id},
      success : function(r){
        if(r.status == "success"){
          var html = "";
          var s ="";
          var response = r.response;
          var ids_media = [];
          $.each(val,function(k,v){
            if(max_file > 1){
              s = response.replace("{{value}}",v.thumb);
            }else{
              s = response.replace("{{value}}",v.medium);
            }
            s = s.replace("{{media_id}}",v.id);
            html += '<div data-id="'+v["id"]+'" class="info-item">'+s+'</div>';
          }); 
          if(max_file > 1){
            $(".modal #content-list").append(html);  
          }else{
            $(".modal #data-show-value").html(html); 
          }     
        }
      },error : function(r){
        alert("Error ! Please try again your action");
      }
    });
  }
  var before = function (){
    this.query.max_file = $(".modal #open-file-manage").attr("data-max");
    this.query.type_file = $(".modal #open-file-manage").attr("data-type");
    var length_medias = $(".modal #content-list .info-item").length;
    if(length_medias >= this.query.max_file && this.query.max_file > 1){
      alert("Please select up to "+this.query.max_file+" media file");
      return false;
    }
  }
  function show_data_type() {
    $.each($("#modal-edit-part [data-show]"), function() {
      if ($(this).attr("data-show") == "editer") {
        $(this).tinymce({
          height: 300,
          menubar: false,
          plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
          ],
          toolbar: ' styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        });
      } else if ($(this).attr("data-show") == "datetime") {
        $(this).datetimepicker({
          format: 'd/m/Y H:i',
          formatDate: 'd/m/Y H:i',
        });
      } else if ($(this).attr("data-show") == "day") {
        $(this).datetimepicker({
          timepicker: false,
          format: 'd/m/Y',
          formatDate: 'd/m/Y',
        });
      } else if ($(this).attr("data-show") == "month") {
        $(this).datetimepicker({
          timepicker: false,
          format: 'm',
          formatDate: 'm',
          viewMode: "months"
        });
      } else if ($(this).attr("data-show") == "year") {
        $(this).datetimepicker({
          timepicker: false,
          format: 'Y',
          formatDate: 'Y',
          viewMode: "years",
          minViewMode: "years"
        });
      } else if ($(this).attr("data-show") == "hours") {
        $(this).datetimepicker({
          datepicker: false,
          format: 'H:i',
          formatDate: 'H:i'
        });
      } else if ($(this).attr("data-show") == "map") {
        markers = [];
        var mapdiv = $(this)[0];
        var multiple = parseInt($(this).attr("max-map")) > 1 ? 1 : 0;
        var infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(infowindow, 'closeclick', function(){
          $.each(markers,function(k,v){
            try {
              if(infowindow.position.lat() == v.position.lat() && infowindow.position.lng() == v.position.lng()){
                v.setMap(null);
                markers.splice(k, 1);
                return false;
              }
            }catch(e){

            }         
          });
        });
        var geocoder = new google.maps.Geocoder();
        $(this).parent().parent().prepend('<div class="form-group"><input type="text" name="class_name" class="form-control" id="search-places" value="" placeholder="Enter the place you want to find"></div>');
        var search = $(this).parent().parent().find("#search-places")[0];
        var geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(mapdiv, {
          zoom: 6,
        });
        var marker = new google.maps.Marker({
          position: geolocation,
          map: map,
          visible: false,
          draggable: true
        });
        if($('#modal-edit-part input[name^="map_point"]').length > 0){
          if(multiple == 1){
            $('#modal-edit-part input[name^="map_point"]').each(function(k,v) {
              var vold = $(this).val().replace(/\'/g,'"');
              try{
                var obj = JSON.parse(vold);
                var mk =  new google.maps.Marker({
                  position: obj,
                  map: map,
                  visible: true,
                  draggable: true
                });
                binevent(mk, map, infowindow, geocoder);
                markers.push(mk);
              }catch(e){
                console.log(e);
              }   
            });
          }else{
            var vold = $('#modal-edit-part input[name^="map_point"]').val().replace(/\'/g,'"');
            try{
              var obj = JSON.parse(vold);
              marker.setPosition(obj);
              marker.setVisible(true);
              map.setCenter(obj);
              binevent(marker, map, infowindow, geocoder);
              markers.push(marker);
            }catch(e){}   
          }
        }
        setTimeout(function() {
          google.maps.event.trigger(map, "resize");
          map.setCenter(geolocation);
        }, 200);
        var autocomplete = new google.maps.places.Autocomplete(search, {
          types: ['geocode']
        });
        autocomplete.bindTo('bounds', map);
        map.addListener('click', function(event) {
          infowindow.close();
          if (multiple == 1) {
            var mk = new google.maps.Marker({
              map: map,
              position: event.latLng,
              visible: true,
              draggable: true,
            });
            map.setCenter(event.latLng);
            geocoder.geocode({
              'latLng': event.latLng
            }, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                if (results.length > 0) {
                  infowindow.setContent(results[0].formatted_address);
                } else {
                  infowindow.setContent("Not found");
                }
                infowindow.open(map, mk); 
              }
            });
            markers.push(mk);
            binevent(mk, map, infowindow, geocoder);
          } else {
            marker.setPosition(event.latLng);
            marker.setVisible(true);
            geocoder.geocode({
              'latLng': event.latLng
            }, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                if (results.length > 0) {
                  infowindow.setContent(results[0].formatted_address);
                } else {
                  infowindow.setContent("Not found");
                }
                infowindow.open(map, marker);
              }
            });
            if (markers.length == 0) {
              markers.push(marker);
            }
            binevent(marker, map, infowindow, geocoder);
            
          }
        });
        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
          }
          infowindow.setContent(place.formatted_address);
          if (multiple == 1) {
            var mk = new google.maps.Marker({
              map: map,
              position: place.geometry.location,
              visible: true,
              draggable: true,
            });
            binevent(mk, map, infowindow, geocoder);
            markers.push(mk);
            infowindow.open(map, mk);
          } else {
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
            if (markers.length == 0) {
              markers.push(markers);
            }
            infowindow.open(map, marker);
          }
        });
      }
    });
  }
  function binevent(marker, map, infowindow, geocoder) {
    marker.addListener('click', function() {
      var _this = this;
      infowindow.close();
      geocoder.geocode({
        'latLng': {
          lat: this.position.lat(),
          lng: this.position.lng()
        }
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results.length > 0) {
            infowindow.setContent(results[0].formatted_address);
          } else {
            infowindow.setContent("Not found");
          }
          infowindow.open(map, _this);
        }
      });
      if (_this.getAnimation() !== null) {
        _this.setAnimation(null);
      } else {
        _this.setAnimation(google.maps.Animation.BOUNCE);
      }
      map.setCenter({
        lat: _this.position.lat(),
        lng: _this.position.lng()
      });
    });
    marker.addListener('dragend', function(event) {
      var _this = this;
      infowindow.close();
      geocoder.geocode({
        'latLng': {
          lat: event.latLng.lat(),
          lng: event.latLng.lng()
        }
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results.length > 0) {
            infowindow.setContent(results[0].formatted_address);
          } else {
            infowindow.setContent("Not found");
          }
          infowindow.open(map, _this);   
        }
      });
    });
  }
  $(document).ready(function(){
    $(".block-add-new #add-block").click(function(){
      $("#modal-all-block").modal();
    });
    $(".item-part p").click(function(){
      $(this).parent().toggleClass("active");
    });
    $("#modal-all-block #add-block").click(function(){
      var ids  = [];
      $.each($("#modal-all-block .item-part.active"),function(){
        ids.push($(this).attr("data-id"));
      });
      $.ajax({
        url      : "<?php echo backend_url("themes/sections/add_blocks")?>",
        type     : "post",
        dataType : "json",
        data     : {ids : ids , ramkey : ramkey, section_id : section_id},
        success : function(r){
          if(r.status == "success"){
            $("body #container-block").append(r.response);
            $("#container-block").sortable("refresh");
            try {
              $("#container-block #list-part").sortable("refresh");
            }catch(e){
              $("#container-block #list-part").sortable({
                connectWith: "#list-part",
                stop : stop_ui_part
              });
            }
          }else{
            alert("Error ! Please try again your action");
          } 
        },
        error: function(){
          alert("Error ! Please try again your action");
        }
      });
    });
    $("#modal-all-part #add-part").click(function(){
      var ids  = [];
      $.each($("#modal-all-part .item-part.active"),function(){
        ids.push($(this).attr("data-id"));
      });
      var sort = $("#container-block .block-item[data-id = "+section_block_id+"] .item-part-block").length;
      $.ajax({
        url      : "<?php echo backend_url("themes/sections/add_parts")?>",
        type     : "post",
        dataType : "json",
        data     : {ids : ids ,section_block_id : section_block_id ,ramkey : ramkey,sort:sort},
        success : function(r){
          console.log(r);
          if(r.status == "success"){
            $("#container-block .block-item[data-id="+section_block_id+"] .wrapper-block #list-part").append(r.response);
            try {
              $("#container-block #list-part").sortable("refresh");
            }catch(e){
              $("#container-block #list-part").sortable({
                connectWith: "#list-part",
                stop : stop_ui_part
              });
            }
          }else{
            alert("Error ! Please try again your action");
          } 
        },
        error: function(){
          alert("Error ! Please try again your action");
        }
      });
    });
  });
  $(document).on("click","#container-block #support_part #edit-part",function(){
    var info_box = $(this).closest(".item-part-block");
    var id = info_box.attr("data-id");
    section_block_id = info_box.closest(".block-item").attr("data-id");
    if(id){
      $("#modal-edit-part").modal();
      $.ajax({
        url : "<?php echo backend_url("themes/blocks/update_part_block")?>",
        type:"post",
        dataType:"json",
        data:{id:id,ramkey : ramkey, section_block_id : section_block_id},
        success : function(r){
          $("#edit-part-form .modal-body").html(r.response);
          var select = $("#edit-part-form .modal-body #minbeds");
          var slider = $( "<div id='slider'><div id='custom-handle' class='ui-slider-handle'></div></div>" ).insertAfter( select ).slider({
            min: 1,
            max: 12,
            range: "min",
            value : $("#edit-part-form .modal-body #minbeds").val(),
            slide: function( event, ui ) {
              select.val (ui.value);
              select.change();
            }
          }); 
          $("#edit-part-form .modal-body #custom-handle" ).text($("#edit-part-form .modal-body #minbeds").val()); 
          var filemanager = $("#edit-part-form #open-file-manage").Scfilemanagers({
            base_url : "<?php echo base_url();?>",
            before   : before,
            beforchoose : beforchoose,
            after : function (){
              $("body").addClass("modal-open");
            }     
          });
          $("#edit-part-form #content-list").sortable({
            connectWith: "#content-list",
          });
          show_data_type();
        },
        error : function(r){
          alert("Error ! Please try again your action");
        }
      })
    }
  });
  $(document).on("click","#container-block #support_part #delete-part",function(){
    var c = confirm("Are you want delete it!");
    if(c){
      section_block_id =  $(this).closest(".block-item").attr("data-id");
      var part_id      =  $(this).closest(".item-part-block").attr("data-id");
      if(section_block_id){
        $.ajax({
          url : "<?php echo backend_url("themes/sections/delete_part")?>",
          type:"post",
          dataType:"json",
          data:{part_id : part_id,section_block_id:section_block_id,$theme_id : 0},
          success : function(r){
            if(r.status == "success"){
              var id = r.post.part_id ;
              $("#container-block .item-part-block[data-id ="+id+"]").remove(); 
            }else{
              alert("Error ! Please try again your action");
            }  
          },
          error : function(r){
            alert("Error ! Please try again your action");
          }
        });
      }
    }
  });
  $(document).on("click","#container-block #support_block #edit-block",function(){
    section_block_id =  $(this).closest(".block-item").attr("data-id");
    if(section_block_id){
      $("#modal-edit-block").modal();
      $.ajax({
        url : "<?php echo backend_url("themes/sections/edit_block")?>",
        type:"post",
        dataType:"json",
        data:{id:section_block_id},
        success : function(r){
          $("#modal-edit-block .modal-body").html(r.response);
          var select = $("#modal-edit-block .modal-body #minbeds");
          var slider = $( "<div id='slider'><div id='custom-handle' class='ui-slider-handle'></div></div>" ).insertAfter( select ).slider({
            min: 1,
            max: 12,
            range: "min",
            value : $("#modal-edit-block .modal-body #minbeds").val(),
            slide: function( event, ui ) {
              select.val (ui.value);
              select.change();
            }
          }); 
          $("#modal-edit-block .modal-body #custom-handle" ).text($("#modal-edit-block .modal-body #minbeds").val()); 
          var filemanager = $("#modal-edit-block #open-file-manage").Scfilemanagers({
            base_url : "<?php echo base_url();?>",
            before   : before,
            beforchoose : beforchoose,
            after : function (){
              $("body").addClass("modal-open");
            }     
          });
          $("#modal-edit-block #content-list").sortable({
            connectWith: "#content-list",
          });
          show_data_type();
        },
        error : function(r){
          alert("Error ! Please try again your action");
        }
      })
    }
  });
  $(document).on("click","#container-block #support_block #delete-block",function(){
    var c = confirm("Are you want delete it!");
    if(c){
      section_block_id =  $(this).closest(".block-item").attr("data-id");
      if(section_block_id){
        $.ajax({
          url : "<?php echo backend_url("themes/sections/delete_block")?>",
          type:"post",
          dataType:"json",
          data:{id:section_block_id,$theme_id : 0},
          success : function(r){
            if(r.status == "success"){
              var id = r.post.id ;
              $("#container-block .block-item[data-id ="+id+"]").remove(); 
            }else{
              alert("Error ! Please try again your action");
            }  
          },
          error : function(r){
            alert("Error ! Please try again your action");
          }
        });
      }
    }
  });
  $(document).on("click","#container-block #support_block #add-part",function(){
    section_block_id =  $(this).closest(".block-item").attr("data-id");
    $("#modal-all-part").modal();
  });
  $(document).on("submit","#modal-edit-part #edit-part-form",function(){
    if($(this).find("#box-info-part #is_part").val() == "map" || $(this).find("#box-info-part #is_part").val() == "maps"){
      try{
        var r = $($(this).find("#box-info-part #valuestring").val());
        var h = $("<div></div>");
        if(markers.length > 0){
          $.each(markers,function(k,v){
            r.val("{'lat': "+v.position.lat()+",'lng' : "+v.position.lng()+"}");
            h.append(r.clone());
          });
        }
        $("#modal-edit-part #content-list").html(h.html());
      }catch(e){
        console.log(e)
      } 
    }
    var data = $(this).serialize();
    data+="&ramkey="+ramkey+"&section_block_id="+section_block_id+""; 
    $.ajax({
      url : "<?php echo backend_url("themes/blocks/save_block_part");?>",
      type:"post",
      data : data,
      dataType : "json",
      success : function(r){
        if(r.status == "success"){
          var id = r.post.id ;
          console.log(section_block_id);
          var c  = $("#container-block .block-item[data-id ="+section_block_id+"] .item-part-block[data-id ="+id+"]").attr("class");
          var cl = $("#container-block .block-item[data-id ="+section_block_id+"] .item-part-block[data-id ="+id+"]").attr("data-colum");
          c = c.replace(cl,r.post.minbeds);
          $("#container-block .block-item[data-id ="+section_block_id+"] .item-part-block[data-id ="+id+"]").attr("class",c);
          $("#container-block .block-item[data-id ="+section_block_id+"] .item-part-block[data-id ="+id+"]").attr("data-colum",r.post.minbeds);
          $("#modal-edit-part").modal("hide");
        }else{
          alert("Error ! Please try again your action");
        }   
      },error : function(e){
        console.log(e);
      }
    });
    return false;
  });
  $(document).on("submit","#modal-edit-block #edit-block-form",function(){
    var data = $(this).serialize();
    $.ajax({
      url : "<?php echo backend_url("themes/sections/save_block");?>",
      type:"post",
      data : data,
      dataType : "json",
      success : function(r){
        if(r.status == "success"){
          var id = r.post.id ;
          var c  = $("#container-block .block-item[data-id ="+id+"]").attr("class");
          var cl = $("#container-block .block-item[data-id ="+id+"]").attr("data-colum");
          c = c.replace(cl,r.post.minbeds);
          $("#container-block .block-item[data-id ="+id+"]").attr("class",c);
          $("#container-block .block-item[data-id ="+id+"]").attr("data-colum",r.post.minbeds);
          $("#modal-edit-block").modal("hide");
        }else{
          alert("Error ! Please try again your action");
        }        
      },error : function(e){
        console.log(e);
      }
    });
    return false;
  });
  $("#modal-edit-part,#modal-edit-block").on("hidden.bs.modal",function(){
    $.each($("#modal-edit-part [data-show]"),function(){
      if($(this).attr("data-show") == "editer"){
        $(this).tinymce().remove();
      }else if($(this).attr("data-show") == "datetime" || $(this).attr("data-show") == "day" || $(this).attr("data-show") == "month" || $(this).attr("data-show") == "year" || $(this).attr("data-show") == "hours"){
        $(this).datetimepicker('destroy');
      }
    });
    $(this).find(".modal-body").html("");
  });
</script>
