$(function () {
    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var first = true;
    var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();
    var events_json = null;
    var by = 'other';
    var paging  = 2;
    var total = 0;
    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month'
        },
        //Random default events
        events: [],
        editable: false,
        droppable: false,
        eventLimit: true,
        navLinks: true,
        eventClick: function(event, jsEvent, view) {
            if(event.status == 0){
                var id = event.id;
                $(".custom-loading").show();
                $.ajax({
                    url: base_url + "calendar/detail/" + id,
                    type: "POST",
                    dataType: "json",
                    data: {},
                    success: function (data) {
                        console.log(data);
                        if (data["status"] == "success") {
                            $("#detail-modal .modal-content").html(data['response']);
                            $("#detail-modal").modal('show');
                        }
                    },
                    complete: function(){
                       setTimeout(function(){
                          $(".custom-loading").hide();
                       },500);
                    },
                    error: function(data){
                        console.log(data['responseText']);
                    },
                });
            }
        },
  	    viewRender:function(view, element) {
            if (view.name == 'month') {
               by = view.name;
            }
      	    var start = view.start.format();
      	    var end = view.end.format();
        	$(".custom-loading").show();
            $.ajax({
                url: base_url + "calendar/get_calendar",
                type: 'POST',
                data: {"start":start,"end":end,'by':by,'product_id':product_id},
                dataType: "json",
                success: function(data){
                    console.log(data);
                    if(data['status'] == 'success'){
                       if(events_json != null){
                       		for(var i = 0;i < events_json.length; i++){
	                       	   calendar.fullCalendar( 'removeEvents' ,events_json[i].id);
	                        }
                       }
                       calendar.fullCalendar('removeEventSource',events_json);
                       calendar.fullCalendar('addEventSource',data['response']);
                       calendar.fullCalendar('render');
                       events_json = data['response'];

                    }
                },
                error: function(data){
                    console.log(data['responseText']);
                },
                complete: function(){
                    setTimeout(function(){
                        $(".custom-loading").hide();
                    },500);
                }
            });
  	    },
        eventRender: function(event, element) {
            element.find("div.fc-content").prepend("<img style='border-radius:50%;' src='" + event.imageurl +"' width='50' height='50' style='margin-right: 5px;'>");
            if(event.status == 0){
                element.append( "<span class='closeon'><i class='fa fa-times' aria-hidden='true'></i></span>" );
                element.find(".closeon").click(function() {
                    if(confirm('Are you sure you want to delete this item?')){
                        $(".custom-loading").show();
                        var id = event.id;
                        $.ajax({
                            url: base_url + "calendar/remove_calendar/" + id,
                            type: 'POST',
                            data: {},
                            dataType: "json",
                            success: function(data){
                                console.log(data);
                                if(data['status'] == 'success'){
                                   calendar.fullCalendar('removeEvents',event._id);
                                }
                            },
                            complete: function(){
                                setTimeout(function(){
                                    $(".custom-loading").hide();
                                },500);
                            }
                        });
                    }
                    return false;
                });
            }
        }
    });
});