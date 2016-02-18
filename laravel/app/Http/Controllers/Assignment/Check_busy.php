<?php
namespace App\Http\Controllers\Assignment;
use App\Models\Database\user as user;
use App\Http\Controllers\Controller;
use Request;

Class Check_busy extends Controller{

  public static function main($user_id,$event_date){

      $count = user::find($user_id)->assign($event_date)->count();

      if($count > 0){
        $status = "busy";
      }else{
        $status = "avaliable";
      }

      return $status;

  }


}
