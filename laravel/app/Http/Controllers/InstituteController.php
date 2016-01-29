<?php
//namespace App\Http\Controllers;
use App\Models\institute as institute;

//Class InstituteController extends Controller{
    //public static function getinstitute(){

      $institute = institute::orderBy('symbol')->get();

      $institute_list = array();

      foreach ($institute as $record){
        $institute_list[] = $record->name;
      }

      echo json_encode($institute_list);

    //}
//}
?>
