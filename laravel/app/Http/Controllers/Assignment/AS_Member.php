<?php
namespace App\Http\Controllers\Assignment;
use App\Http\Controllers\Controller;
use App\Models\Member as Member;
use App\Models\Userdetail as Userdetail;

Class AS_Member extends Controller{

  public static function main(){

  }

  public static function get_user_data($user_id,$value){

      $count_member = Member::where('id','=',$user_id)->count();

      if($count_member > 0){

          $user = Member::where('id','=',$user_id)->first();

          if($value == "fullname"){
              $return_data = $user->nickname . " - " . $user->name . " " . $user->surname ;
          }else{
              $return_data = $user->$value;
          }

          return $return_data;

      }

  }

  public static function get_user_detail($user_id,$value){

      $count_member_detail = Userdetail::where('id','=',$user_id)->count();

      if($count_member_detail > 0){

          $user_detail = Userdetail::where('id','=',$user_id)->first();

          if($value == "grade"){
              $grade = $user_detail->grade;
              if($grade == 0){$return_data = "N";}
              else if($grade == 1){$return_data = "D";}
              else if($grade == 2){$return_data = "C";}
              else if($grade == 3){$return_data = "B";}
              else if($grade == 4){$return_data = "A";}
              else{$return_data = "N";}

          }else if($value == "sortgrade"){
              $return_data = $user_detail->grade;
          }else{
              $return_data = $user_detail->$value;
          }

      }else{
          $return_data = "N";
      }

      return $return_data;

  }

  public static function get_all_member($user_not_include){

      $query_data = [];
      $array_data = [];

      foreach($user_not_include as $data=>$value){
          $query_data[] = [$value];
      }


      $user_detail = Member::whereNotIn('id', $query_data)->get();

      foreach($user_detail as $data){

        $user_id = $data->id;
        $usernameall = $data->nickname . " - " . $data->name . " " . $data->surname ;
        $usergrade = AS_Member::get_user_detail($user_id,'grade');
        $sortgrade = AS_Member::get_user_detail($user_id,'sortgrade');
        $userstatus = "";
        $assign_id = "";
        $category = "all_user";

        $array_data[] = ["user_id" => $user_id,
                          "usernameall" => $usernameall,
                          "usergrade" => $usergrade,
                          "sortgrade" => $sortgrade,
                          "userstatus" => $userstatus,
                          "assign_id" => $assign_id,
                          "category" => $category,
                        ];

      }

      usort($array_data, function($a, $b) {
          return $b["sortgrade"] - $a["sortgrade"];
      });

      return $array_data;

  }


}
