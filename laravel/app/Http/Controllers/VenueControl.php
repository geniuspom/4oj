<?php
namespace App\Http\Controllers;

use App\Models\venue as venue;
use App\Models\validatevenue as validatevenue;
use Illuminate\Support\Facades\Redirect;
use Request;

Class VenueControl extends Controller{

    //get customer
    public static function get($id,$value){

        $venue = venue::where("id","=", $id)->first();

        $returndata = $venue->$value;

        echo $returndata;

    }

    //get all customer
    public static function getall(){

        $venue = venue::orderBy('name')->get();

        foreach ($venue as $record){

          echo "<tr><td class='text-center'><a href='venue_detail/".
                $record->id .
                "'>" .
                $record->name .
                "</a></td><td>".
                $record->address .
                "</td><td class='text-center'>".
                $record->phone .
                "</td><td class='text-center'>".
                $record->area .
                "</td><td class='text-center'><a href='edit_venue/".
                $record->id .
                "'><img src='/4oj/public/image/file_edit.png' width='20px' /></a></td><tr>";
        }

    }

    //add
    public function add(){

        //check input form
        $validate = validatevenue::validatevenue(Request::all());

        if($validate->passes()){
            $venue = new venue();
            $venue->name = Request::input('name');
            $venue->address = Request::input('address');
            $venue->phone = Request::input('phone');
            $venue->area = Request::input('area');

            if($venue->save()) {
              return redirect::to('venue')
                      ->with('status',"เพิ่มสถานที่จัดงานชื่อ ". Request::input('name') ." สำเร็จ");
            } else {
              return redirect::to('add_venue')
                      ->withInput(Request::except('password'))
                      ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถเพิ่มลูกค้าได้");
            }

        }else{
            return redirect::to('add_venue')
                ->withInput(Request::all())
                ->withErrors($validate->messages());
        }

    }

    //edit
    public function edit(){

        //check input form
        $validate = validatevenue::validateeditvenue(Request::all());

        if($validate->passes()){
            $venue = venue::where("id","=",Request::input('id'))->first();
            $venue->name = Request::input('name');
            $venue->address = Request::input('address');
            $venue->phone = Request::input('phone');
            $venue->area = Request::input('area');

            if($venue->save()) {
              return redirect::to('venue_detail/' . Request::input('id'))
                      ->with('status',"แก้ไขข้อมูลสถานที่จัดงาน ". Request::input('name') ." สำเร็จ");
            } else {
              return redirect::to('edit_venue')
                      ->withInput(Request::except('password'))
                      ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถแก้ไขข้อมูลลูกค้าได้");
            }

        }else{
            return redirect::to('edit_venue')
                    ->withInput(Request::all())
                    ->withErrors($validate->messages());
        }

    }

}