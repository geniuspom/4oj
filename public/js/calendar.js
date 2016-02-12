$( document ).ready(function(){

  $("#new_request").click(function(){
    var select_date = $("#day_select").val();
    if(select_date == ""){
      select_date = "null";
    }
    var url = "add_request/" + select_date;
    window.location.href = url;
  })

  $('#content_calendar').on('click','.st-bg',function(e){
    var eTop = $(this).offset().top;
    var eLeft = $(this).offset().left;
    var oldselect = $("#day_select").val();
    selecet_day($(this),oldselect);
  });

  $('#content_calendar').on('click','.st-dtitle',function(e){
    var eTop = $(this).offset().top;
    var eLeft = $(this).offset().left;
    var oldselect = $("#day_select").val();
    selecet_day($(this),oldselect);
  });

  $('#content_calendar').on('click','.st-c',function(e){
    var eTop = $(this).offset().top;
    var eLeft = $(this).offset().left;
    var oldselect = $("#day_select").val();
    selecet_day($(this),oldselect);
  });

  //select event
  $('#content_calendar').on('click','.st-c-pos',function(e){
    /*var eTop = $(this).offset().top;
    var eLeft = $(this).offset().left;
    var oldselect = $("#day_select").val();
    $("#"+oldselect).removeClass( "st-bg-select" );
    $("#day_select").val($(this).attr('id'));
    $("#"+$("#day_select").val()).addClass( "st-bg-select" );*/
    var evrnt_id = $(this).attr('id');
    var url = "detail_request/" + evrnt_id;
    window.location.href = url;
  });



});

function getprecalendar($day,$month,$year){

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
      url: 'nextcalendar',
      type: "post",
      data: {'day': $day,'month': $postmonth,'year': $postyear},
      success: function(data){
        $("#content_calendar").html("");
        $("#content_calendar").html(data);
        $("#day_select").val("");
      }
    });

}

function getnextcalendar($day,$month,$year){

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
      url: 'nextcalendar',
      type: "post",
      data: {'day': $day,'month': $postmonth,'year': $postyear},
      success: function(data){
        $("#content_calendar").html("");
        $("#content_calendar").html(data);
        $("#day_select").val("");
      }
    });

}

function gettodaycalendar(){

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: 'nextcalendar',
      type: "post",
      data: {'day': '','month': '','year': ''},
      success: function(data){
        $("#content_calendar").html("");
        $("#content_calendar").html(data);
        $("#day_select").val("");
      }
    });

}

function selecet_day(element,oldselect){
    if((element).attr('id') == "" || (element).attr('id') == null){
    }else{
      if(oldselect == ""){
        $("#day_select").val($(element).attr('id'));
        $("#content_calendar #"+$("#day_select").val()).addClass( "st-bg-select" );
      }else{
          $("#content_calendar #"+oldselect).removeClass( "st-bg-select" );
          $("#day_select").val($(element).attr('id'));
          $("#content_calendar #"+$("#day_select").val()).addClass( "st-bg-select" );
      }
    }
}
