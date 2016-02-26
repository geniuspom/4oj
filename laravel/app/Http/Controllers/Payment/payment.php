<?php
namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Request;

Class payment extends Controller{

  public static function main($event_id){

      payment::generate_html(paymentManage::Get_DB($event_id));

  }

  public static function generate_html($data){

    $root_url = dirname($_SERVER['PHP_SELF']);

    $return_data = '<table class="table table-bordered table-hover table-striped">
                    <thead>
                      <tr>
                        <th class="text-center" style="width:2%">ลำดับที่</th>
                        <th class="text-left">ชื่อคนที่ทำงาน</th>
                        <th class="text-center" style="width:3%">ค่าจ้าง</th>
                        <th class="text-left">Remark/Note</th>
                      </tr>
                    </thead>
                    <tbody>';

      $sum_payment = 0;

      if($data['Assignuser'] > 0){

          //dd($data);

          for($i = 1; $i <= $data['Assignuser'];$i++){

              if(!isset($data['Payment_list'][$i]['pay_amt'])){
                $payment = 0;
              }else{
                $payment = $data['Payment_list'][$i]['pay_amt'];
              }

              $sum_payment = $sum_payment+$payment;

              $return_data .= '<tr>
                                  <td class="text-center valign_mid">'.$i.'</td>
                                  <td class="valign_mid"><input type="hidden" size="1" name="assignid['.$i.']" value="'. $data['Payment_list'][$i]['assignid'] .'">
                                  <a target="_blank" href="'. $root_url .'/profile_admin/'. $data['Payment_list'][$i]['user_id'] .'">
                                  '. $data['Payment_list'][$i]['full_name'] .'</td>
                                  <td class="text-center valign_mid"><input type="text" class="text-right" name="pay_amt['.$i.']" value="'. $payment .'"></td>
                                  <td><textarea name="note['.$i.']" rows="2" class="form-control">'. $data['Payment_list'][$i]['note'] .'</textarea></td>
                              </tr>';
          }

      }else{

        $return_data .= '<tr>
                            <td class="text-center" colspan="4">ไม่มีรายชื่อคนที่ไปทำงานนี้</td>
                        </tr>';

      }


    $return_data .= '<tr>
                        <td class="text-center valign_mid">รวม : '. $data['Assignuser'] .' คน</td>
                        <td class="text-center"></td>
                        <td class="text-center valign_mid">ค่าจ้างทั้งหมด : '. $sum_payment .' บาท</td>
                        <td class="text-center"></td>
                    </tr>
                    </tbody></table>';

    if($data['Assignuser'] > 0){

      $return_data .= '<button id="submit_bt" name="btn-trianing" type="submit" class="btn btn-primary" >
                          บันทึก
                      </button>';

    }

    echo $return_data;


  }

}
