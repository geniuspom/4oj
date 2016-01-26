<?php
namespace App\Http\Controllers;
use App\Models\bank as bank;
use App\Models\education as education;
use App\Models\customer as customer;
use App\Models\venue as venue;
use App\Models\event as event;

Class Getdataform extends Controller{
    public static function getbank($id){

        $bank = bank::orderBy('name')->get();

        echo "<select name='bank' id='bank' class='form-control'>";
            foreach ($bank as $recode){
                echo "<option value='".$recode->id."'" ;
                    if ($id == $recode->id){
                        echo " selected='selected'";
                    }
                echo ">".$recode->name."</option>";
            }
        echo "</select>";
    }

    public static function geteducation($id){

        $education = education::orderBy('id')->get();

        echo "<select name='education' id='education' class='form-control'>";
            foreach ($education as $recode){
                echo "<option value='".$recode->id."'" ;
                    if ($id == $recode->id){
                        echo " selected='selected'";
                    }
                echo ">".$recode->name."</option>";
            }
        echo "</select>";
    }

    public static function getcustomer($id,$type){

        if($type == 'edit'){
          $event = event::where("id","=", $id)->first();
          $id = $event->customer_id;
        }

        $customer = customer::orderBy('symbol')->get();

        echo "<select name='customer_id' id='customer_id' class='form-control'>";
            foreach ($customer as $recode){
                echo "<option value='".$recode->id."'" ;
                    if ($id == $recode->id){
                        echo " selected='selected'";
                    }
                echo ">".$recode->symbol. " - " .$recode->name."</option>";
            }
        echo "</select>";
    }

    public static function getvenue($id,$type){

      if($type == 'edit'){
        $event = event::where("id","=", $id)->first();
        $id = $event->venue_id;
      }

        $venue = venue::orderBy('name')->get();

        echo "<select name='venue_id' id='venue_id' class='form-control'>";
            foreach ($venue as $recode){
                echo "<option value='".$recode->id."'" ;
                    if ($id == $recode->id){
                        echo " selected='selected'";
                    }
                echo ">".$recode->name."</option>";
            }
        echo "</select>";
    }

    public static function meeting_period($id,$type){

        $periods = array(
                      "1" => "ทั้งวัน",
                      "2" => "เช้า",
                      "3" => "บ่าย"
              );

        if($type == 'form'){

          echo "<select class='form-control' id='meeting_period' name='meeting_period'>";
              foreach ($periods as $period => $value){
                  echo "<option value='".$period."'" ;
                      if ($id == $period){
                          echo " selected='selected'";
                      }
                  echo ">".$value."</option>";
              }
          echo "</select>";

        }else if($type == 'edit'){
          $event = event::where("id","=", $id)->first();
          $id = $event->meeting_period;

          echo "<select class='form-control' id='meeting_period' name='meeting_period'>";
              foreach ($periods as $period => $value){
                  echo "<option value='".$period."'" ;
                      if ($id == $period){
                          echo " selected='selected'";
                      }
                  echo ">".$value."</option>";
              }
          echo "</select>";

        }else{
            foreach ($periods as $period => $value){
                if ($id == $period){
                  return $value;
                }
            }
        }
    }

    public static function event_status($id,$type){

      $periods = array(
                "1" => "กำลังเปิดรับ" ,
                "2" => "เต็มแล้ว" ,
                "3" => "เลื่อนการประชุม" ,
                "4" => "จบแล้ว"
            );


        if($type == 'form'){

          echo "<select class='form-control' id='event_status' name='event_status'>";
              foreach ($periods as $period => $value){
                  echo "<option value='".$period."'" ;
                      if ($id == $period){
                          echo " selected='selected'";
                      }
                  echo ">".$value."</option>";
              }
          echo "</select>";

        }else if($type == 'edit'){
          $event = event::where("id","=", $id)->first();
          $id = $event->event_status;

          echo "<select class='form-control' id='event_status' name='event_status'>";
              foreach ($periods as $period => $value){
                  echo "<option value='".$period."'" ;
                      if ($id == $period){
                          echo " selected='selected'";
                      }
                  echo ">".$value."</option>";
              }
          echo "</select>";

        }else{

          foreach ($periods as $period => $value){
              if ($id == $period){
                return $value;
              }
          }
        }

    }

    public static function event_type($id,$type){

      $event_types = array(
                "1" => "AGM" ,
                "2" => "EGM" ,
                "3" => "Etc."
            );


        if($type == 'form'){

          echo "<select class='form-control' id='event_type' name='event_type'>";
              foreach ($event_types as $event_type => $value){
                  echo "<option value='".$event_type."'" ;
                      if ($id == $event_type){
                          echo " selected='selected'";
                      }
                  echo ">".$value."</option>";
              }
          echo "</select>";

        }else if($type == 'edit'){
                $event = event::where("id","=", $id)->first();
                $id = $event->event_type;

                echo "<select class='form-control' id='event_type' name='event_type'>";
                    foreach ($event_types as $event_type => $value){
                        echo "<option value='".$event_type."'" ;
                            if ($id == $event_type){
                                echo " selected='selected'";
                            }
                        echo ">".$value."</option>";
                    }
                echo "</select>";

        }else{

          foreach ($event_types as $event_type => $value){
              if ($id == $event_type){
                return $value;
              }
          }
        }

    }


}
