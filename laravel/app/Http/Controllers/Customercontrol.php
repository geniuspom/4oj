<?php
namespace App\Http\Controllers;

use App\Models\customer as customer;
use App\Models\validatecustomer as validatecustomer;
//use Auth;
use Illuminate\Support\Facades\Redirect;
use Request;

Class Customercontrol extends Controller{

    //get customer
    public static function get($id,$value){

        $customer = customer::where("id","=", $id)->first();

        $returndata = $customer->$value;

        echo $returndata;

    }

    //get all customer
    public static function getall(){

        $root_url = dirname($_SERVER['PHP_SELF']);
        
        $customer = customer::orderBy('symbol')->get();

        foreach ($customer as $record){

          echo "<tr><td class='text-center'><a href='customer_detail/".
                $record->id .
                "'>" .
                $record->symbol .
                "</a></td><td class='text-center'>".
                $record->name .
                "</td><td class='text-center'>".
                $record->phone .
                "</td><td><a target='blank' href='".
                $record->website .
                "'>".
                $record->website .
                "</a></td><td class='text-center'><a href='edit_customer/".
                $record->id .
                "'><img src='".$root_url."/public/image/file_edit.png' width='20px' /></a></td><tr>";
        }

    }

    //add
    public function add(){

        //check input form
        $validate = validatecustomer::validatecustomer(Request::all());

        if($validate->passes()){
            $customer = new customer();
            $customer->name = Request::input('name');
            $customer->symbol = Request::input('symbol');
            $customer->address = Request::input('address');
            $customer->phone = Request::input('phone');
            $customer->website = Request::input('website');
            $customer->tax_address = Request::input('tax_address');
            $customer->tax_id = Request::input('tax_id');

            if($customer->save()) {
              return redirect::to('customer')
                      ->with('status',"เพิ่มลูกค้าชื่อ ". Request::input('name') ." สำเร็จ");
            } else {
              return redirect::to('add_customer')
                      ->withInput(Request::except('password'))
                      ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถเพิ่มลูกค้าได้");
            }

        }else{
            return redirect::to('add_customer')
                ->withInput(Request::all())
                ->withErrors($validate->messages());
        }

    }

    //edit
    public function edit(){

        //check input form
        $validate = validatecustomer::validateeditcustomer(Request::all());

        if($validate->passes()){
            $customer = customer::where("id","=",Request::input('id'))->first();
            $customer->name = Request::input('name');
            $customer->symbol = Request::input('symbol');
            $customer->address = Request::input('address');
            $customer->phone = Request::input('phone');
            $customer->website = Request::input('website');
            $customer->tax_address = Request::input('tax_address');
            $customer->tax_id = Request::input('tax_id');

            if($customer->save()) {
              return redirect::to('customer_detail/' . Request::input('id'))
                      ->with('status',"แก้ไขข้อมูลลูกค้าชื่อ ". Request::input('name') ." สำเร็จ");
            } else {
              return redirect::to('edit_customer')
                      ->withInput(Request::except('password'))
                      ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถแก้ไขข้อมูลลูกค้าได้");
            }

        }else{
            return redirect::to('edit_customer')
                    ->withInput(Request::all())
                    ->withErrors($validate->messages());
        }

    }

}
