<?php
namespace App\Http\Controllers;

use App\Models\Member as Member;
use App\Models\validateuser as validateuser;
use App\Models\institute as institute;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Request;

Class LoginController extends Controller{

    public function register(Request $request){

        $validate = validateuser::validate(Request::all());

        //Generate validate code
        $validatecode = MD5(app('App\Http\Controllers\Sendmail')->generateRandomString());

        if($validate->passes()){

            $input_birthday = explode("/", Request::input('birthday'));
            $birthday = $input_birthday[2]."-".$input_birthday[1]."-".$input_birthday[0];


            $user = new Member();
            $user->email = $request::input('email');
            $user->password = \Hash::make($request::input('password'));
            $user->name = $request::input('name');
            $user->surname = $request::input('surname');
            $user->nickname = $request::input('nickname');
            $user->phone = $request::input('phone');
            $user->id_card = $request::input('id_card');

            $user->birthday = $birthday;

            //$user->bank = $request::input('bank');
            //$user->account_no = $request::input('account');
            //$user->education = $request::input('education');
            //$user->institute = $request::input('institute');
            //$user->reference = $request::input('reference');

            //$user->address = $request::input('address');
            //$user->province = $request::input('province');

            /*if($request::input('province') != 69){
              $user->district = 0;
            }else{
              $user->district = $request::input('district');
            }*/

            $user->userstatus = 1;
            $user->permission = 1;
            $user->validate = 1000;
            $user->email_valid_code = $validatecode;

            $link = '';

            if($user->save()) {
                $userinfo = $request::only('email','password');

                if(Auth::attempt($userinfo)){
                    $link = '/';
                }

                //ส่ง email

                app('App\Http\Controllers\Sendmail')->sendEmailReminder($request::input('name') . " " . $request::input('surname'),$request::input('email'),$validatecode);

                //จบส่ง email

            } else {
                $link = 'register';
            }

            //ตรวจสอบสถาบันว่ามีไหมถ้าไม่มีให้เพิ่มไป
            /*$countinstitute = institute::where('name', 'LIKE', $request::input('institute'))->count();

            if($countinstitute < 1){
                $institute = new institute();
                $institute->name = $request::input('institute');
                $institute->save();
            }*/
            //จบตรวจสอบสถาบันว่ามีไหมถ้าไม่มีให้เพิ่มไป

            return Redirect::to($link);

        }else{
            return redirect::to('register')
                    ->withInput(Request::except('password'))
                    ->withErrors($validate->messages());
        }

    }

    public function login(Request $request){
        $userinfo = $request::only('email','password');
        if(Auth::attempt($userinfo)){
            return Redirect::to('/');
        }else{
            return redirect()->back()
                    ->with('message',"Error!! Username or Password Incorrect. \nPlease try again.")
                    ->withInput(Request::except('password'));
        }
    }

    public function logout(){

        Auth::logout();
        return Redirect::to('login');
    }

    public function checklogin(){
        if(Auth::check()){
            return Redirect::to('/');
        }else{
            return View('Member.Login');
        }
    }

    public static function checkadmin(){

        $user = Member::where("id","=",Auth::user()->id)->first();

        $permission = $user->permission;

        return $permission;

    }

    public static function checkpermission($level){

      $user = Member::where("id","=",Auth::user()->id)->first();

      $permission = $user->permission;

      if($permission >= $level){
        return true;
      }else{
        return false;
      }

    }

    public function index(){
  		  return view('Member.dashboard');
  	}

    public function activate(){

        $activatecode = Request::input('activatecode');

        $count = Member::where('email_valid_code', '=', $activatecode)->count();

        //found activate code
        if($count == 1){

          $user = Member::where('email_valid_code', '=', $activatecode)->first();

          $user->validate = 1100;
          $user->email_valid_code = NULL;

          if($user->save()){
            return redirect::to('login')
                ->with('status',"Your account has been activated.");
          }

        //not found activate code
        }else{


          return redirect::to('login')
                ->with('message',"Activate code is wrong! Please contact administrator.");


        }

    }

    public static function checkstatususer(){

        $user = Member::where("id","=",Auth::user()->id)->first();

        $u_status = $user->validate;
        $mail_st = substr($u_status, 1,1);
        $id_st = substr($u_status, 2,1);

        $data = "";

        if($mail_st == 0 || $id_st == 0){

          $data .= "<div id='popup' class='container'>
            <div class='popup_bg'></div>
          	<div class='row'>
          		<div class='col-md-8 col-md-offset-2' id='popup_msg'>
                <div class='text-right'>
                  <span id='close_popup' class='glyphicon glyphicon-remove'></span>
                </div>";

          if($mail_st == 0){

              $data .= "<div class='text-center text-warning' style='padding:15px;'>
                        <p>คุณยังไม่ได้ยืนยันอีเมล กรุณายืนยันอีเมลก่อนคุณจึงสามารถใช้งานระบบได้
                        <br>
                        หากไม่ได้รับอีเมลกรุณากดที่ปุ่มด้านล่างเพื่อทำการส่งอีเมลอีกครั้ง
                        </p>
                        <a type='submit' class='btn btn-warning' href='send_email_verify'>
                           ส่งอีเมลเพื่อทำการยืนยันอีเมล์
                        </a>
                        </div>";

          }

          if($id_st == 0){

              $data .= "<div class='text-center text-warning' style='padding:15px;'>
                        <p>คุณยังไม่ได้ส่งเอกสารสำเนาบัตรประชาชน กรุณาส่งเอกสารสำเนาบัตรประชาชนก่อนจึงใช้งานระบบได้
                        </p>
                        <a type='submit' class='btn btn-warning' href='user_profile'>
                           ส่งเอกสารสำเนาบัตรประชาชน
                        </a>
                        </div>";

          }

          $data .= "</div>
                      </div>
                    </div>";

        }

        echo $data;


    }

    public static function checkverifyuser(){

      $user = Member::where("id","=",Auth::user()->id)->first();

      $u_status = $user->validate;
      $mail_st = substr($u_status, 1,1);
      $id_st = substr($u_status, 2,1);

      if($mail_st == 1 && $id_st == 1){
          return true;
      }else{
          return false;
      }

    }

}
