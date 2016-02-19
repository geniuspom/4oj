<?php
namespace App\Http\Controllers\venue;
use App\Models\Database\venue_room as venue_room;
use App\Models\event as event;
use App\Http\Controllers\Controller;
use Request;

Class venue_room_control extends Controller{

  public static function main(){

  }

  public static function venue_form($id,$type){

    if($type == 'edit_event'){
      $event = event::where("id","=", $id)->first();
      $id = $event->venue_id;
    }

    $venue_room = venue_room::orderBy('room_name')->get();

    $returndata = "<select name='venue_id' id='venue_id' class='form-control'>";

    foreach ($venue_room as $query){

        $venue_name = $query->venue->name;
        $room_name = $query->room_name;

        $full_name = $venue_name . " - " . $room_name;
        $room_id = $query->id;

        $returndata .= "<option value='".$room_id."'" ;
            if ($id == $room_id){
                $returndata .= " selected='selected'";
            }
        $returndata .= ">".$full_name."</option>";


    }

    $returndata .= "</select>";

    echo $returndata;

  }

  public static function venue_detail($id,$type){

    $event = event::where("id","=", $id)->first();
    $id = $event->venue_id;

    $venue_room = venue_room::where('id','=',$id)->first();

    $venue_name = $venue_room->venue->name;
    $room_name = $venue_room->room_name;
    $venue_id = $venue_room->venue->id;

    $full_name = $venue_name . " - " . $room_name;

    if($type == "link"){
      $returndata = "<a href='venue_detail/".$venue_id."'>".$full_name."</a>";
      return $returndata;
    }else{
      $returndata = $full_name;
      echo $returndata;
    }


  }

}
