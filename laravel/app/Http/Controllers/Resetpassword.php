<?php
namespace App\Http\Controllers;
use App\Models\Member as Member;
use App\Models\bank as bank;
use App\Models\education as education;
use App\Models\validateuser as validateuser;
use App\Models\reset_pw as Reset;
use Illuminate\Support\Facades\Redirect;
use Route;
use Request;

Class Resetpassword extends Controller{

    public static function reset(){

      if(Request::input('rs_type') == "change"){

          $validate = validateuser::validatechangepass(Request::all());

          if($validate->passes()){

              $user = Member::where("id","=",Request::input('id'))->first();

              $dbpass = $user->password;

              $passcheck = \Hash::check(Request::input('old_password'), $dbpass);

              if($passcheck == TRUE){

                $user->password = \Hash::make(Request::input('password'));

                if($user->save()) {
                    return Redirect::to('user_profile')
                      ->with('status', 'Change password has been completed');
                }

              }else{
                return redirect()->back()
                  ->withErrors('Old Password is Wrong!');
              }

          }else{
              return redirect()->back()
                ->withErrors($validate->messages());
          }


      }else if(Request::input('rs_type') == "forgot"){

          $validate = validateuser::validateforgotpass(Request::all());

          if($validate->passes()){

              //get email from server
              $user = Member::where("id","=",Request::input('id'))->first();
              $email = $user->email;

              //get key from server
              $reset = Reset::where("email","=",$email)->first();
              $key = $reset->token;

              //Check email match
              if($email == Request::input('email')){

                //Check key match
                if($key == Request::input('key')){

                  $user->password = \Hash::make(Request::input('password'));

                  //Change completed
                  if($user->save()) {
                      return Redirect::to('login')
                        ->with('status', 'Change password has been completed');
                  }

                }else{
                  return redirect()->back()
                    ->withErrors('key is Wrong! Please resend forgot password.');
                }

              }else{
                return redirect()->back()
                  ->withErrors('email is Wrong!');
              }

          }else{
              return redirect()->back()
                ->withInput(Request::except('password'))
                ->withErrors($validate->messages());
          }

      }else{
          //Not match all
      }

    }

}
