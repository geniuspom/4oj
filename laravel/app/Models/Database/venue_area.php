<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class venue_area extends Model{

    public $table = 'venue_area';

    public function venue(){
      return $this->hasMany('App\Models\Database\venue');
    }


}
