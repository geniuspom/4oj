<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use App\Models\Member as Member;

class AutoCompleteMember extends Controller{

  public static function main(){

      $Member = Member::orderBy('nickname')->get();

      $user_list = array();

      foreach ($Member as $query){

          $full_name = $query->nickname . " - " . $query->name . " " . $query->surname;
          $user_id = $query->id;

          $user_list[] = "[". $user_id ."] " . $full_name;

      }

      echo json_encode($user_list);

  }

}
