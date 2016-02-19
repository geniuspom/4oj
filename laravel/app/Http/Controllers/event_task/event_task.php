<?php
namespace App\Http\Controllers\event_task;
use App\Http\Controllers\Controller;
use App\Models\Database\even_job_status as even_job_status;
use App\Models\Member as Member;
use Request;

Class event_task extends Controller{

  public static function main($method,$value){

  }

  public static function event_task_form($even_id,$value,$type){

      if(even_job_status::where('id','=',$even_id)->count() > 0){

          $even_job_status = even_job_status::where('id','=',$even_id)->first();

          $return_data = $even_job_status->$value;

          if($type == "status"){
              $return_data = event_task::create_task_status_html($return_data,$value);
          }else if($type == "respons"){
              $return_data = event_task::create_userform($return_data,$value);
          }else if($type == "plan"){
              $return_data = event_task::create_Plan_html($return_data,$value);
          }


      }else{

        if($type == "status"){
            $return_data = event_task::create_task_status_html(0,$value);
        }else if($type == "respons"){
            $return_data = event_task::create_userform(0,$value);
        }else if($type == "plan"){
            $return_data = event_task::create_Plan_html("",$value);
        }

      }

      echo $return_data;

  }

  public static function create_task_status_html($status,$value){

      if($status == 1){
        $html = '<input type="checkbox" style="width:25px;height:25px;" value="true" name="'.$value.'" checked >';
      }else{
        $html = '<input type="checkbox" style="width:25px;height:25px;" value="true" name="'.$value.'" >';
      }

      return $html;
  }

  public static function create_userform($user_id,$value){

      $user = Member::orderBy('name')->get();

      $html = "<select name='".$value."' id='".$value."' class='form-control'>
              <option value='0'>none</option>";
          foreach ($user as $recode){
              $html .= "<option value='".$recode->id."'" ;
                  if ($user_id == $recode->id){
                      $html .= " selected='selected'";
                  }
              $html .= ">".$recode->nickname." - ".$recode->name." ".$recode->surname."</option>";
          }
      $html .= "</select>";

      return $html;

  }

  public static function create_Plan_html($data,$value){

      $html = '<textarea name="'.$value.'" rows="3" class="form-control">'.$data.'</textarea>';

      return $html;

  }


}
