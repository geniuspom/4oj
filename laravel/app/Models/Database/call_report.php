<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class call_report extends Model{

    public $table = 'call_report';

    public function createdby(){
      return $this->belongsTo('App\Models\Database\user','created_by','id');
    }

    public function assingto(){
      return $this->belongsTo('App\Models\Database\user','assigned_id','id');
    }

    public function customer(){
      return $this->belongsTo('App\Models\customer','customer_id','id');
    }

}
