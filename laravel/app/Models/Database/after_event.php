<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class after_event extends Model{

    public $table = 'after_event';

    public function event(){
      return $this->belongsTo('App\Models\event');
    }

}
