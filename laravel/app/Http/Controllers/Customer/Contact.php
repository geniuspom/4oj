<?php
namespace App\Http\Controllers\Customer;

use App\Models\contact_person as contact_person;
use App\Http\Controllers\Controller;
use App\Models\validatecontact as validatecontact;
use Illuminate\Support\Facades\Redirect;
use Request;
use Auth;

Class Contact extends Controller{

    public static function getcontact_person($id){
        $contact_person = contact_person::where('customer_id','=',$id)->get();
        $contact_data = "";

        foreach($contact_person as $contact){
          $contact_data .= Contact::contact_template($contact);
        }

        echo $contact_data;
    }

    public static function contact_template($data){
      $contact_template = "<div class='row'>
          <div class='col-lg-12'>
              <div class='panel panel-default'>
                  <div class='panel-heading'>
                    <h3 class='panel-title'>ผู้ประสานงาน - ". $data->name ."</h3>
                  </div>
                  <div class='panel-body'>
                    <div class='form-horizontal'>
                          <div class='form-group'>
                            <label class='col-md-5 text-right'>ชื่อผู้ประสานงาน</label>
                            <div class='col-md-6 text-info' >".
                                $data->name
                            ."</div>
                          </div>
                          <div class='form-group'>
                            <label class='col-md-5 text-right'>ตำแหน่ง</label>
                            <div class='col-md-6 text-info' >".
                                $data->position
                            ."</div>
                          </div>
                          <div class='form-group'>
                            <label class='col-md-5 text-right'>อีเมล</label>
                            <div class='col-md-6 text-info' >".
                                $data->email
                            ."</div>
                          </div>
                          <div class='form-group'>
                            <label class='col-md-5 text-right'>โทรศัพท์</label>
                            <div class='col-md-6 text-info' >".
                                $data->phone
                            ."</div>
                          </div>
                          <div class='form-group'>
                            <label class='col-md-5 text-right'>โทรศัพท์มือถือ</label>
                            <div class='col-md-6 text-info' >".
                                $data->mobile
                            ."</div>
                          </div>
                          <div class='form-group'>
                            <label class='col-md-5 text-right'>ข้อมูลเพิ่มเติม</label>
                            <div class='col-md-6 text-info' >".
                                $data->remark
                            ."</div>
                          </div>

                          <div class='form-group'>
                            <div class='col-md-6 col-md-offset-4'>
                              <a class='btn btn-primary' href='/4oj/edit_contact/" . $data->id . "'> แก้ไขข้อมูล </a>

                              <form style='display:inline;' role='form' method='POST' action='/4oj/delete_contact'>
                                <input type='hidden' name='_token' value='" . csrf_token() . "'>
                                <input type='hidden' name='contact_id' value='". $data->id ."'>

                                <button type='submit' class='btn btn-primary deletebutton' id='". $data->name ."' >
                                  ลบ
                                </button>

                              </form>


                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>";

          return $contact_template;

    }

    public static function add_contact(){

      //check input form
      $validate = validatecontact::validatecontact(Request::all());

      if($validate->passes()){
          $contact_person = new contact_person();
          $contact_person->name = Request::input('name');
          $contact_person->position = Request::input('position');
          $contact_person->email = Request::input('email');
          $contact_person->phone = Request::input('phone');
          $contact_person->mobile = Request::input('mobile');
          $contact_person->remark = Request::input('remark');
          $contact_person->customer_id = Request::input('customer_id');

          if($contact_person->save()) {
            return redirect::to('customer_detail/'.Request::input('customer_id'))
                    ->with('status',"เพิ่มผู้ประสานงานชื่อ ". Request::input('name') ." สำเร็จ");
          } else {
            return redirect::to('add_contact/'.Request::input('customer_id'))
                    ->withInput(Request::except('password'))
                    ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถเพิ่มผู้ประสานงานได้");
          }

      }else{
          return redirect::to('add_contact/'.Request::input('customer_id'))
              ->withInput(Request::all())
              ->withErrors($validate->messages());
      }

    }

    public static function edit_contact(){

      //check input form
      $validate = validatecontact::validatecontact(Request::all());

      if($validate->passes()){
          $contact_person = contact_person::where("id","=",Request::input('id'))->first();
          $customer_id = $contact_person->customer_id;

          $contact_person->name = Request::input('name');
          $contact_person->position = Request::input('position');
          $contact_person->email = Request::input('email');
          $contact_person->phone = Request::input('phone');
          $contact_person->mobile = Request::input('mobile');
          $contact_person->remark = Request::input('remark');
          $contact_person->customer_id = $customer_id;

          if($contact_person->save()) {
            return redirect::to('customer_detail/'.$customer_id)
                    ->with('status',"แก้ไขผู้ประสานงานชื่อ ". Request::input('name') ." สำเร็จ");
          } else {
            return redirect::to('edit_contact/'.Request::input('customer_id'))
                    ->withInput(Request::except('password'))
                    ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถแก้ไขผู้ประสานงานได้");
          }

      }else{
          return redirect::to('edit_contact/'.Request::input('customer_id'))
              ->withInput(Request::all())
              ->withErrors($validate->messages());
      }

    }

    public static function delete_contact(){

      $contact_person = contact_person::find(Request::input('contact_id'));
      $customer_id = $contact_person->customer_id;
      $name = $contact_person->name;

      if($contact_person->delete()){
        return redirect::to('customer_detail/'.$customer_id)
                ->with('status',"ลบผู้ประสานงานชื่อ ". $name ." สำเร็จ");
      }else{
        return redirect::to('edit_contact/'.Request::input('customer_id'))
                ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถลบผู้ประสานงานได้");
      }
    }


    public static function get_contact_in($id,$value){

      $customer = contact_person::where("id","=", $id)->first();

      $returndata = $customer->$value;

      return $returndata;

    }


}
