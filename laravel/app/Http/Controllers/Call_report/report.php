<?php
namespace App\Http\Controllers\Call_report;
use App\Models\Database\call_report as call_reportDB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainControllers\Date_time as Date_time;
use Request;

Class report extends Controller{

    public static function main(){

        $filter_group = Request::input('filter_group');
        $filter_value_request = Request::input('filter_value');
        $sortby = Request::input('sortby');

        if($filter_group == 1){

          $splite_filter_value_request = explode(" ", $filter_value_request);
          $filter_value  = str_replace("]","",str_replace("[","",$splite_filter_value_request[0]));

          if(!is_numeric($filter_value)){
            $filter_value = 0;
          }

        }else{
          $filter_value = $filter_value_request;
        }

        $data = report::generate_html(report::get_db($filter_group,$filter_value));

        return $data;
    }

    public static function generate_html($data){

      $root_url = dirname($_SERVER['PHP_SELF']);

      $returnhtml =   "
                      <table class='table table-bordered table-hover table-striped'>
                      <thead>
                      <tr>
                      <th class='text-center'>ดำเนินการ</th>
                      <th class='text-center'>ชื่อบริษัท</th>
                      <th class='text-center'>Hashtag</th>
                      <th class='text-center'>ข้อความ</th>
                      <th class='text-center'>สร้างโดย</th>
                      <th class='text-center'>วันที่สร้าง</th>
                      <th class='text-center'>มอบหมายให้</th>
                      </tr>
                      </thead>
                      <tbody>";

      if(isset($data)){

          if(count($data) == 0){
            $returnhtml .= "<tr>
                                <td class='text-center' colspan='7'>ไม่พบข้อมูล</td>
                            </tr>";

          }else{

            foreach($data as $record){

              $returnhtml .=  "<tr><td class='text-center vcenter'>
                              <a target='_blank' href='". $root_url . "/detail_call_report/" . $record['id'] ."'><i class='fa fa-eye fa-lg text-primary'></i></a>
                              <a target='_blank' href='". $root_url . "/edit_call_report/" . $record['id'] ."'><i class='fa fa-edit fa-lg text-danger'></i></a>
                              </td><td class='text-center vcenter'>".
                              $record['company_name'] .
                              "</td><td class='text-center vcenter'>".
                              $record['Hashtag'] .
                              "</td><td class='text-center vcenter'>".
                              $record['comment'] .
                              "</td><td class='text-center vcenter'>".
                              $record['created_by'] .
                              "</td><td class='text-center vcenter'>".
                              Date_time::convert_to_thai_format($record['created_at']) .
                              "</td><td class='text-center vcenter'>".
                              $record['assigned'] .
                              "</td></tr>";

            }
          }

      }

      $returnhtml .= "</tbody>
                      </table>
                      ";

      return $returnhtml;


    }

    public static function get_db($filter_group,$filter_value){

      if($filter_group == 1){
        $call_report = call_reportDB::where('customer_id','=',$filter_value)
                            ->orderBy('created_at', 'DESC')
                            ->get();

      }else{

        $filter_value = "%" . $filter_value . "%";

        $call_report = call_reportDB::where('hashtag', 'LIKE', $filter_value)
                            ->orderBy('created_at', 'DESC')
                            ->get();
      }

      if(isset($call_report) && $call_report){

          $return_data = [];

          foreach($call_report as $record){

              if(isset($record->assingto->id)){
                  $assigned = $record->assingto->nickname . " - " . $record->assingto->name . " " .$record->assingto->surname;
              }else{
                  $assigned = "";
              }

              $return_data[] = [
                                'id' => $record->id,
                                'company_name' => $record->customer->symbol . " - " . $record->customer->name,
                                'Hashtag' => $record->hashtag,
                                'comment' => $record->comment,
                                'assigned' => $assigned,
                                'created_by' => $record->createdby->nickname . " - " . $record->createdby->name . " " .$record->createdby->surname,
                                'created_at' => $record->created_at,
              ];

          }

          return $return_data;

      }

    }

}
