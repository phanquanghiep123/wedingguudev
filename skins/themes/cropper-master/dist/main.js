$(function() {
  'use strict';
  var console = window.console || {
    log: function() {}
  };
  var URL = window.URL || window.webkitURL;
  var $image = $('#image');
  var $download = $('#download');
  var $dataX = $('#dataX');
  var $dataY = $('#dataY');
  var $dataHeight = $('#dataHeight');
  var $dataWidth = $('#dataWidth');
  var $dataRotate = $('#dataRotate');
  var $dataScaleX = $('#dataScaleX');
  var $dataScaleY = $('#dataScaleY');
  var $inputImage = $('#inputImage');
  var $_sti = 0;
  var options = {
    autoCropArea: "100%",
    resizable: false,
    autoCrop: false,
    preview: '.img-preview',
    crop: function(e) {
      if($_sti > 0){
        $dataX.val(Math.round(e.x));
        $dataY.val(Math.round(e.y));
        $dataHeight.val(Math.round(e.height));
        $dataWidth.val(Math.round(e.width));
        $dataRotate.val(e.rotate);
        $dataScaleX.val(e.scaleX);
        $dataScaleY.val(e.scaleY);
      } 
    },
  };
  var originalImageURL = $image.attr('src');
  var uploadedImageType = 'image/jpeg';
  var uploadedImageURL;
  // Tooltip
  $('[data-toggle="tooltip"]').tooltip();
  // Cropper
  $('#modal-edit-media').on('shown.bs.modal', function() {
    var _this = $(this);
    $image = _this.find("#image");
    $dataX = _this.find('#dataX');
    $dataY = _this.find('#dataY');
    $dataHeight = _this.find('#dataHeight');
    $dataWidth = _this.find('#dataWidth');
    $dataRotate = _this.find('#dataRotate');
    $dataScaleX = _this.find('#dataScaleX');
    $dataScaleY = _this.find('#dataScaleY');
    $inputImage = _this.find('#inputImage');
    $image.on({
      ready: function(e) {
        _this.find("#is-change").val(1);
      },
      cropstart: function(e) {
        
        $_sti ++; 
      },
      cropmove: function(e) {
      },
      cropend: function(e) {
      },
      crop: function(e) {
      },
      zoom: function(e) {
      }
    }).cropper(options);
  }).on('hidden.bs.modal', function() {
    $image.cropper('destroy');
    $_sti = 0;
    $("#modal-edit-media .modal-body").html("");
  });
  $(document).on("submit",".edit-from #save-edit", function() {
    var canvasData = null;
    try {
      if ($image.cropper("isCropped")) {
        canvasData = $image.cropper("getCroppedCanvas");
      } else {
        canvasData = $image.cropper("getSourceCanvas");
      }
      if(canvasData != null){
        var imageData = canvasData.toDataURL();
        $(this).find("#base64image").val(imageData);
      }
    } catch (v) {
    }
    addloadding();
    var name = $(this).find("#media-name").val();
    if(name == null) {alert("Please enter name"); return false;}
    var imgbase64 = $(this).find("#base64image").val();
    var id = $(this).find("#media-id").val();
    var type = $(this).find("#media-type").val();
    var is_change = $(this).find("#is-change").val();
    var extension = $(this).find("#media-extension").val();
    var size = $("#modal-edit-media #media-size").val();
    var content = $("#content-file").val();
    $.ajax({
      url      : base_url + "filemanager/save_edit",
      type     : "post",
      dataType :"json",
      data     : {
        id : id,
        type : type,
        name : name, 
        imgbase64: imgbase64,
        is_change:is_change,
        extension:extension,
        size:size,
        content:content
      },
      success  : function(r){
        if(r.status == "success"){
          $image.cropper('destroy').attr('src', r.record.path).cropper(options);
          var i = Math.floor( Math.log(r.record.size) / Math.log(1024) );
          var sizefile = ( r.record.size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' ;
          $("#modal-edit-media #dataSize").val(sizefile);
          $("#modal-edit-media #dataSize").parent().find(".input-group-addon").last().text(['B', 'kB', 'MB', 'GB', 'TB'][i]);
          $('#contaner-media #contaner-item[data-id='+id+']').html(r.response);
          if(r.get_type.name != "image"){
            if(r.get_type.name == "folder"){
              var node = zTree.getNodeByParam('id',id);
              if(node != null){
                node.name = name;
                zTree.updateNode(node);
              } 
            }
            $("#modal-edit-media-not-img").modal("hide");
          }
        }else{
          if(r.message != null){
             alert("Error ! "+r.message+"");
          }else{
            alert("Error ! Please try again your action");
          }  
        }
        remove_loadding();
      },
      error : function(e){
        console.log(e);
        alert("Error ! Please try again your action");
        remove_loadding();
      }
    });
    $_sti = 0;
    return false;
  });
  // Buttons
  if (!$.isFunction(document.createElement('canvas').getContext)) {
    $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
  }
  if (typeof document.createElement('cropper').style.transition === 'undefined') {
    $('button[data-method="rotate"]').prop('disabled', true);
    $('button[data-method="scale"]').prop('disabled', true);
  }
  // Options
  $(document).on('change', '.docs-toggles input', function() {
    var $this = $(this);
    var name = $this.attr('name');
    var type = $this.prop('type');
    var cropBoxData;
    var canvasData;
    if (!$image.data('cropper')) {
      return;
    }
    if (type === 'checkbox') {
      options[name] = $this.prop('checked');
      cropBoxData = $image.cropper('getCropBoxData');
      canvasData = $image.cropper('getCanvasData');
      options.ready = function() {
        $image.cropper('setCropBoxData', cropBoxData);
        $image.cropper('setCanvasData', canvasData);
      };
    } else if (type === 'radio') {
      options[name] = $this.val();
    }
    $image.cropper('destroy').cropper(options);
  });
  // Methods
  $(document).on('click', '.docs-buttons [data-method]', function() {
    var $this = $(this);
    var data = $this.data();
    var cropper = $image.data('cropper');
    var cropped;
    var $target;
    var result;
    if ($this.prop('disabled') || $this.hasClass('disabled')) {
      return;
    }
    if (cropper && data.method) {
      data = $.extend({}, data); // Clone a new one
      if (typeof data.target !== 'undefined') {
        $target = $(data.target);
        if (typeof data.option === 'undefined') {
          try {
            data.option = JSON.parse($target.val());
          } catch (e) {
            console.log(e.message);
          }
        }
      }
      cropped = cropper.cropped;
      switch (data.method) {
        case 'rotate':
          if (cropped && options.viewMode > 0) {
            $image.cropper('clear');
          }
          break;
        case 'getCroppedCanvas':
          if (uploadedImageType === 'image/jpeg') {
            if (!data.option) {
              data.option = {};
            }
            data.option.fillColor = '#fff';
          }
          break;
      }
      result = $image.cropper(data.method, data.option, data.secondOption);
      switch (data.method) {
        case 'rotate':
          if (cropped && options.viewMode > 0) {
            $image.cropper('crop');
          }
          break;
        case 'scaleX':
        case 'scaleY':
          $(this).data('option', -data.option);
          break;
        case 'getCroppedCanvas':
          if (result) {
            // Bootstrap's Modal
            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
            if (!$download.hasClass('disabled')) {
              $download.attr('href', result.toDataURL(uploadedImageType));
            }
          }
          break;
        case 'destroy':
          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
            uploadedImageURL = '';
            $image.attr('src', originalImageURL);
          }
          break;
      }
      if ($.isPlainObject(result) && $target) {
        try {
          $target.val(JSON.stringify(result));
        } catch (e) {
          console.log(e.message);
        }
      }
    }
  });
  // Keyboard
  $(document.body).on('keydown', function(e) {
    if (!$image.data('cropper') || this.scrollTop > 300) {
      return;
    }
    switch (e.which) {
      case 37:
        e.preventDefault();
        $image.cropper('move', -1, 0);
        break;
      case 38:
        e.preventDefault();
        $image.cropper('move', 0, -1);
        break;
      case 39:
        e.preventDefault();
        $image.cropper('move', 1, 0);
        break;
      case 40:
        e.preventDefault();
        $image.cropper('move', 0, 1);
        break;
    }
  });
  // Import image
  if (URL) {
    $(document).on("change", "#modal-edit-media #inputImage", function() {
      var files = this.files;
      var file;
      if (!$image.data('cropper')) {
        return;
      }
      if (files && files.length) {
        file = files[0];
        if (/^image\/\w+$/.test(file.type)) {
          uploadedImageType = file.type;
          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
          }
          var url = URL.createObjectURL(this.files[0]);

          uploadedImageURL = URL.createObjectURL(file);
          $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
          $inputImage.val('');
          var exe = file.name.replace(/^.*\./, '');
          $("#modal-edit-media #media-extension").val(exe);
          $("#modal-edit-media #media-name").val(file.name);
          $("#modal-edit-media #media-size").val(file.size);
          $("#modal-edit-media  #is-change").val(1);
          var i = Math.floor( Math.log(file.size) / Math.log(1024) );
          var sizefile = ( file.size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' ;
          $("#modal-edit-media #dataSize").val(sizefile);
          $("#modal-edit-media #dataSize").parent().find(".input-group-addon").last().text(['B', 'kB', 'MB', 'GB', 'TB'][i]);
          var img = new Image;
          img.onload = function() {
              $("#modal-edit-media #dataWidth").val(img.width);
              $("#modal-edit-media #dataHeight").val(img.height);
          };
          img.src = url;
        } else {
          window.alert('Please choose an image file.');
        }
      }
    });
  } else {
    $inputImage.prop('disabled', true).parent().addClass('disabled');
  }
});