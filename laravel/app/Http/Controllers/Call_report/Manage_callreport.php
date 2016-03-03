<?php
namespace App\Http\Controllers\Call_report;
use App\Models\Database\call_report as call_reportDB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainControllers\Date_time as Date_time;
use Request;
use Auth;
use Illuminate\Support\Facades\Redirect;

Class Manage_callreport extends Controller{

    public static function main(){

        $root_url = dirname($_SERVER['PHP_SELF']);

        $method = Request::input('submit');

        if(isset($method) && !empty($method)){

            $call_id = Request::input('id');
            $comment = Request::input('comment');
            $hashtag = Request::input('hashtag');
            $input_customer_id = Request::input('customer_id');
            $input_assigned_id = Request::input('assigned_id');

            $id_all = Manage_callreport::getdata_id($input_customer_id,$input_assigned_id);

            if(!empty($id_all["customer_id"]) && $id_all["customer_id"] != 0){

              $data = ["comment" => $comment,
                        "hashtag" => $hashtag,
                        "customer_id" => $id_all["customer_id"],
                        "assigned_id" => $id_all["assigned_id"],
                        "call_id" => $call_id,
                      ];

              if($method == "add_call"){

                if(Manage_callreport::add($data)){
                  return redirect::to(".." .$root_url . '/call_report')
                          ->with('status',"บันทึกสำเร็จ");
                }else{
                  return redirect::to(".." .$root_url . '/add_call_report')
                          ->withInput(Request::all())
                          ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถบันทึกได้");
                }


              }else if($method == "edit_call"){

                if(Manage_callreport::edit($data)){
                  return redirect::to(".." .$root_url . '/call_report')
                          ->with('status',"บันทึกสำเร็จ");
                }else{
                  return redirect::to(".." .$root_url . '/edit_call_report')
                          ->withInput(Request::all())
                          ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถบันทึกได้");
                }

              }


            }else{
              return redirect::to(".." .$root_url . '/add_call_report')
                      ->withInput(Request::all())
                      ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถบันทึกได้");
            }

        }else{
          return redirect::to(".." .$root_url . '/add_call_report')
                  ->withInput(Request::all())
                  ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถบันทึกได้");
        }

    }

    public static function getdata_id($input_customer_id,$input_assigned_id){

      if(!empty($input_customer_id)){

        $splite_customer_id = explode(" ", $input_customer_id);
        $customer_id  = str_replace("]","",str_replace("[","",$splite_customer_id[0]));

        if(!is_numeric($customer_id)){
          $customer_id = 0;
        }

      }else{
        $customer_id = null;
      }

      //================================================================================

      if(!empty($input_assigned_id)){

        $splite_assigned_id = explode(" ", $input_assigned_id);
        $assigned_id  = str_replace("]","",str_replace("[","",$splite_assigned_id[0]));

        if(!is_numeric($assigned_id)){
          $assigned_id = 0;
        }

      }else{
        $assigned_id = null;
      }

      $return = ["customer_id" => $customer_id, "assigned_id" => $assigned_id];

      return $return;


    }

    public static function add($data){

      $call_report = new call_reportDB();
      $call_report->comment = $data["comment"];
      $call_report->hashtag = $data["hashtag"];
      $call_report->created_by = Auth::user()->id;
      $call_report->customer_id = $data["customer_id"];
      $call_report->assigned_id = $data["assigned_id"];

      if($call_report->save()){
        return true;
      }else{
        return false;
      }

    }

    public static function edit($data){

      $call_report = call_reportDB::where('id','=',$data["call_id"])->first();

      if(count($call_report) > 0){
        $call_report->comment = $data["comment"];
        $call_report->hashtag = $data["hashtag"];
        $call_report->created_by = Auth::user()->id;
        $call_report->customer_id = $data["customer_id"];
        $call_report->assigned_id = $data["assigned_id"];

        if($call_report->save()){
          return true;
        }else{
          return false;
        }

      }else{
        return false;
      }

    }

    public static function getdata($id,$method,$value){

      $call_report = call_reportDB::where('id','=',$id)->first();

      if(count($call_report) > 0){

        switch ($value) {
            case "customer_id":
                $returndata = "[" . $call_report->customer->id . "] " . $call_report->customer->symbol . " - " . $call_report->customer->name;
                break;
            case "hashtag":
                $returndata = $call_report->hashtag;
                break;
            case "comment":
                $returndata = $call_report->comment;
                break;
            case "assigned_id":
                if(isset($call_report->assingto->id)){
                  $returndata = "[" . $call_report->assingto->id . "] " . $call_report->assingto->nickname . " - " . $call_report->assingto->name . " " .$call_report->assingto->surname;
                }else{
                  $returndata = "";
                }
                break;
            case "created_by":
                $returndata = "[" . $call_report->createdby->id . "] " . $call_report->createdby->nickname . " - " . $call_report->createdby->name . " " .$call_report->createdby->surname;
                break;
            case "created_at":
                $returndata = Date_time::convert_to_thai_format($call_report->created_at);
                break;
        }

        return $returndata;

      }

    }

}
