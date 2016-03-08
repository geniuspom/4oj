<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticable as AuthenticableTrait;

class urllogin extends Model implements Authenticatable{

  public function getRememberToken(){
    return $this->remember_token;
  }

  public function setRememberToken($value){
    $this->remember_token = $value;
  }

  public function getRememberTokenName(){
    return 'remember_token';
  }

  public function getAuthIdentifier() {
    return $this->id;
  }

  public function getAuthPassword(){
    return $this->password;
  }

  public $table = 'users';

}
