<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class validateevent extends Model {

    public static function validateevent($input){

    $rules = array(
        'event_name' => 'Required|Between:5,255',
        'customer_id' => 'Required',
        'event_type' => 'Required',
        'event_date' => 'Required',
        'venue_id' => 'Required',
        'register_point' => 'Required|Numeric',
        'summary_point' => 'Required|Numeric',
        'stert_time' => 'Required',
        'register_time' => 'Required',
        'setup_time' => 'Required',
        'staff_appointment_time' => 'Required',
        'supplier_time' => 'Required',
        //'custumer_contact_name' => 'Between:5,255',
        //'custumer_contact_phone' => 'Numeric',
        'hotel_contact_name' => 'Between:5,255',
        'hotel_contact_phone' => 'Numeric',
        'supplier_contact_name' => 'Between:5,255',
        'supplier_contact_phone' => 'Numeric',
        //'staff_contact_name' => 'Between:5,255',
        //'staff_contact_phone' => 'Numeric',
        'meeting_period' => 'Required',
        //'event_status' => 'Required|Between:5,255|Unique:customer',
    );

        return Validator::make($input, $rules);
    }

}
