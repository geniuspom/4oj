
$('#assign_calendar').on('click','.goto_assign',function(e){
  var evrnt_id = $(this).attr('id');
  var url = "event_detail/" + evrnt_id;
  //window.location.href = url;
  window.open(url, "_blank", "toolbar=yes, scrollbars=yes");
});


function assign_previous($day,$month,$year){

  if($month == 1){
    $postmonth = 12;
    $postyear = $year-1;
  }else{
    $postmonth = $month-1;
    $postyear = $year;
  }

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: 'changeassingcalendar',
      type: "post",
      data: {'day': $day,'month': $postmonth,'year': $postyear},
      success: function(data){
        $("#assign_calendar").html("");
        $("#assign_calendar").html(data);
      }
    });

}

function assign_next($day,$month,$year){

  if($month == 12){
    $postmonth = 1;
    $postyear = $year+1;
  }else{
    $postmonth = $month+1;
    $postyear = $year;
  }

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: 'changeassingcalendar',
      type: "post",
      data: {'day': $day,'month': $postmonth,'year': $postyear},
      success: function(data){
        $("#assign_calendar").html("");
        $("#assign_calendar").html(data);
      }
    });

}

function assign_today(){

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: 'changeassingcalendar',
      type: "post",
      data: {'day': '','month': '','year': ''},
      success: function(data){
        $("#assign_calendar").html("");
        $("#assign_calendar").html(data);
      }
    });

}
