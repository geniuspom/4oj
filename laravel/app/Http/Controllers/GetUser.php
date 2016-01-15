<?php
namespace App\Http\Controllers;
use App\Models\Member as Member;
use App\Models\bank as bank;
use App\Models\education as education;
use App\Models\validateuser as validateuser;
use Illuminate\Support\Facades\Redirect;
use Route;
use Request;

Class GetUser extends Controller{

    public static function getuser($id){

        $profiles = Member::where('id', '=', $id)->get();

        foreach ($profiles as $record){
          $user = [
            'name' => $record->name ,
            'surname' => $record->surname
          ];
        }

        echo $user["name"] . " " .$user["surname"];
    }

    public static function admingetuser($filter){
        $data = Member::orderBy('id')->get();

        foreach ($data as $record){
          $u_status = $record->validate;
          $mail_st = substr($u_status, 1,1);
          $id_st = substr($u_status, 2,1);
          $id_valid = substr($u_status, 3,1);
          echo "<tr><td class='text-center'>".
                $record->id .
                "</td><td>".
                $record->name . " " . $record->surname .
                "</td><td>".
                $record->email .
                "</td><td class='text-center'>".
                $record->phone .
                "</td><td class='text-center'>";
                //check validate email
                if($mail_st == 1){
                  echo "<img src='/4oj/public/image/email-valid.png' width='20px' />";
                }else{
                  echo "<img src='/4oj/public/image/email-not.png' width='20px' />";
                }
                //check id card status
                if($id_st == 1 && $id_valid == 1){
                  echo "<img src='/4oj/public/image/id-valid.png' width='20px' />";
                }else if($id_st == 1 && $id_valid == 0){
                  echo "<img src='/4oj/public/image/id-not.png' width='20px' />";
                }
          echo  "</td><td class='text-center'><a href='useredit/".
                $record->id .
                "'><img src='/4oj/public/image/file_edit.png' width='20px' /></a></td><tr>";
        }

    }

    public static function getedituser($id,$value){
        $profiles = Member::where('id', '=', $id)->get();
        foreach ($profiles as $record){
          $vdata = $record->$value;
        }

        if($value == 'education'){
          $education = education::orderBy('id')->get();

          echo "<select name='education' id='education' class='form-control'>";
              foreach ($education as $recode){
                  echo "<option value='".$recode->id."'" ;
                      if ($vdata == $recode->id){
                          echo " selected='selected'";
                      }
                  echo ">".$recode->name."</option>";
              }
          echo "</select>";
        }else if($value == 'bank'){
          $bank = bank::orderBy('name')->get();

          echo "<select name='bank' id='bank' class='form-control'>";
              foreach ($bank as $recode){
                  echo "<option value='".$recode->id."'" ;
                      if ($vdata == $recode->id){
                          echo " selected='selected'";
                      }
                  echo ">".$recode->name."</option>";
              }
          echo "</select>";
        }else{
          echo $vdata;
        }
    }

    public static function getprofile($id,$value){

        $profiles = Member::where('id', '=', $id)->get();

        foreach ($profiles as $record){
          $vdata = $record->$value;
        }

        if($value == 'education'){
          $education = education::orderBy('id')->get();

          foreach ($education as $recode){
              if ($vdata == $recode->id){
                echo $recode->name;
              }
          }
        }else if($value == 'bank'){
          $bank = bank::orderBy('id')->get();

          foreach ($bank as $recode){
              if ($vdata == $recode->id){
                echo $recode->name;
              }
          }
        }

    }

    //Update user value
    public static function updateuser(){
      $validate = validateuser::validateupdateuser(Request::all());

      if($validate->passes()){
          $user = Member::where("id","=",Request::input('id'))->first();
          $user->name = Request::input('name');
          $user->surname = Request::input('surname');
          $user->nickname = Request::input('nickname');
          $user->phone = Request::input('phone');
          $user->bank = Request::input('bank');
          $user->account_no = Request::input('account');
          $user->education = Request::input('education');
          $user->institute = Request::input('institute');
          $user->reference = Request::input('reference');

          if($user->save()) {
              $userinfo = Request::only('email','password');
              return Redirect::to('useredit/'. Request::input('id'))
                ->with('status', 'Update has been completed');
          } else {
              return Redirect::to('useredit/'. Request::input('id'))
                ->withErrors('Error some thing is wrong!');
          }

      }else{
          return redirect::to('useredit/'. Request::input('id'))
                  ->withInput(Request::except('password'))
                  ->withErrors($validate->messages());
      }
    }

}
