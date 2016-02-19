<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class venue_room extends Model{

    public $table = 'venue_room';

    public function venue(){
      return $this->belongsTo('App\Models\Database\venue');
    }


}
