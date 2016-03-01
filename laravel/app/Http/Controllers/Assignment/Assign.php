<?php
namespace App\Http\Controllers\Assignment;
use App\Http\Controllers\Controller;
use App\Models\event as event;

//use Illuminate\Support\Facades\Redirect;
//use Route;
use Request;

Class Assign extends Controller{

  public static function main($method,$value){

      if($method == "Get_request_event"){

        $Udata = AS_Requestjob::get_request_event($value);
        $return_html = Assign::generate_html($Udata,"");
        echo $return_html;

      }else if($method == "Get_request_date"){

        $Udata = AS_Requestjob::get_request_day($value);
        $return_html = Assign::generate_html($Udata,"");
        echo $return_html;

      }else if($method == "Get_all_user"){

        $Udata = AS_Requestjob::get_all_user($value);
        $return_html = Assign::generate_html($Udata,"");
        echo $return_html;

      }else if($method == "Get_assign_user"){

        $Udata = AS_Requestjob::Get_assign_user($value);
        $return_html = Assign::generate_html($Udata,"assignment_user");
        echo $return_html;

      }else if($method == "remove_from_assign"){
        $remove_type = $value["type"];
        $event_id = $value["event_id"];
        $user_id = $value["user_id"];
        $not_include = $value["not_include"];
        $include = $value["include"];

        if($remove_type == "assignment_user"){

            if(!empty($user_id)){

              $Moveto = AS_Requestjob::find_user_request_type($event_id,$user_id);

              if($Moveto == "request_event_user"){

                  $Udata = AS_Requestjob::get_request_event($event_id);

              }else if($Moveto == "request_job_user"){

                  $Udata = AS_Requestjob::get_request_day($event_id);

              }else{

                  $Udata = AS_Requestjob::get_all_user($event_id);

              }

              $event = event::where("id","=",$event_id)->first();
              $event_date = $event->event_date;

              $usernameall = AS_Member::get_user_data($user_id,'fullname');
              $usergrade = AS_Member::get_user_detail($user_id,'grade');
              $sortgrade = AS_Member::get_user_detail($user_id,'sortgrade');
              $userstatus = Check_busy::main($user_id,$event_date);
              $assign_id = "";
              $category = "assignment_user";

              $Udata[] = ["user_id" => $user_id,
                                "usernameall" => $usernameall,
                                "usergrade" => $usergrade,
                                "sortgrade" => $sortgrade,
                                "userstatus" => $userstatus,
                                "assign_id" => $assign_id,
                                "category" => $category,
                              ];


            }

        }else if($remove_type == "request_event_user"){

            $Udata = AS_Requestjob::get_request_event($event_id);
            $Moveto = "request_event_user";

        }else if($remove_type == "request_job_user"){

            $Udata = AS_Requestjob::get_request_day($event_id);
            $Moveto = "request_job_user";

        }else{

            $Udata = AS_Requestjob::get_all_user($event_id);
            $Moveto = "all_user";

        }

        if(!empty($not_include)){

            for($i = 0;$i < count($not_include);$i++){
                foreach($Udata as $key => $value){
                    if ( $value["user_id"] == $not_include[$i] ){
                      unset($Udata[$key]);
                    }
                }
            }
        }

        usort($Udata, function($a, $b) {
            return $b["sortgrade"] - $a["sortgrade"];
        });

        $return_html = Assign::generate_html($Udata,"");

        $arr = array("code_return"=>$return_html, "moveto"=>$Moveto);
        echo json_encode($arr);

      }

  }

  public static function generate_html($data,$category){

    $user_data = "";

    if($category == "assignment_user"){
      $button_class = "fa-times text-danger remove_assign";
    }else{
      $button_class = "fa-plus-circle text-success add_assign";
    }


    if(isset($data)){

      foreach($data as $record){

          if(isset($record['userstatus']['event'])){

            $hover = "";

            foreach($record['userstatus']['event'] as $row){
                $hover .= $row['event_name']."<br>";
            }

          }else{
            $hover = "";
          }

            $user_data .= "<div id='".$record["user_id"]."' class='row'>
                            <div class='col-xs-12' style='overflow: hidden;white-space: nowrap;'>
                                <i title='".$hover."' class='fa fa-user fa-fw event_assign ".$record["userstatus"]["userstatus"]."'></i>
                                <span class=''><b>". $record["usergrade"] ."</b></span>
                                <span></span>
                                <i>&nbsp;</i>
                                <span class=''>". $record["usernameall"] ."</span>
                                <i assign_id='".$record["assign_id"]."' oldcategory='".$record["category"]."' userid='".$record["user_id"]."' class='fa fa-lg ".$button_class."' style='right:10px;cursor:pointer;padding-top:4px;position:absolute;background-color: #fff;'></i>
                            </div>
                          </div>";


      }

    }

    return $user_data;

  }

  public static function check_status($data){

  }

  public static function jquery_data(){

      $type = Request::input('type');
      $event_id = Request::input('event_id');
      $user_id = Request::input('user_id');
      $not_include = Request::input('not_include');
      $include = Request::input('include');

      $value = ["type" => $type,
                  "event_id" => $event_id,
                  "user_id" => $user_id,
                  "not_include" => $not_include,
                  "include" => $include,
                  ];

      Assign::main('remove_from_assign',$value);

  }

}
