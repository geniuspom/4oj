<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class office_salary extends Model{

    public $table = 'office_salary';

    public function user(){
      return $this->belongsTo('App\Models\Member');
    }

}
