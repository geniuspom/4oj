<?php
namespace App\Http\Controllers\Payment;
use App\Models\Database\office_salary as office_salary;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Redirect;

Class office_payment extends Controller{

    public static function Update_DB(){

      $method = Request::input('method');

      if($method == "add"){

        $office_salary = new office_salary();
        $pay_status = 0;

        $redirct_link = "add_officepayment";

      }else if($method == "edit"){

        $id = Request::input('id');

        $office_salary = office_salary::where('id','=',$id)->first();
        $redirct_link = "edit_officepayment/".$id;

        if(count($office_salary) > 0){
          $pay_status = $office_salary->pay_status;
        }else{

          $office_salary = new office_salary();
          $pay_status = 0;

        }

      }

        $pay_name = Request::input('pay_name');
        $pay_amt = Request::input('pay_amt');
        $note = Request::input('note');

        $splite_user_id = explode(" ", Request::input('user_id'));
        $user_id  = str_replace("]","",str_replace("[","",$splite_user_id[0]));

        if(!is_numeric($user_id)){
          return redirect::to($redirct_link)
                  ->withInput(Request::all())
                  ->withErrors("กรุณาเลือกชื่อผู้จ่ายเงินจากรายการที่แสดง");

        }


        $office_salary->pay_name = $pay_name;
        $office_salary->pay_amt = $pay_amt;
        $office_salary->pay_status = $pay_status;
        $office_salary->note = $note;
        $office_salary->user_id = $user_id;

        if($office_salary->save()){
          return redirect::to('officepayment_report/null')
                  ->with('status',"บันทึกสำเร็จ");
        }else{
          return redirect::to($redirct_link)
                  ->with('status',"เกิดข้อผิดพลาดไม่สามารถบันทึกได้");
        }


    }

    public static function Get_DB($id,$select){

      $office_salary = office_salary::where('id','=',$id)->first();

      if(count($office_salary)){

        if($select == "user_id"){
          $full_name = $office_salary->user->nickname . " - " . $office_salary->user->name . " " . $office_salary->user->surname;
          $data = "[". $office_salary->user->id ."] " . $full_name;
        }else{
          $data = $office_salary->$select;
        }

      }else{
        $data = "";
      }

      echo $data;

    }

    public static function get_filter_data(){

      $filter_group = Request::input('filter_group');

      if($filter_group == 1){
        $splite_user_id = explode(" ", Request::input('filter_value'));
        $user_id  = str_replace("]","",str_replace("[","",$splite_user_id[0]));
        $office_salary = office_salary::where('user_id','=',$user_id)->get();
      }else{
        $filter_status = Request::input('filter_value');
        $office_salary = office_salary::where('pay_status','=',$filter_status)->get();
      }

      if(count($office_salary) > 0){

        foreach($office_salary as $record){

          $fullname = $record->user->nickname . " - " . $record->user->name . " " . $record->user->surname;

          $data[] = [
                    "id" => $record->id ,
                    "pay_name" => $record->pay_name ,
                    "pay_amt" => $record->pay_amt ,
                    "note" => $record->note ,
                    "name" => $fullname ,
          ];

        }

      }else{
          $data = [];
      }

      echo office_payment::generate_html($data);


    }

    public static function generate_html($data){

      $root_url = dirname($_SERVER['PHP_SELF']);

      $return_data = '<table class="table table-bordered table-hover table-striped">
                      <thead>
                        <tr>
                          <th class="text-center" style="width:2%">#</th>
                          <th class="text-left">แก้ไข</th>
                          <th class="text-left">หัวข้อ</th>
                          <th class="text-left">จ่ายให้</th>
                          <th class="text-center" style="width:3%">ค่าจ้าง</th>
                          <th class="text-left">Remark/Note</th>
                        </tr>
                      </thead>
                      <tbody>';

        if(count($data) > 0){

            $i = 1;

            foreach($data as $record){

                $return_data .= '<tr>
                                    <td class="text-center valign_mid">'.$i.'</td>
                                    <td>
                                    <a target="_blank" class="btn btn-danger btn-circle" href="'. $root_url .'/edit_officepayment/'. $record['id'] .'">
                                      <i style="cursor:pointer;" class="fa fa-edit fa-lg"></i>
                                    </a>
                                    </td>
                                    <td class="valign_mid">'. $record['pay_name'] .'</td>
                                    <td class="valign_mid">'. $record['name'] .'</td>
                                    <td class="text-center valign_mid">'. $record['pay_amt'] .'</td>
                                    <td class="valign_mid">'. $record['note'] .'</td>
                                </tr>';

                $i++;

            }

        }

      echo $return_data;


    }


}
