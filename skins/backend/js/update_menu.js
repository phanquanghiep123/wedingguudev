$(document).ready(function(){
    var js_menu = $.noConflict();
    var menu_serialized;
    var fixSortable = function() {
        if (!js_menu.browser.msie) return;
        //this is fix for ie
        js_menu('#easymm').NestedSortableDestroy();
        js_menu('#easymm').NestedSortable({
            accept: 'sortable',
            helperclass: 'ns-helper',
            opacity: .8,
            handle: '.ns-title',
            onStop: function() {
                fixSortable();
            },
            onChange: function(serialized) {
                menu_serialized = serialized[0].hash;
                $('#btn-save-menu').attr('disabled', false);
            }
        });
    };
    js_menu('#easymm').NestedSortable({
        accept: 'sortable',
        helperclass: 'ns-helper',
        opacity: .8,
        handle: '.ns-title',
        onStop: function() {
            fixSortable();
        },
        onChange: function(serialized) {
            menu_serialized = serialized[0].hash;
            $('#btn-save-menu').attr('disabled', false);
        }
    });

    //add menu item
    $('#add-menu').click(function(){
        var title = $('#add-title').val();
        var url = $('#add-url').val();
        var clas = $('#add-class').val();
        var type ;
        type = $('#add-target').is(':checked') ? '_blank' : 'inner';
        var bool = true;
        if(title.trim() =='' || title.trim() == null){
            bool=false;
            $('#add-title').addClass('border-error');
        }
        else{
            $('#add-title').removeClass('border-error');
        }

        if(url.trim()=='' || url.trim() == null){
            bool=false;
            $('#add-url').addClass('border-error');
        }
        else{
            $('#add-url').removeClass('border-error');
        }

        if(bool){
            $('#form-add-menu .image-load').show();
            $(this).attr('disabled','disabled');
            $.ajax({
              type: 'POST',
              url: base_url+'backend/menu/add_item_menu/',
              data:{"title":title,"url":url,"class":clas,"type":type,"group_id":group_id},
              success: function(data) {
                    if(parseInt(data)>0){
                        var html='<li id="menu-'+parseInt(data)+'" class="sortable">';
                            html+='       <div class="ns-row">';
                            html+='            <div class="ns-title">'+title+'</div>';
                            html+='            <div class="ns-url">'+url+'</div>';
                            html+='            <div class="ns-class">'+clas+'</div>';
                            html+='            <div class="ns-actions">';
                            html+='               <a href="#" class="edit-menu" data-toggle="modal" data-target="#editModal">Chỉnh sửa</a> | ';
                            html+='               <a href="#" class="delete-menu">Xóa</a>';
                            html+='               <input type="hidden" id="menu_id" name="menu_id" value="'+parseInt(data)+'">';
                            html+='            </div>';
                            html+='         </div>';
                            html+='   </li>';
                        js_menu('#easymm').append(html).SortableAddItem($('#menu-'+parseInt(data))[0]);
                        $('#add-title').val('');
                        $('#add-url').val('');
                        $('#add-class').val('');
                        $('#add-target').attr('checked', false);
                    }
              },
              error: function(data){
                    console.log(data['responseText']);
              },
              complete:function(){
                    $('#add-menu').removeAttr('disabled');
                    $('#form-add-menu .image-load').hide();
              }
            });
        }
    });

    $('.item-collaps form .add-menu-list').on('click',function(){
        var current = $(this);
        var numberOfChecked = $(this).parents('form').find('input[type="checkbox"]:checked').length;
        if(numberOfChecked > 0){
            $(".custom-loading").show();
            var data = $(this).parents('form').serialize();
            $.ajax({
              type: 'POST',
              url: base_url+'backend/menu/add_list_item_menu/',
              data: data,
              dataType:'json',
              success: function(data) {
                    if(data['status'] == 'success'){
                        var responsive = data['responsive'];
                        for (var i = 0; i < responsive.length; i++) {
                            var menu_id = parseInt(responsive[i]['menu_id']);
                            var html='<li id="menu-'+ menu_id +'" class="sortable">';
                                html+='       <div class="ns-row">';
                                html+='            <div class="ns-title">' + responsive[i]['title'] + '</div>';
                                html+='            <div class="ns-url">' + responsive[i]['url'] + '</div>';
                                html+='            <div class="ns-class"></div>';
                                html+='            <div class="ns-actions">';
                                html+='               <a href="#" class="edit-menu" data-toggle="modal" data-target="#editModal">Chỉnh sửa</a>';
                                html+='               <a href="#" class="delete-menu">Xóa</a>';
                                html+='               <input type="hidden" id="menu_id" name="menu_id" value="'+ menu_id +'">';
                                html+='            </div>';
                                html+='         </div>';
                                html+='   </li>';
                            js_menu('#easymm').append(html).SortableAddItem($('#menu-' + menu_id)[0]);
                        }
                        current.parents('form').find('input[type="checkbox"]:checked').each(function(){
                             $(this).attr('checked', false);
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

    /*Update position menu item*/
    $('#btn-save-menu').click(function() {
          //console.log(menu_serialized);
          $('#ns-footer .image-load').show();
          $(this).attr('disabled','disabled');
          $('.custom-loading').show();
          $.ajax({
            type: 'POST',
            url: base_url + 'backend/menu/update_menu',
            data: menu_serialized,
            success: function(data) {
                //alert(data);
                if(data == 'true'){
                    
                }   
            },
            error: function(data){
                console.log(data['responseText']);
            },
            complete:function(){
                $('#btn-save-menu').removeAttr('disabled');
                $('#ns-footer .image-load').hide();
                $('.custom-loading').hide();
                location.reload();
            }
          });
          return false;
    });
});