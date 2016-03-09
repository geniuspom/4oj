<?php
namespace App\Http\Controllers;

use Mail;
use Request;
use App\Models\validateuser as validateuser;
use App\Models\Member as Member;
use App\Models\reset_pw as Reset;
use Redirect;

class Sendverify extends Controller{

    public static function sendEmailReminder($name,$email,$validatecode){

      $link = 'http://www.ojconsultinggroup.com/4oj/activate/'.$validatecode;
      $data = ['email'=>$email,'name'=>$name,'link'=>$link,'validatecode'=>$validatecode,'subject'=>'Validate your account!'];

    /*  Mail::queue('member.mailvalidate',$data,function ($message) use ($data) {
        $message->to($data['email'])->subject($data['subject']);
      });
*/
    Mail::queue('Member.mailvalid', $data , function ($message) use($email,$data){
      $message->to($email)->subject($data['subject']);
    });

    }

}
