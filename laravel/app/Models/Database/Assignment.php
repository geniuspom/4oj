<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model{

    public $table = 'assignment';

    public function user(){
      return $this->belongsTo('App\Models\Member');
    }


}
