<?php
namespace App\Http\Controllers\venue;
use App\Http\Controllers\Controller;

use App\Models\Database\venue_room as venue_room;

class AutoCompleteVenue extends Controller{

  public static function main(){

      $venue_room = venue_room::orderBy('room_name')->get();

      $user_list = array();

      foreach ($venue_room as $query){

          $venue_name = $query->venue->name;
          $room_name = $query->room_name;

          $full_name = $venue_name . " - " . $room_name;
          $room_id = $query->id;

          $rooom_list[] = "[". $room_id ."] " . $full_name;

      }

      echo json_encode($rooom_list);

  }

}
