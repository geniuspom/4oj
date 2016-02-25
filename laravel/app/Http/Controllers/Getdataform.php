<?php
namespace App\Http\Controllers;
use App\Models\bank as bank;
use App\Models\education as education;
use App\Models\customer as customer;
use App\Models\venue as venue;
use App\Models\event as event;
use App\Models\Member as Member;
use App\Models\province as province;
use App\Models\district as district;

Class Getdataform extends Controller{
    public static function getbank($id){

        $bank = bank::orderBy('name')->get();

        echo "<select name='bank' id='bank' class='form-control'>";
            foreach ($bank as $recode){
                echo "<option value='".$recode->id."'" ;
                    if ($id == $recode->id){
                        echo " selected='selected'";
                    }else if(empty($id) && ($recode->id == 3)){
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

        echo "<select name='customer_id' id='customer_id' class='form-control'><option value='0'>none</option>";
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
                "3" => "Etc.",
                "4" => "อบรมการทำงาน",
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

    public static function getuserform($id,$type){
      $user = Member::orderBy('name')->get();

      if($type == 'edit'){
        $event = event::where("id","=", $id)->first();
        $id = $event->staff_contact_id;
      }

      echo "<select name='staff_contact_id' id='staff_contact_id' class='form-control'>";
          foreach ($user as $recode){
              echo "<option value='".$recode->id."'" ;
                  if ($id == $recode->id){
                      echo " selected='selected'";
                  }
              echo ">".$recode->nickname." - ".$recode->name." ".$recode->surname."</option>";
          }
      echo "</select>";
    }

    public static function province($id,$type){

        if($type == 'edit'){
          $user = Member::where("id","=", $id)->first();
          $id = $user->province;
        }

        $province = province::orderBy('name')->get();

        echo "<select name='province' id='province' class='form-control'><option value='0'>none</option>";
            foreach ($province as $recode){
                echo "<option value='".$recode->id."'" ;
                    if ($id == $recode->id){
                        echo " selected='selected'";
                    }
                echo ">".$recode->name."</option>";
            }
        echo "</select>";
    }

    public static function district($id,$type){

        if($type == 'edit'){
          $user = Member::where("id","=", $id)->first();
          $id = $user->district;
        }

        $district = district::orderBy('name')->get();

        echo "<select name='district' id='district' class='form-control'><option value='0'>none</option>";
            foreach ($district as $recode){
                echo "<option value='".$recode->id."'" ;
                    if ($id == $recode->id){
                        echo " selected='selected'";
                    }
                echo ">".$recode->name."</option>";
            }
        echo "</select>";
    }



}
