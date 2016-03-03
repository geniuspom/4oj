<?php
namespace App\Http\Controllers\MainControllers;
use App\Http\Controllers\Controller;
use Request;

Class Date_time extends Controller{

  public static function convert_to_thai_format($date){

    $date = explode(" ", $date);

    $split_date = explode("-", $date[0]);

    $return_date = $split_date[2]." ".Date_time::get_month_thai($split_date[1])." ".Date_time::get_BE_year($split_date[0]);

    return $return_date;

  }

  public static function get_BE_year($year){
      $BE_year = $year+543;

      return $BE_year;
  }

  public static function get_month_thai($month){

    $thai_month = "";

    switch ($month) {
      case 1:
          $thai_month = "มกราคม";
          break;
      case 2:
          $thai_month = "กุมภาพันธ์";
          break;
      case 3:
          $thai_month = "มีนาคม";
          break;
      case 4:
          $thai_month = "เมษายน";
          break;
      case 5:
          $thai_month = "พฤษภาคม";
          break;
      case 6:
          $thai_month = "มิถุนายน";
          break;
      case 7:
          $thai_month = "กรกฎาคม";
          break;
      case 8:
          $thai_month = "สิงหาคม";
          break;
      case 9:
          $thai_month = "กันยายน";
          break;
      case 10:
          $thai_month = "ตุลาคม";
          break;
      case 11:
          $thai_month = "พฤศจิกายน";
          break;
      case 12:
          $thai_month = "ธันวาคม";
          break;

    }


    return $thai_month;

  }



}
