<?php
//namespace App\Http\Controllers;
use App\Models\Member as Member;

//Class InstituteController extends Controller{
    //public static function getinstitute(){

      $user = Member::orderBy('name')->get();

      $user_list = array();

      foreach ($user as $record){
        $user_list[] = $record->nickname."-".$record->name." ".$record->surname."[".$record->id."]";
      }

      echo json_encode($user_list);

    //}
//}
?>
