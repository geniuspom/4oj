<?php
namespace App\Http\Controllers\Payment;
use App\Models\Database\Assignment as AssignmentDB;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Redirect;

Class paymentManage extends Controller{

    public static function main(){

        $event_id = Request::input('event_id');

        $paymentdata = [];

        $assignid = Request::input('assignid');
        $pay_amt = Request::input('pay_amt');
        $note = Request::input('note');

        for($i = 1;$i <= count(Request::input('assignid'));$i++){

          $paymentdata[$i] = ["assignid" => $assignid[$i],
                                "pay_amt" => $pay_amt[$i],
                                "note" => $note[$i],
                                ];
        }

        paymentManage::Update_DB($paymentdata);

          return redirect::to('assigment/'.$event_id)
                  ->with('status',"บันทึกสำเร็จ");

    }

    public static function Update_DB($paymentdata){

      $count_paymentdata = count($paymentdata);

      for($r = 1; $r <= $count_paymentdata; $r++){

          $PaymentDB = AssignmentDB::where('id','=',$paymentdata[$r]['assignid'])->first();

          $PaymentDB->pay_amt = $paymentdata[$r]['pay_amt'];
          $PaymentDB->note = $paymentdata[$r]['note'];
          $PaymentDB->save();

      }

    }

    public static function Get_DB($event_id){

      $Payment_list = [];

      $count_payment = AssignmentDB::where('event_id','=',$event_id)->count();

      if($count_payment > 0){

          $payment = AssignmentDB::where('event_id','=',$event_id)->get();

          $i = 1;

          foreach($payment as $data){

              $Payment_list[$i] = ["assignid" => $data['id'],
                                      "user_id" => $data['user_id'],
                                      "pay_amt" => $data['pay_amt'],
                                      "full_name" => $data->user['nickname'] . " - " . $data->user['name'] ." " . $data->user['surname'],
                                      "note" => $data['note'],];

              $i++;

          }

          //dd($Payment_list);

          $Amount_user = $count_payment;

      }else{

          $Amount_user = 0;

      }

      $data_all = ["Assignuser" => $Amount_user, "Payment_list" => $Payment_list];

      return($data_all);

    }

    public static function Update_Status(){

      $payselect = Request::input('payselect');
      $paystatus = Request::input('paystatus');

      if(!empty(Request::input('removepay_select'))){
          $removepay_select = explode(",", Request::input('removepay_select'));

          foreach($removepay_select as $record){
              if(!empty($record)){
                  $Payupdate = AssignmentDB::where('id','=',$record)->first();
                  $Payupdate->pay_status = 0;
                  $Payupdate->save();
              }
          }

      }

      if(isset($payselect)){
        $assign_id_select = array_keys($payselect);

          foreach($assign_id_select as $record){
              $Payupdate = AssignmentDB::where('id','=',$record)->first();
              $Payupdate->pay_status = 1;
              $Payupdate->save();
          }
      }

      if(isset($paystatus)){
        $assign_id_status = array_keys($paystatus);

          foreach($assign_id_status as $record){
              $Payupdate = AssignmentDB::where('id','=',$record)->first();
              $Payupdate->pay_status = 2;
              $Payupdate->save();
          }

      }


    }

}
