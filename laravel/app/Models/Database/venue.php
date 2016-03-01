<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class venue extends Model{

    public $table = 'venue';

    public function venue_room(){
      return $this->hasMany('App\Models\Database\venue_room');
    }

    public function venue_area(){
      return $this->belongsTo('App\Models\Database\venue_area');
    }

}
