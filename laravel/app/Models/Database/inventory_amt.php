<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class inventory_amt extends Model{

    public $table = 'inventory_amt';

    public function inventory(){
      return $this->belongsTo('App\Models\Database\inventory');
    }


}
