<?php
namespace App\Http\Controllers;

use Mail;
//use App\Http\Controllers\Controller;
use Request;
use App\Models\validateuser as validateuser;
use App\Models\Member as Member;
use App\Models\reset_pw as Reset;
use Redirect;

class sendmail extends Controller{

    //gen code
    public function generateRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function sendEmailReminder(){


        if($validate->passes()){

            $count = Member::where('email', '=', Request::input('email'))->count();

            if($count == 1){

                $forgot_code = sendmail::generateRandomString();
                $sforgot_code = MD5($forgot_code);

                Mail::send('Member.mailvalidate', array('code'=>$sforgot_code), function ($message) {

                    $message->to(Request::input('email'))->subject('Your Reminder!');

                });

                return Redirect::to('/');

            }else{
                $msg = "Not found email!";

                return Redirect::to('forgot')
                    ->withInput(Request::except('password'))
                    ->withErrors($msg);
            }

        }else{
            return Redirect::to('forgot')
                    ->withInput(Request::except('password'))
                    ->withErrors($validate->messages());
        }

    }

    public function sendEmailForgot(){

        $validate = validateuser::validateforgot(Request::all());

        if($validate->passes()){

            $count = Member::where('email', '=', Request::input('email'))->count();

            if($count == 1){

                $forgot_code = sendmail::generateRandomString();
                $sforgot_code = MD5($forgot_code);

                $reset = new Reset();
                $reset->email = Request::input('email');
                $reset->token = $sforgot_code;
                $reset->save();

                $profiles = Member::where('email', '=', Request::input('email'))->get();

                foreach ($profiles as $record){
                  $name = $record->name;
                }

                $link = 'http://localhost/4oj/reset?token=' . $sforgot_code;

                Mail::send('Member.mailforgot', array('code'=>$sforgot_code,'name'=>$name,'link'=>$link), function ($message) {

                    $message->to(Request::input('email'))->subject('Your Password Reset Link!');

                });

                return Redirect::to('/');

            }else{
                $msg = "Not found email!";

                return Redirect::to('forgot')
                    ->withInput(Request::except('password'))
                    ->withErrors($msg);
            }

        }else{
            return Redirect::to('forgot')
                    ->withInput(Request::except('password'))
                    ->withErrors($validate->messages());
        }

    }

}
