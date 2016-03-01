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

      //return $status;

      //add more
      $event = user::find($user_id)->assign($event_date)->get();

      $return['userstatus'] = $status;

      if(!empty($event)){
        foreach($event as $row){
          $return['event'][] = ['id' => $row->id,
                                'event_name' => $row->event_name,
                                'event_type' => $row->event_type,
                                'event_date' => $row->event_date,
          ];
        }
      }

      return $return;

  }


}
