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
    public static function generateRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function sendEmailReminder($name,$email,$validatecode){

      $link = 'http://www.ojconsultinggroup.com/4oj/activate/'. $validatecode;
      $data = ['email'=>$email,'name'=>$name,'link'=>$link,'validatecode'=>$validatecode,'subject'=>'Validate your account!'];

      Mail::queue('member.mailvalidate',$data,function ($message) use ($data) {
        $message->to($data['email'])->subject($data['subject']);
      });

    }

    public function sendEmailForgot(){

        $validate = validateuser::validateforgot(Request::all());

        if($validate->passes()){

            $count = Member::where('email', '=', Request::input('email'))->count();

            if($count == 1){

                $forgot_code = sendmail::generateRandomString();
                $sforgot_code = MD5($forgot_code);

                $countforgot = Reset::where('email', '=', Request::input('email'))->count();

                if($countforgot == 1){
                  $reset = Reset::where("email","=",Request::input('email'))->first();
                  $reset->token = $sforgot_code;
                  $reset->save();
                }else{
                  $reset = new Reset();
                  $reset->email = Request::input('email');
                  $reset->token = $sforgot_code;
                  $reset->save();
                }

                $profiles = Member::where('email', '=', Request::input('email'))->get();

                foreach ($profiles as $record){
                  $name = $record->name;
                  $id = $record->id;
                }

                $email = Request::input('email');
                $link = 'http://www.ojconsultinggroup.com/4oj/reset/'. $id . '/token/' . $sforgot_code;
                $data = array('code'=>$sforgot_code,'name'=>$name,'link'=>$link);

                Mail::queue('Member.mailforgot', $data, function ($message) use ($email,$data) {

                    $message->to($email)->subject('Your Password Reset Link!');

                });

                return Redirect::to('forgot')
                  ->with('status', 'อีเมลสำหรับตั้งรหัสผ่านใหม่ได้ถูกส่งไปแล้ว');

            }else{
                $msg = "เกิดข้อผิดพลาด! ไม่พบชื่ออีเมลนี้ในระบบ";

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
