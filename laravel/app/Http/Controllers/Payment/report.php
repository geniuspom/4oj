<?php
namespace App\Http\Controllers\Payment;
use App\Models\Database\Assignment as Payment;
use App\Models\Database\office_salary as office_salary;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Redirect;

Class report extends Controller{

    public static function main(){

        $filter_group = Request::input('filter_group');
        $filter_value_request = Request::input('filter_value');
        $sortby = Request::input('sortby');

        if($filter_group == 1){

          $input_user = explode("]", $filter_value_request);
          $splite_user = explode("[", $input_user[0]);
          $filter_value = $splite_user[1];

        }else{
          $filter_value = $filter_value_request;
        }

        $data = report::generate_html(report::get_db($filter_group,$filter_value));

        return $data;
    }

    public static function generate_html($data){

      $returnhtml =   "<form class='form-horizontal' id='payment_form' >
                      <textarea class='hidden' id='removepay_select' name='removepay_select' rows='1' class='form-control'></textarea>
                      <textarea class='hidden' id='removeoffice_select' name='removeoffice_select' rows='1' class='form-control'></textarea>
                      <table class='table table-bordered table-hover table-striped'>
                      <thead>
                      <tr>
                      <th class='text-center'>#</th>
                      <th class='text-center'>จ่ายเงินแล้ว</th>
                      <th class='text-center'>ชื่อ</th>
                      <th class='text-center'>ชื่องานประชุม</th>
                      <th class='text-center'>ค่าจ้าง</th>
                      <th class='text-center'>Remark/Note</th>
                      </tr>
                      </thead>
                      <tbody>";

      if(isset($data)){

          $i = 1;
          $pay_sum = 0;

          foreach($data as $record){

            if($record['db'] == "assignment"){
              $checkname = "asst";
            }else{
              $checkname = "ofst";
            }

            if($record['pay_status'] == 1){
                //$select_pay = '<i class="fa fa-check fa-2x text-success only_print"></i><input checked="" class="no_print pay_select" type="checkbox" style="width:25px;height:25px;" value="true" id="payselect_'. $record['id'] .'" name="payselect['. $record['id'] .']">';
                //$pay_status = '<i class="fa fa-times fa-2x text-danger only_print"></i><input class="no_print pay_status" type="checkbox" style="width:25px;height:25px;" value="true" id="'.$checkname.'_'. $record['id'] .'" name="'.$checkname.'['. $record['id'] .']">';
                //$pay_amt = '<input type="hidden" id="payamt_'. $record['id'] .'" value="'. $record['pay_amt'] . '" >';
                //$pay_sum .= $pay_amt;
            }else if($record['pay_status'] == 2){
                //$select_pay = '<i class="fa fa-check fa-2x text-success only_print"></i><input checked="" class="no_print pay_select" type="checkbox" style="width:25px;height:25px;" value="true" id="payselect_'. $record['id'] .'" name="payselect['. $record['id'] .']">';
                $pay_status = '<i class="fa fa-check fa-2x text-success only_print"></i><input checked="" class="no_print pay_status" type="checkbox" style="width:25px;height:25px;" value="true" id="'.$checkname.'_'. $record['id'] .'" name="'.$checkname.'['. $record['id'] .']">';
                $pay_amt = '<input type="hidden" id="payamt_'. $record['id'] .'" value="'. $record['pay_amt'] . '" >';
                //$pay_sum .= $record['pay_amt'];
            }else{
                //$select_pay = '<i class="fa fa-times fa-2x text-danger only_print"></i><input class="no_print pay_select" type="checkbox" style="width:25px;height:25px;" value="true" id="payselect_'. $record['id'] .'" name="payselect['. $record['id'] .']">';
                $pay_status = '<i class="fa fa-times fa-2x text-danger only_print"></i><input class="no_print pay_status" type="checkbox" style="width:25px;height:25px;" value="true" id="'.$checkname.'_'. $record['id'] .'" name="'.$checkname.'['. $record['id'] .']">';
                $pay_amt = '<input type="hidden" id="payamt_'. $record['id'] .'" value="'. $record['pay_amt'] . '" >';
            }

            $returnhtml .=  "<tr><td class='text-center vcenter'>".
                            $i .
                            "</td><td class='text-center vcenter'>".
                            $pay_status .
                            "</td><td class='text-center vcenter'>".
                            $record['user_name'] .
                            "</td><td class='text-center vcenter'>".
                            $record['event_name'] .
                            "</td><td class='text-center vcenter'>".
                            $pay_amt . number_format($record['pay_amt']) .
                            "</td><td class='text-center vcenter'>".
                            $record['note'] .
                            "</td></tr>";

              $i++;

          }

      }


      $returnhtml .= "<tr><td colspan='5' class='text-center vcenter'>จำนวนเงินรวม</td>
                      <td class='text-center vcenter'><div id='pay_sum'>". $pay_sum ."</div></td><td></td>
                      </tr></tbody>
                      </table>
                      <button type='submit' class='btn btn-primary' id='update_payment'>
                        บันทึก
                      </button>
                      </form>
                      ";

      return $returnhtml;


    }

    public static function get_db($filter_group,$filter_value){

      if($filter_group == 1){
        $paymant = Payment::where('user_id','=',$filter_value)
                            ->where('pay_amt','!=',0)
                            ->whereNotNull('pay_amt')
                            ->get();
        $office_salary = office_salary::where('user_id','=',$filter_value)
                            ->where('pay_amt','!=',0)
                            ->whereNotNull('pay_amt')
                            ->get();
      }else if($filter_value == 3){
        $paymant = Payment::where('pay_amt','!=',0)
                            ->whereNotNull('pay_amt')
                            ->orderBy('user_id')
                            ->get();
        $office_salary = office_salary::where('pay_amt','!=',0)
                            ->whereNotNull('pay_amt')
                            ->orderBy('user_id')
                            ->get();
      }else{
        $paymant = Payment::where('pay_status','=',$filter_value)
                            ->where('pay_amt','!=',0)
                            ->whereNotNull('pay_amt')
                            ->orderBy('user_id')
                            ->get();
        $office_salary = office_salary::where('pay_status','=',$filter_value)
                            ->where('pay_amt','!=',0)
                            ->whereNotNull('pay_amt')
                            ->orderBy('user_id')
                            ->get();
      }

      if(isset($paymant) && $paymant){

          $return_data = [];

          foreach($paymant as $record){

              $return_data[] = [
                                'id' => $record->id,
                                'user_id' => $record->user_id,
                                'user_name' => $record->user->nickname . " - " . $record->user->name . " " . $record->user->surname,
                                'event_id' => $record->event_id,
                                'event_name' => $record->event->event_name,
                                'pay_amt' => $record->pay_amt,
                                'pay_status' => $record->pay_status,
                                'note' => $record->note,
                                'db' => 'assignment',
              ];

          }

          foreach($office_salary as $record){

              $return_data[] = [
                                'id' => $record->id,
                                'user_id' => $record->user_id,
                                'user_name' => $record->user->nickname . " - " . $record->user->name . " " . $record->user->surname,
                                'event_id' => 0,
                                'event_name' => $record->pay_name,
                                'pay_amt' => $record->pay_amt,
                                'pay_status' => $record->pay_status,
                                'note' => $record->note,
                                'db' => 'office_salary',
              ];

          }


          return $return_data;

      }

    }

}
