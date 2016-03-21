<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class event extends Model{

    public $table = 'event';

    public function user(){
      return $this->belongsToMany('App\Models\Database\user','assignment')->withPivot('position');
    }

    public function customer(){
      return $this->belongsTo('App\Models\customer');
    }

    public function venue(){
      return $this->belongsTo('App\Models\Database\venue_room');
    }

    public function customer_contact(){
      return $this->belongsTo('App\Models\contact_person','custumer_contact_id','id');
    }

    public function oj_contact(){
      return $this->belongsTo('App\Models\Member','staff_contact_id','id');
    }

}
