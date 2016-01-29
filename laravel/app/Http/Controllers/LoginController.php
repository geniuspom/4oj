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
            $user = new Member();
            $user->email = $request::input('email');
            $user->password = \Hash::make($request::input('password'));
            $user->name = $request::input('name');
            $user->surname = $request::input('surname');
            $user->nickname = $request::input('nickname');
            $user->phone = $request::input('phone');
            $user->id_card = $request::input('id_card');
            $user->bank = $request::input('bank');
            $user->account_no = $request::input('account');
            $user->education = $request::input('education');
            $user->institute = $request::input('institute');
            $user->reference = $request::input('reference');
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
            $countinstitute = institute::where('name', 'LIKE', $request::input('institute'))->count();

            if($countinstitute < 1){
                $institute = new institute();
                $institute->name = $request::input('institute');
                $institute->save();
            }
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

}
