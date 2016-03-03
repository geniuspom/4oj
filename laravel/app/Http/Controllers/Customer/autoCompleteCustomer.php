<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;

use App\Models\customer as customer;

class autoCompleteCustomer extends Controller{

  public static function main(){

      $Customer = customer::orderBy('symbol')->get();

      $customer_list = array();

      foreach ($Customer as $query){

          $full_name = $query->symbol . " - " . $query->name;
          $customer_id = $query->id;

          $customer_list[] = "[". $customer_id ."] " . $full_name;

      }

      echo json_encode($customer_list);

  }

}
