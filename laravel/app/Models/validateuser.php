<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class validateuser extends Model {

    public static function validate($input){

    $rules = array(
        'name' => 'Required',
        'surname' => 'Required',
        'nickname' => 'Required',
        'email' => 'Required|Between:3,64|Email|Unique:users',
        'password' => 'Required|AlphaNum|Between:6,16|Confirmed',
        'password_confirmation' => 'Required|AlphaNum|Between:6,16',
        'phone' => 'Required|Numeric',
        'id_card' => 'Required|Numeric|digits:13|Unique:users'
    );

        return Validator::make($input, $rules);
    }

    public static function validateforgot($input){

        $rules = array(
            'email' => 'Required|Between:3,64|Email'
        );

        return Validator::make($input, $rules);

    }

    public static function validateupdateuser($input){

    $rules = array(
        'name' => 'Required',
        'surname' => 'Required',
        'nickname' => 'Required',
        'phone' => 'Required|Numeric'
    );

        return Validator::make($input, $rules);
    }

    public static function validatechangepass($input){

      $rules = array(
          'old_password' => 'Required|AlphaNum|Between:6,16',
          'password' => 'Required|AlphaNum|Between:6,16|Confirmed',
          'password_confirmation' => 'Required|AlphaNum|Between:6,16',
      );

          return Validator::make($input, $rules);
      }

    public static function validateforgotpass($input){

      $rules = array(
          'email' => 'Required|Between:3,64|Email',
          'password' => 'Required|AlphaNum|Between:6,16|Confirmed',
          'password_confirmation' => 'Required|AlphaNum|Between:6,16',
      );

          return Validator::make($input, $rules);

    }



}
