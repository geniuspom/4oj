<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class validatecontact extends Model {

    public static function validatecontact($input){

    $rules = array(
        'name' => 'Required|Between:5,255',
        'phone' => 'Required|Numeric',
    );

        return Validator::make($input, $rules);
    }

}
