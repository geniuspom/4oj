<?php
namespace App\Http\Controllers\Inventory;
use App\Models\Database\inventory_amt as inventory_amt;
use App\Models\Database\inventory as inventory_db;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Redirect;

Class inventoryManage extends Controller{

    public static function main(){

        $event_id = Request::input('event_id');
        $inventory_data = [];

        for($i = 1;$i <= count(Request::input('amt_all'));$i++){

          $amt_all = Request::input('amt_all');
          $amt_oj = Request::input('amt_oj');
          $amt_sup = Request::input('amt_sup');
          $amt_cus = Request::input('amt_cus');
          $amt_receive = Request::input('amt_receive');
          $amt_return = Request::input('amt_return');

          $inventory_data[$i] = ["amt_all" => $amt_all[$i],
                                "amt_oj" => $amt_oj[$i],
                                "amt_sup" => $amt_sup[$i],
                                "amt_cus" => $amt_cus[$i],
                                "amt_receive" => $amt_receive[$i],
                                "amt_return" => $amt_return[$i],
                                ];
        }

        $count_inventory = inventory_amt::where('event_id','=',$event_id)->count();

        if($count_inventory == 0){

          inventoryManage::New_role_DB($event_id);
          inventoryManage::Update_DB($event_id,$inventory_data);

          return redirect::to('assigment/'.$event_id)
                  ->with('status',"บันทึกสำเร็จ");

        }else{

          inventoryManage::Update_DB($event_id,$inventory_data);

          return redirect::to('assigment/'.$event_id)
                  ->with('status',"บันทึกสำเร็จ");

        }

    }

    public static function New_role_DB($event_id){

        $inventory = inventory_db::count();

        for($i=1;$i<=$inventory;$i++){

            $inventory_amt = new inventory_amt();
            $inventory_amt->event_id = $event_id;
            $inventory_amt->inventory_id = $i;
            $inventory_amt->amt_all = 0;
            $inventory_amt->amt_oj = 0;
            $inventory_amt->amt_sup = 0;
            $inventory_amt->amt_cus = 0;
            $inventory_amt->amt_receive = 0;
            $inventory_amt->amt_return = 0;
            $inventory_amt->save();

        }

    }

    public static function Update_DB($event_id,$inventory_data){

      $count_inventory = count($inventory_data);

      for($r = 1; $r <= $count_inventory; $r++){

          $inventory_amt = inventory_amt::where('event_id','=',$event_id)
                        ->where('inventory_id','=',$r)
                        ->first();

          $inventory_amt->amt_all = $inventory_data[$r]['amt_all'];
          $inventory_amt->amt_oj = $inventory_data[$r]['amt_oj'];
          $inventory_amt->amt_sup = $inventory_data[$r]['amt_sup'];
          $inventory_amt->amt_cus = $inventory_data[$r]['amt_cus'];
          $inventory_amt->amt_receive = $inventory_data[$r]['amt_receive'];
          $inventory_amt->amt_return = $inventory_data[$r]['amt_return'];
          $inventory_amt->save();

      }

    }

    public static function Get_DB($event_id){

      $count_inventory = inventory_db::count();

      $inventory = inventory_db::all();

      $inventory_list = [];

      foreach($inventory as $data){

          $inventory_list[$data['id']] = ["name" => $data['name'],
                                        "remark" => $data['remark']];

      }

      $inventory_amt_list = [];

      $count_inventory_amt = inventory_amt::where('event_id','=',$event_id)->count();

      if($count_inventory > 0){

          $inventory_amt = inventory_amt::where('event_id','=',$event_id)->get();

          foreach($inventory_amt as $data){

              $inventory_amt_list[$data['inventory_id']] = ["amt_all" => $data['amt_all'],
                                      "amt_oj" => $data['amt_oj'],
                                      "amt_sup" => $data['amt_sup'],
                                      "amt_cus" => $data['amt_cus'],
                                      "amt_receive" => $data['amt_receive'],
                                      "amt_return" => $data['amt_return'],];
          }

      }

      $data_all = ["inventory_name" => $inventory_list, "inventory_amt" => $inventory_amt_list];

      return($data_all);

    }

}
