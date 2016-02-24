<?php
namespace App\Http\Controllers\Inventory;
use App\Http\Controllers\Controller;
use Request;

Class inventory extends Controller{

  public static function main($event_id){

      inventory::generate_html(inventoryManage::Get_DB($event_id));

  }

  public static function generate_html($data){

    $return_data = '<table class="table table-bordered table-hover table-striped">
                    <thead>
                      <tr>
                        <th class="text-center" style="width:2%">ลำดับที่</th>
                        <th class="text-left">รายการ</th>
                        <th class="text-center">Amt</th>
                        <th class="text-center">OJ</th>
                        <th class="text-center">Sup</th>
                        <th class="text-center">Cus</th>
                        <th class="text-center">รับ</th>
                        <th class="text-center">คืน</th>
                        <th class="text-left">Remark/Note</th>
                      </tr>
                    </thead>
                    <tbody>';

    if(count($data['inventory_amt']) == 0){

      for($i = 1; $i <= count($data['inventory_name']);$i++){
          $return_data .= '<tr>
                              <td class="text-center">'.$i.'</td>
                              <td>'. $data['inventory_name'][$i]['name'] .'</td>
                              <td><input type="text" size="1" name="amt_all['.$i.']" value="0"></td>
                              <td><input type="text" size="1" name="amt_oj['.$i.']" value="0"></td>
                              <td><input type="text" size="1" name="amt_sup['.$i.']" value="0"></td>
                              <td><input type="text" size="1" name="amt_cus['.$i.']" value="0"></td>
                              <td><input type="text" size="1" name="amt_receive['.$i.']" value="0"></td>
                              <td><input type="text" size="1" name="amt_return['.$i.']" value="0"></td>
                              <td>'. $data['inventory_name'][$i]['remark'] .'</td>
                          </tr>';
      }

    }else{

      for($i = 1; $i <= count($data['inventory_name']);$i++){
          $return_data .= '<tr>
                              <td class="text-center">'.$i.'</td>
                              <td>'. $data['inventory_name'][$i]['name'] .'</td>
                              <td><input type="text" size="1" name="amt_all['.$i.']" value="'. $data['inventory_amt'][$i]['amt_all'] .'"></td>
                              <td><input type="text" size="1" name="amt_oj['.$i.']" value="'. $data['inventory_amt'][$i]['amt_oj'] .'"></td>
                              <td><input type="text" size="1" name="amt_sup['.$i.']" value="'. $data['inventory_amt'][$i]['amt_sup'] .'"></td>
                              <td><input type="text" size="1" name="amt_cus['.$i.']" value="'. $data['inventory_amt'][$i]['amt_cus'] .'"></td>
                              <td><input type="text" size="1" name="amt_receive['.$i.']" value="'. $data['inventory_amt'][$i]['amt_receive'] .'"></td>
                              <td><input type="text" size="1" name="amt_return['.$i.']" value="'. $data['inventory_amt'][$i]['amt_return'] .'"></td>
                              <td>'. $data['inventory_name'][$i]['remark'] .'</td>
                          </tr>';
      }

    }

    $return_data .= '</tbody></table>';

    echo $return_data;

    //dd($data);


  }

}
