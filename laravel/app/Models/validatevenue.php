<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class validatevenue extends Model {

    public static function validatevenue($input){

    $rules = array(
        'name' => 'Required|Between:5,255|Unique:venue',
        'address' => 'Required',
        'phone' => 'Required|Numeric',
        //'area' => 'Required',
    );

        return Validator::make($input, $rules);
    }

    public static function validateeditvenue($input){

    $rules = array(
      'name' => 'Required|Between:5,255',
      'address' => 'Required',
      'phone' => 'Required|Numeric',
      //'area' => 'Required',
    );

        return Validator::make($input, $rules);
    }

}
