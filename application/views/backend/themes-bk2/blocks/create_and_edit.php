<?php 
  $actions = $post["actions"];
  $html_action = "<ul class='action-list'>";
  foreach ($actions as $key => $value) {
    $html_action .='<li><div class="checkbox">
      <label><input id="action-item" type="checkbox" value="'.$value["id"].'">'.$value["name"].'</label>
    </div></li>';
  }
  $html_action .= "</ul>";
  $ramkey = uniqid();
?>
<div class="main-page <?php echo @$main_page;?>">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><?php echo (@$post["html_edit"]) ? "Edit ": "Add new "?> theme block</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
        </ul>
        <div class="clearfix"></div>
      </div>
    <div class="x_content">
      <form method="post" action="<?php echo ($action_save)?>">
        <div class="form-group">
          <label for="name" class="col-sm-4 col-form-label">Tên phần</label>
          <div class="col-sm-8">
            <input type="text" name="name" class="form-control" id="name" value="<?php echo @$post["name"]?>" required="required">
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
          <label for="is_form" class="col-sm-4 col-form-label">Là một form</label>
          <div class="col-sm-8">
            <select id="is_form" name="is_form" value="<?php echo @$post["is_form"]?>" class="form-control">
              <option value="">--chọn trạng thái--</option>
              <option value="0">không</option>
              <option value="1">có</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="status" class="col-sm-4 col-form-label">Trạng thái</label>
          <div class="col-sm-8">
            <select id="status" name="status" value="<?php echo @$post["status"]?>" class="form-control" required="required"> 
              <option value="1" selected="selected">hiện</option>
              <option value="0">ẩn</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <div class="content-left">
              <div class="list-parts">
                <ul class="nav-parts">
                  <?php if(@$post["parts"] != null){
                    foreach ($post["parts"] as $key => $value) {
                      echo '<li class="item-part" data-id="'.$value["id"].'" >
                        <p data-id="'.$value["id"].'">'.$value["name"].'</p>
                        <a href="javascript:;" data-id="'.$value["id"].'" id="add-new-item" class="add-item bnt btn btn-success"> + add</a>
                      </li>';
                    }
                  }?>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-9">
            <div class="content-right">
              <div class="content-show-parts">
                <h3 class="text-center">Block content</h3>
                <div class="row"><div id="container-block">
                  <?php if(@$my_parts != null){
                    foreach ($my_parts as $key => $value) {
                      echo '
                      <div data-colum="'.$value["ncolum"].'" data-id="'.$value["block_part_id"].'" class="item-part-block col-md-'.$value["ncolum"].' ui-sortable-handle">
                        <div class="block-part">
                          <h3 class="title-block">'.$value["name"].'</h3>
                          <div id="box-info-part">
                            <input name="id" value="'.$value["block_part_id"].'" type="hidden">
                            <input name="ids[]" value="'.$value["block_part_id"].'" type="hidden">
                          </div>
                          <div class="menu-action" id="support_part">
                            <ul class="menu-block"> 
                              <li><a href="javascript:;" id="edit-part"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                              <li><a href="javascript:;" id="delete-part"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>';
                    }
                  }?>
                </div></div>
                <input type="hidden" name="ramkey" value="<?php echo $ramkey?>">
              </div>
              <?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
            </div>
          </div>
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
  var beforchoose = function beforchoose(val) {
    var max_file = this.query.max_file;
    var id = $("#modal-edit-part #box-info-part [name='id']").val();
    $.ajax({
      url: "<?php echo backend_url("themes/blocks/value_part")?>",
      type: "post",
      dataType: "json",
      data: {
        id: id
      },
      success: function(r) {
        if (r.status == "success") {
          var html = "";
          var s = "";
          var response = r.response;
          var ids_media = [];
          $.each(val, function(k, v) {
            if (max_file > 1) {
              s = response.replace("{{value}}", v.thumb);
            } else {
              s = response.replace("{{value}}", v.medium);
            }
            s = s.replace("{{media_id}}", v.id);
            html += '<div data-id="' + v["id"] + '" class="info-item">' + s + '</div>';
          });
          if (max_file > 1) {
            $("#modal-edit-part #content-list").append(html);
          } else {
            $("#modal-edit-part #data-show-value").html(html);
          }
        }
      },
      error: function(r) {
      }
    });
  }
  var before = function before() {
    this.query.max_file = $("#modal-edit-part #open-file-manage").attr("data-max");
    this.query.type_file = $("#modal-edit-part #open-file-manage").attr("data-type");
    var length_medias = $("#modal-edit-part #content-list .info-item").length;
    if (length_medias >= this.query.max_file && this.query.max_file > 1) {
      alert("Please select up to " + this.query.max_file + " media file");
      return false;
    }
  }
  $(document).on("change", "#minbeds", function() {
    var handle = $(this).parent().find("#custom-handle");
    handle.text($(this).val());
  });
  $("#container-block").sortable({
    connectWith: "#container-block",
  });
  $.each($("#slider-numcolumn #minbeds"), function() {
    var select = $(this);
    var slider = $("<div id='slider'><div id='custom-handle' class='ui-slider-handle'></div></div>").insertAfter(select).slider({
      min: 1,
      max: 12,
      range: "min",
      value: 6,
      slide: function(event, ui) {
        select.val(ui.value);
        select.change();
      }
    });
    $(this).parent().find("#custom-handle").text(6);
  });
  $(document).on("click", ".list-parts .item-part p", function() {
    $(this).closest("li").toggleClass("open");
  });
  $(document).on("click", ".list-parts #add-new-item", function() {
    var id = $(this).attr("data-id");
    var c = 6;
    var sort = $("#container-block .item-ui").length;
    var a = [];
    $.each($(this).parent().find(".action-list #action-item:checked"), function() {
      a.push($(this).val());
    });
    if (id) {
      $("#modal-edit-part").modal();
      $.ajax({
        type: "post",
        dataType: "json",
        url: "<?php echo backend_url("themes/parts/get");?>",
        data: {
          id: id,
          column: c,
          actions: a,
          ramkey: ramkey,
          sort: sort
        },
        success: function(r) {
          if (r.status == "success") {
            $(".content-right .content-show-parts #container-block").append(r.response);
            $("#modal-edit-part .modal-body").html(r.modal);
            var select = $("#modal-edit-part .modal-body #minbeds");
            var slider = $("<div id='slider'><div id='custom-handle' class='ui-slider-handle'></div></div>").insertAfter(select).slider({
              min: 1,
              max: 12,
              range: "min",
              value: $("#modal-edit-part .modal-body #minbeds").val(),
              slide: function(event, ui) {
                select.val(ui.value);
                select.change();
              }
            });
            $("#modal-edit-part .modal-body #custom-handle").text($("#modal-edit-part .modal-body #minbeds").val());
            var filemanager = $("#modal-edit-part #open-file-manage").Scfilemanagers({
              base_url: "<?php echo base_url();?>",
              before: before,
              beforchoose: beforchoose,
              after: function() {
                $("body").addClass("modal-open");
              }
            });
            $("#container-block").sortable("refresh");
            show_data_type();
          } else {
            alert("Error ! Please try again your action");
          }
        },
        error: function(e) {
          alert("Error ! Please try again your action");
        }
      })
    }
  });
  $(document).on("click", "#container-block .block-part #edit-part", function() {
    var info_box = $(this).closest(".block-part").find("#box-info-part");
    var id = info_box.find("[name='id']").val();
    if (id) {
      $("#modal-edit-part").modal();
      $.ajax({
        url: "<?php echo backend_url("themes/blocks/update_part_block")?>",
        type: "post",
        dataType: "json",
        data: {
          id: id
        },
        success: function(r) {
          $("#modal-edit-part .modal-body").html(r.response);
          var select = $("#modal-edit-part .modal-body #minbeds");
          var slider = $("<div id='slider'><div id='custom-handle' class='ui-slider-handle'></div></div>").insertAfter(select).slider({
            min: 1,
            max: 12,
            range: "min",
            value: $("#modal-edit-part .modal-body #minbeds").val(),
            slide: function(event, ui) {
              select.val(ui.value);
              select.change();
            }
          });
          $("#modal-edit-part .modal-body #custom-handle").text($("#modal-edit-part .modal-body #minbeds").val());
          var filemanager = $("#modal-edit-part #open-file-manage").Scfilemanagers({
            base_url: "<?php echo base_url();?>",
            before: before,
            beforchoose: beforchoose,
            after: function() {
              $("body").addClass("modal-open");
            }
          });
          $("#modal-edit-part #content-list").sortable({
            connectWith: "#content-list",
          });
          show_data_type();
        },
        error: function(r) {
          console.log(r);
        }
      })
    }
  });
  $(document).on("submit", "#modal-edit-part #edit-part-form", function() {
    //check is map
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
    $.ajax({
      url: "<?php echo backend_url("themes/blocks/save_block_part");?>",
      type: "post",
      data: data,
      dataType: "json",
      success: function(r) {
        if (r.status == "success") {
          var id = r.post.id;
          var c = $("#container-block .item-part-block[data-id =" + id + "]").attr("class");
          var cl = $("#container-block .item-part-block[data-id =" + id + "]").attr("data-colum");
          c = c.replace(cl, r.post.minbeds);
          $("#container-block > div[data-id =" + id + "]").attr("class", c);
          $("#container-block > div[data-id =" + id + "]").attr("data-colum", r.post.minbeds);
        }
        $("#modal-edit-part").modal("hide");
      },
      error: function(e) {
        console.log(e);
      }
    });
    return false;
  });
  $(document).on("click", "#content-list .item-list .delete-item", function() {
    var p = $(this).closest(".block-part");
    $(this).closest(".info-item").remove();
  });
  $(document).on("click", "#container-block .item-part-block #delete-part", function() {
    $(this).closest(".item-part-block").remove();
  });
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
  $("#modal-edit-part").on("hidden.bs.modal", function() {
    $.each($("#modal-edit-part [data-show]"), function() {
      if ($(this).attr("data-show") == "editer") {
        $(this).tinymce().remove();
      } else if ($(this).attr("data-show") == "datetime" || $(this).attr("data-show") == "day" || $(this).attr("data-show") == "month" || $(this).attr("data-show") == "year" || $(this).attr("data-show") == "hours") {
        $(this).datetimepicker('destroy');
      }
    });
    $(this).find(".modal-body").html("");
  });
  $.each($("select[value]"), function() {
    $(this).val($(this).attr("value"));
  });
</script>
