<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class event extends Model{

    public $table = 'event';

    public function user(){
      return $this->belongsToMany('App\Models\Database\user','assignment');
    }

}
