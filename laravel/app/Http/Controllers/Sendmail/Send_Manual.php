<?php
namespace App\Http\Controllers\Sendmail;
use Mail;
use App\Models\Member as Member;
use App\Http\Controllers\Controller;
use Request;

Class Send_Manual extends Controller{

    public static function main(){

        $Subject = Request::input('subject');
        $Text = Request::input('text');

        $user = Member::get();

        if(isset($user)){

            foreach($user as $record){

              $email[] = $record->email;
            }

        }

        $root_url = dirname($_SERVER['PHP_SELF']);
        $Host_name = $_SERVER['HTTP_HOST'];

        $link = "http://www.ojconsultinggroup.com/" . $root_url;

        if(isset($email) && !empty($email)){

          Mail::send('sendmail.Mail_template', array('subject'=>$Subject,'text'=>$Text,'link'=>$link), function ($message) use ($email,$Subject) {

              $message->to($email)->subject($Subject);

          });

          if( count(Mail::failures()) > 0 ) {
              $arr = array("status"=>"fail",);
              return json_encode($arr);
          } else {
              $arr = array("status"=>"success",);
              return json_encode($arr);
          }

        }else{
          $arr = array("status"=>"fail",);
          return json_encode($arr);
        }

    }

}
