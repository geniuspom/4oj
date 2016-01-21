<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class validaterequestjob extends Model {

    public static function validaterequestjob($input){

    $rules = array(
        'request_name' => 'Required|Between:5,255',
        'start_date' => 'Required',
        'end_date' => 'Required',
    );

        return Validator::make($input, $rules);
    }

    /*public static function validateeditrequestjob($input){

    $rules = array(
      'name' => 'Required|Between:5,255',
      'address' => 'Required',
      'phone' => 'Required|Numeric',
      //'area' => 'Required',
    );

        return Validator::make($input, $rules);
    }*/

}
