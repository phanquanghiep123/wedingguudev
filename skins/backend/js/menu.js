$(document).on('click','.delete-menu', function(){
    var li_current = $(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    var id = li_current.find('#menu_id').val();
    if(confirm('Bạn có thật sự muốn xóa?')){
        $(".custom-loading").show();
        $.ajax({
          type: 'POST',
          url: base_url+'backend/menu/delete_menu_item/'+id,
          data:{},
          success: function(data) {
            if(data=='true'){
                li_current.fadeOut(800,function(){
                    $(this).remove();
                });
            }       
          },
          error: function(data){
              console.log(data['responseText']);
          },
          complete:function(){
             $(".custom-loading").hide();
          }
        });
    }
    return false;
});

//edit menu item
$(document).on('click','.edit-menu',function(){
    var li_current = $(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    var id=li_current.find('#menu_id').val();
    $('#edit-id').val(id);
    $(".custom-loading").show();
    $.ajax({
        type: 'POST',
        dataType:'json',
        url: base_url + "backend/menu/get_item_menu/"+id,
        data:{},
        success: function(data) {
           console.log(data);
           $('#edit-title').val(data.Name);
           $('#edit-url').val(data.Url);
           $('#edit-class').val(data.Class);
           if(data.Type == '_blank'){
               $('#edit-target').prop('checked', true);
           }
           else{
               $('#edit-target').prop('checked', false);
           }
           $('#editModal').modal('show');
        },
        error: function(data){
            console.log(data['responseText']);
        },
        complete:function(){
            $(".custom-loading").hide();
        }
    });
    return false;
});

//save edit menu
$(document).on('click','.btn-edit',function(){
    var title = $('#edit-title').val();
    var url = $('#edit-url').val();
    var clas = $('#edit-class').val();
    var type ;
    type = $('#editModal #edit-target').is(':checked')  ? '_blank' : 'inner';
    var id = $('#edit-id').val();
    var bool = true;
    if (title.trim()=='' || title.trim()==null) {
        bool = false;
        $('#edit-title').addClass('border-error');
    } else {
        $('#edit-title').removeClass('border-error');
    }

    if(url.trim()=='' || url.trim()==null){
        bool = false;
        $('#edit-url').addClass('border-error');
    }
    else{
        $('#edit-url').removeClass('border-error');
    }

    if(bool){
        $('#editModal .image-load').show();
        $(this).attr('disabled','disabled');
        $.ajax({
            type: 'POST',
            url: base_url+'backend/menu/update_item_menu/'+id,
            data:{"title":title,"url":url,"class":clas,"type":type},
            success: function(data) {
                var li = $('#menu-'+id);
                li.find(' > .ns-row > .ns-title').html(title);
                li.find(' > .ns-row > .ns-url').html(url);
                li.find(' > .ns-row > .ns-class').html(clas);
                $('#edit-title').val('');
                $('#edit-url').val('');
                $('#edit-class').val('');
                $('#edit-target').attr('checked', false);
            },
            error: function(data){
                console.log(data['responseText']);
            },
            complete:function(){
                $('.btn-edit').removeAttr('disabled');
                $('#editModal .image-load').hide();
                $('#editModal .btn-close').trigger('click');
            }
        });
    }
    return false;
});

$(document).on('submit','.item-collaps form',function(){
    var current = $(this);
    $(".custom-loading").show();
    var data = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: base_url+'backend/menu/search_item/',
        data: data,
        dataType:'json',
        success: function(data) {
            //console.log(data);
            if(data['status'] == 'success'){
                //current.find('input[name="keyword"]').val('');
                current.find('.list-item').html(data['responsive']);
            }
        },
        complete:function(){
            $(".custom-loading").hide();
        }
    });
    return false;
});