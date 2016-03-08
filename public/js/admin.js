$('#filter').keypress(function(e) {

  if(e.which == 13) {
    search_user();
  }

});

function search_user(){

  var search_value = $("#filter").val();

  if(search_value != ""){
      $("#result_admin tbody tr").addClass('hidden');

      $('#result_admin tbody tr').each(function(){
             if($(this).text().toUpperCase().indexOf(search_value.toUpperCase()) != -1){
                 $(this).removeClass('hidden');
             }
      });

      var row_sum = $('#result_admin tbody tr').not('.hidden').length;
      $("#row_sum").html(row_sum);

  }else{
      $("#result_admin tbody tr").removeClass('hidden');
      var row_sum = $('#result_admin tbody tr').not('.hidden').length;
      $("#row_sum").html(row_sum);
  }

}
