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

}
