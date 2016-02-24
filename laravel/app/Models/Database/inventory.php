<?php namespace App\Models\Database;
use Illuminate\Database\Eloquent\Model;

class inventory extends Model{

    public $table = 'inventory';

    public function inventory_amt(){
      return $this->hasMany('App\Models\Database\inventory_amt');
    }
}
