$('#filter').keypress(function(e) {

  if(e.which == 13) {
    search_customer();
  }

});

function search_customer(){

  var search_value = $("#filter").val();

  if(search_value != ""){
      $("#result_customer tbody tr").addClass('hidden');

      $('#result_customer tbody tr').each(function(){
             if($(this).text().toUpperCase().indexOf(search_value.toUpperCase()) != -1){
                 $(this).removeClass('hidden');
             }
      });

  }else{
      $("#result_customer tbody tr").removeClass('hidden');
  }

}
