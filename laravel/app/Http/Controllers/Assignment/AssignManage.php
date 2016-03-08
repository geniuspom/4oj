<?php
namespace App\Http\Controllers\Assignment;
use App\Models\Database\Assignment as Assignment;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Redirect;

Class AssignManage extends Controller{

  public static function main(){

      $add_id = Request::input('add_id');
      $remove_id = Request::input('remove_id');
      $event_id = Request::input('event_id');


      if(!empty($add_id)){
        AssignManage::add_assign($add_id,$event_id);
      }

      if(!empty($remove_id)){
        AssignManage::remove_assign($remove_id);
      }


  }

  public static function add_assign($add_id,$event_id){

    for($i = 0;$i < count($add_id);$i++){

      $count_result = Assignment::where('event_id', '=', $event_id)
                                ->where('user_id','=',$add_id[$i])
                                ->count();

      if($count_result == 0){

        $Assignment = new Assignment();
        $Assignment->user_id = $add_id[$i];
        $Assignment->event_id = $event_id;
        $Assignment->assign_status = 1;

        if($Assignment->save()){
          $save_id = $Assignment->id;
        }

        sendmailAssign::New_Assign($save_id);

      }

    }

  }

  public static function remove_assign($remove_id){

    for($i = 0;$i < count($remove_id);$i++){

      $count_result = Assignment::where('id', '=', $remove_id)->count();

      if($count_result > 0){

        $Assignment = Assignment::where('id', '=', $remove_id)->first();
        $Assignment->delete();

      }

    }

  }

  public static function getdata_response($id){

      $Assignment = Assignment::where('id','=', $id)->first();

      if(count($Assignment) > 0){
          $data = $Assignment->event;

          return $data;
      }

  }

  public static function getstatus_response($value){

      if($value == "Confirm"){
        return "ยืนยัน";
      }else{
        return "ปฏิเสธ";
      }

  }

  public static function response(){

    $root_url = dirname($_SERVER['PHP_SELF']);

    $assign_id = Request::input('id');
    $status = Request::input('status');

    if($status == "Confirm"){
      $status = 2;
    }else if($status == "Reject"){
      $status = 3;
    }else{
      return redirect::to(".." .$root_url . '/');
      exit();
    }

    $assignment = Assignment::where('id','=',$assign_id)->first();

    if(count($assignment) > 0){
      $assignment->assign_status = $status;
      $assignment->save();
    }

    return redirect::to(".." .$root_url . '/');

  }


}
