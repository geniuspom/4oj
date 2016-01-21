<?php
namespace App\Http\Controllers;
use Request;

Class Calendar extends Controller{

    public static function getformjquery(){

      $day = Request::Input('day');
      $month = Request::Input('month');
      $year = Request::Input('year');

      if(!empty($day) && !empty($month) && !empty($year)){
        $fulldate = $day . "-" . $month . "-" . $year;
        Calendar::getcalendar($fulldate);
      }else{
        Calendar::getcalendar("");
      }

    }

    public static function getcalendar($fulldate){

      if(empty($fulldate)){
        //กำหนดตัวแปรที่ใช้คำนวณวัน
        $now = strtotime("now");

        //if(isset($_GET['now']) && !empty($_GET['now'])){
           //$now = $_GET['now'];
        //}
      }else{
        $now = strtotime("$fulldate");
      }

      $Year = date('Y',$now);
      $month = date('n',$now);
      $first_of_month = strtotime("$Year-$month-1");
      $first_day_of_week = date('w',$first_of_month);
      $last_day_of_month = date('t',$now);
      $lastday_previousmonth = date("j", strtotime("$Year-$month-1" . "last day of previous month"));
      $weekrow_of_month = Calendar::getweekofmonth($now);
      $today = date("Y-n-j");

      //กำหนดวันแรกของหน้าปฏฺทิน
      $startday = 1 - $first_day_of_week;
      //กำหนดลำดับวันประจำสัปดาห์
      $day_of_week = 1;
      $row_of_month = 1;

			echo "
			  <div class='panel-body'>

			    <div id='gridcontainer' style='height: 631px;position:relative;' >
			      <div class='mv-container'>

              <div class='row' style='padding-bottom:8px;'>
                <div class='col-xs-7'>
                    <span style='font-size: 20px;'><b>" . date('F',$now) . "</b> " . $Year . "</span>
                </div>
                  <div class='col-xs-5 text-right'>
                        <button class='btn btn-outline btn-info btn-xs' type='submit' name = 'btn-previous' onclick='getprecalendar(". date('d',$now) . "," . date('m',$now) . "," . $Year .")' > < </button>
                        <button class='btn btn-outline btn-info btn-xs' type='submit' name = 'btn-previous' onclick='gettodaycalendar()' > today </button>
                        <button class='btn btn-outline btn-info btn-xs' type='submit' name = 'btn-next' onclick='getnextcalendar(". date('d',$now) . "," . date('m',$now) . "," . $Year .")'> > </button>
                  </div>
              </div>

			        <table cellspacing='0' cellpadding='0' class='mv-daynames-table' >
			          <tbody>
			            <tr>
			              <th title='Sun' class='mv-dayname'>Sun</th>
			              <th title='Mon' class='mv-dayname'>Mon</th>
			              <th title='Tue' class='mv-dayname'>Tue</th>
			              <th title='Wed' class='mv-dayname'>Wed</th>
			              <th title='Thu' class='mv-dayname'>Thu</th>
			              <th title='Fri' class='mv-dayname'>Fri</th>
			              <th title='Sat' class='mv-dayname'>Sat</th>
			            </tr>
			          </tbody>
			        </table>

			        <div class='mv-event-container' >";

			          //Set variable echo
			          //กำหนดตัวแปริาร์เรย์ทมีหลายค่าไม่เหมือนกันี่
			          $weekrow = array();
			          $table1_row = array();
			          $table2_row1 = array();
			          $table2_row2 = array();

                $row_of_event_on_week = array();
                //จำนวนกิจกรรมในวันนั้น
                $row_of_dayevent = "";

			          $weekrowfoot = "</div>";

			          $table1_head = 	"<table cellspacing='0' cellpadding='0' class='st-bg-table'><tbody><tr>";

			          $table1_foot = "</tr></tbody></table>";

			          $table2_head = "<table cellspacing='0' cellpadding='0' class='st-grid' ><tbody>";

			          $table2_foot = "</tbody></table>";

			          $table2_row1_foot = "</tr>";

			          $table2_row2_foot = "</tr>";

                //$table2_row_foot = "</tr>";
			          //End set variable echo

                $eventmonth = date('m',$now);

			          //ใช้คำสั่ง for เพื่อทำซ้ำ
			          for($run_day = $startday; ;$run_day++){

			            //กำหนดวันที่ปัจจุบัน
			            $current_day = "$Year-$month-$run_day";
                  $text_current_day = "$Year,$month,$run_day";

                  //ดึง event  วันนี้
                  $currentevent = Calendar::getevent("$Year-$eventmonth-$run_day");
                  /*if(empty($row_of_dayevent)){
                    $row_of_dayevent = $currentevent['number'];
                  }else if($currentevent['number'] > $row_of_dayevent){
                    $row_of_dayevent = $currentevent['number'];
                  }*/
                  $row_of_dayevent = $currentevent['number'];

                  //ถ้าจำนวนแถวกิจกรรมของวันนั้นว่าง
                  /*if(empty($row_of_event_on_week[$row_of_month-1]){
                    $row_of_event_on_week[$row_of_month-1] = $row_of_dayevent;
                  }*/


			            //กำหนดค่าเริ่มต้น array ถ้า array ว่างอยู่
			            if(empty($table1_row[$row_of_month-1]) && empty($table2_row1[$row_of_month-1]) && empty($table2_row2[$row_of_month-1])){
			              $table1_row[$row_of_month-1] = "";
			              $table2_row1[$row_of_month-1] = "<tr>";
			              $table2_row2[$row_of_month-1] = "<tr>";
			            }

			            if($row_of_month == 1){
			              $class = "st-dtitle-fr";
			            }else{
			              $class = "";
			            }


			            //ถ้าวันปัจจุบันน้อยกว่าวันแรกของเดือน
			            if($run_day < 1){

			                $table1_row[$row_of_month-1] .= "<td class='st-bg'>&nbsp;</td>";

			                $table2_row1[$row_of_month-1] .= "<td class='st-dtitle ". $class ." st-dtitle-nonmonth' >
			                                                  <span>" . ($lastday_previousmonth + $run_day) . "</span>
			                                                  </td>";

			                //$table2_row2[$row_of_month-1] .= "<td class='st-c st-s'>&nbsp;</td>";

			            //ถ้าวันปัจจุบันมากกว่าวันสุดท้ายของเดือน
			            }else if($run_day > $last_day_of_month){

			                $table1_row[$row_of_month-1] .= "<td class='st-bg'>&nbsp;</td>";

			                $table2_row1[$row_of_month-1] .= "<td class='st-dtitle ". $class ." st-dtitle-nonmonth' >
			                                                  <span>" . ($run_day - $last_day_of_month) . "</span>
			                                                  </td>";

			                //$table2_row2[$row_of_month-1] .= "<td class='st-c st-s'>&nbsp;</td>";


			                if($day_of_week == 7){

			                    $weekrow[$row_of_month-1] = "<div class='month-row weekrow". $row_of_month . "_" . $weekrow_of_month . "' >";//หลายค่า

			                    break;
			                }

			            //ถ้าวันปัจจุบันเท่ากับวันสุดท้ายของเดือน และเป็นวันสุดท้ายของสัปดาห์
			            }else if($run_day == $last_day_of_month && $day_of_week == 7){

                      if($today == $current_day){$class_today = "st-bg-today";}else{$class_today = "";}

			                $table1_row[$row_of_month-1] .= "<td class='st-bg ". $class_today ."' id='". $current_day ."' >&nbsp;</td>";

			                $table2_row1[$row_of_month-1] .= "<td class='st-dtitle ". $class ."' id='". $current_day ."'>
			                                                  <span>" . $run_day . "</span>
			                                                  </td>";

			                //$table2_row2[$row_of_month-1] .= "<td class='st-c st-s' id='". $current_day ."'>&nbsp;</td>";

			                $weekrow[$row_of_month-1] = "<div class='month-row weekrow". $row_of_month . "_" . $weekrow_of_month . "' >";//หลายค่า

			                break;

			            }else{

                    if($today == $current_day){$class_today = "st-bg-today";}else{$class_today = "";}

                    if($run_day == 1){$month_in_calendar = date('M',$now);}else{$month_in_calendar = "";}

			              $table1_row[$row_of_month-1] .= "<td class='st-bg ". $class_today ."' id='". $current_day ."' >&nbsp;</td>";

			              $table2_row1[$row_of_month-1] .= "<td class='st-dtitle ". $class ."' id='". $current_day ."'>
			                                                <span>" . $month_in_calendar . $run_day . "</span>
			                                                </td>";

			              //$table2_row2[$row_of_month-1] .= "<td class='st-c st-s' id='". $current_day ."'>&nbsp;</td>";

                    if($row_of_dayevent > 0){

                        $dayevent = "";

                        for($r = 0 ; $r < $row_of_dayevent ; $r++){
                          $dayevent .= "<div class='st-c-pos' id='". $currentevent['event'][$r]['id'] ."'>
                          <div style='border:1px solid #9FE1E7; color:#777777;background-color:#E4F7F8;' class='rb-n'>
                          <div class='rb-ni'>" . $currentevent['event'][$r]['request_name'] . "</div>
                          </div>
                          </div>";
                        }

                        $table2_row2[$row_of_month-1] .= "<td class='st-c'>". $dayevent . "</td>";
                    }else{
                        $table2_row2[$row_of_month-1] .= "<td class='st-c st-s' id='". $current_day ."'>&nbsp;</td>";
                    }

			            }

			            //ถ้าปัจจุบันเป็นวันสุดท้ายของสัปดาห์
			            if($day_of_week == 7){

			                $weekrow[$row_of_month-1] = "<div class='month-row weekrow". $row_of_month . "_" . $weekrow_of_month . "' >";//หลายค่า

                      //กำหนดแถว event ของสัปดาห์นั้น
                      $row_of_event_on_week[$row_of_month-1] = $row_of_dayevent;


                      $day_of_week = 1;
			                $row_of_month++;

			            //ถ้าปัจจุบันไม่ใช่วันสุดท้ายของสัปดาห์
			            }else{

			                $day_of_week++;

			            }

			          }

			          //run เพื่อแสดงผล
			          for($round = 0; $round < $weekrow_of_month; $round++){
			              echo $weekrow[$round] .
			              $table1_head .
			              $table1_row[$round] .
			              $table1_foot .
			              $table2_head .
			              $table2_row1[$round] .
			              $table2_row1_foot .
			              $table2_row2[$round] .
			              $table2_row2_foot .
			              $table2_foot .
			              $weekrowfoot;
			          }

			        echo "</div>
			      </div>
			    </div>

			  </div>
			";


    }

    public static function getweekofmonth($date){

      $Year = date('Y',$date);
      $month = date('n',$date);

      //find last week
      $last_day_of_month = date('t',$date);
      $day_of_week_last_day_of_month = date('w',strtotime("$Year-$month-$last_day_of_month"));

      if($day_of_week_last_day_of_month == 6){
        $last_week = date("W",strtotime("$Year-$month-$last_day_of_month"));
      }else{

        $last_week = date("W",strtotime("$Year-$month-$last_day_of_month" . "next Saturday"));

        //edit
        if($last_week == 1){
          $newlast_week = date("W",strtotime("$Year-$month-$last_day_of_month" . "last Saturday"));
        }

      }



      //find first week
      $day_of_week_first_day_of_month = date('w',strtotime("$Year-$month-01"));

      if($day_of_week_first_day_of_month == 0){
        $first_week = date("W",strtotime("$Year-$month-01" . "next Saturday"));
      }else{
        $first_week = date("W",strtotime("$Year-$month-01"));
      }

      //calculate week of month
      if($first_week > $last_week && $month == 12){
        $number_week_of_month = $newlast_week - $first_week + 2;
      }else if($first_week > $last_week){
        $number_week_of_month = $last_week + 1;
      }else{
        $number_week_of_month = $last_week - $first_week + 1;
      }

      return $number_week_of_month;

    }

    public static function getevent($currentday){

      //get event current day
      $event = RequestJob::getrequestonejob($currentday);

      $numberevent_of_day = count($event);

      return ['number' => $numberevent_of_day, 'event' => $event];

    }

}
