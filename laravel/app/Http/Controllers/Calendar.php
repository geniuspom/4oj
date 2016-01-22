<?php
namespace App\Http\Controllers;
use Request;
use Auth;

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

      $user_id = Auth::user()->id;

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

      //
      $all_event_of_week = "";

			echo "
			  <div class='panel-body'>

			    <div id='gridcontainer' style='height: 631px;position:relative;' >
			      <div class='mv-container'>

              <div class='row' style='padding-bottom:8px;'>
                <div class='col-xs-7'>
                    <span style='font-size: 18px;'><b>" . date('F',$now) . "</b> " . $Year . "</span>
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
			          $table2_row = array();
                $table2_row_event = array();
                $week_event_row = array();

                //จำนวนกิจกรรมในวันนั้น

			          $weekrowfoot = "</div>";

			          $table1_head = 	"<table cellspacing='0' cellpadding='0' class='st-bg-table'><tbody><tr>";

			          $table1_foot = "</tr></tbody></table>";

			          $table2_head = "<table cellspacing='0' cellpadding='0' class='st-grid' ><tbody>";

			          $table2_foot = "</tbody></table>";

			          $table2_row_foot = "</tr>";
			          //End set variable echo

//ใช้คำสั่ง for เพื่อสร้างปฏิทิน ===================================================================================
			          for($run_day = $startday; ;$run_day++){

			            //กำหนดวันที่ปัจจุบัน
			            $current_day = "$Year-$month-$run_day";
                  $text_current_day = "$Year,$month,$run_day";


			            //กำหนดค่าเริ่มต้น array ถ้า array ว่างอยู่
			            if(empty($table1_row[$row_of_month-1]) && empty($table2_row[$row_of_month-1]) ){
			              $table1_row[$row_of_month-1] = "";
			              $table2_row[$row_of_month-1] = "<tr>";
			            }

			            if($row_of_month == 1){
			              $class = "st-dtitle-fr";
			            }else{
			              $class = "";
			            }


			            //ถ้าวันปัจจุบันน้อยกว่าวันแรกของเดือน
			            if($run_day < 1){

			                $table1_row[$row_of_month-1] .= "<td class='st-bg'>&nbsp;</td>";

			                $table2_row[$row_of_month-1] .= "<td class='st-dtitle ". $class ." st-dtitle-nonmonth' >
			                                                  <span>" . ($lastday_previousmonth + $run_day) . "</span>
			                                                  </td>";

			            //ถ้าวันปัจจุบันมากกว่าวันสุดท้ายของเดือน
			            }else if($run_day > $last_day_of_month){

			                $table1_row[$row_of_month-1] .= "<td class='st-bg'>&nbsp;</td>";

			                $table2_row[$row_of_month-1] .= "<td class='st-dtitle ". $class ." st-dtitle-nonmonth' >
			                                                  <span>" . ($run_day - $last_day_of_month) . "</span>
			                                                  </td>";

			                if($day_of_week == 7){

			                    $weekrow[$row_of_month-1] = "<div class='month-row weekrow". $row_of_month . "_" . $weekrow_of_month . "' >";//หลายค่า

			                    break;
			                }

			            //ถ้าวันปัจจุบันเท่ากับวันสุดท้ายของเดือน และเป็นวันสุดท้ายของสัปดาห์
			            }else if($run_day == $last_day_of_month && $day_of_week == 7){

                      if($today == $current_day){$class_today = "st-bg-today";}else{$class_today = "";}

			                $table1_row[$row_of_month-1] .= "<td class='st-bg ". $class_today ."' id='". $current_day ."' >&nbsp;</td>";

			                $table2_row[$row_of_month-1] .= "<td class='st-dtitle ". $class ."' id='". $current_day ."'>
			                                                  <span>" . $run_day . "</span>
			                                                  </td>";


			                $weekrow[$row_of_month-1] = "<div class='month-row weekrow". $row_of_month . "_" . $weekrow_of_month . "' >";//หลายค่า

			                break;

			            }else{

                    if($today == $current_day){$class_today = "st-bg-today";}else{$class_today = "";}

                    if($run_day == 1){$month_in_calendar = date('M',$now);}else{$month_in_calendar = "";}

			              $table1_row[$row_of_month-1] .= "<td class='st-bg ". $class_today ."' id='". $current_day ."' >&nbsp;</td>";

			              $table2_row[$row_of_month-1] .= "<td class='st-dtitle ". $class ."' id='". $current_day ."'>
			                                                <span>" . $month_in_calendar . $run_day . "</span>
			                                                </td>";

			            }

			            //ถ้าปัจจุบันเป็นวันสุดท้ายของสัปดาห์
			            if($day_of_week == 7){

			                $weekrow[$row_of_month-1] = "<div class='month-row weekrow". $row_of_month . "_" . $weekrow_of_month . "' >";//หลายค่า

                      $day_of_week = 1;
			                $row_of_month++;

			            //ถ้าปัจจุบันไม่ใช่วันสุดท้ายของสัปดาห์
			            }else{

			                $day_of_week++;

			            }

			          }
//จบคำสั่ง for เพื่อสร้างปฏิทิน ===================================================================================


//เริ่มคำสั่ง for เพื่อนับจำนวนแถว event ==================================================================================
                $day_of_week = 1;
                $row_of_month = 1;
                $week_event_row_run = 0;

                for($run_day = $startday; ;$run_day++){

                  //กำหนดวันที่ปัจจุบัน
			            $current_day = "$Year-$month-$run_day";
                  $text_current_day = "$Year,$month,$run_day";

                  //เช็คเงื่อนไข และกำหนดวันเริ่ม วันจบ ที่ดึง event
                  if($run_day < 1){
                    $this_day = $lastday_previousmonth + $run_day;

                    if($month == 1){
                      $this_month = 12;
                      $this_year = $Year-1;
                    }else{
                      $this_month = $month-1;
                      $this_year = $Year;
                    }

                    $start = "$this_year-$this_month-$this_day";
                    $end = "$this_year-$this_month-$this_day";

                  }else if($run_day > $last_day_of_month){
                    $this_day = $run_day - $last_day_of_month;

                    if($month == 12){
                      $this_month = 1;
                      $this_year = $Year+1;
                    }else{
                      $this_month = $month-1;
                      $this_year = $Year;
                    }

                    $start = "$this_year-$this_month-$this_day";
                    $end = "$this_year-$this_month-$this_day";

                  }else{
                      $start = "$Year-$month-$run_day";
                      $end = "$Year-$month-$run_day";
                  }
                  //จบเช็คเงื่อนไข และกำหนดวันเริ่ม วันจบ ที่ดึง event

      //ดึง event จาก DB ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                  $eventmulti = RequestJob::getrequestjobmulti($start,$end,$user_id);
                  $event = RequestJob::getrequestonejob($start,$user_id);

                  $numberevent_of_day = count($event);
                  $numbermultievent_of_day = count($eventmulti);

                  $all_event_of_day = $numberevent_of_day + $numbermultievent_of_day;


                  //เช็คแถว event ทั้งหมดในสัปดาห์
                  if($week_event_row_run < $all_event_of_day){
                      $week_event_row_run = $all_event_of_day;
                  }
      //จบดึง event จาก DB ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

                  //ตรวจสอบวันสุดท้ายของเดือน
                  if(($run_day > $last_day_of_month && $day_of_week == 7) || ($run_day == $last_day_of_month && $day_of_week == 7)){

                      //เก็บค่า event row ในแต่ละสัปดาห์
                      $week_event_row[$row_of_month-1] = $week_event_row_run;

                      break;

                  }else{

                  }

                  //ถ้าปัจจุบันเป็นวันสุดท้ายของสัปดาห์
                  if($day_of_week == 7){

                      //เก็บค่า event row ในแต่ละสัปดาห์
                      $week_event_row[$row_of_month-1] = $week_event_row_run;

                      $week_event_row_run = 0;
                      $day_of_week = 1;
                      $row_of_month++;

                  //ถ้าปัจจุบันไม่ใช่วันสุดท้ายของสัปดาห์
                  }else{

                      $day_of_week++;

                  }

                }
//จบคำสั่ง for เพื่อนับจำนวนแถว event =================================================================================


//เริ่มคำสั่ง for สร้าง event ==================================================================================
                $day_of_week = 1;
                $row_of_month = 1;

                for($run_day = $startday; ;$run_day++){

                  //กำหนดวันที่ปัจจุบัน
			            $current_day = "$Year-$month-$run_day";
                  $text_current_day = "$Year,$month,$run_day";

                  //เช็คเงื่อนไข และกำหนดวันเริ่ม วันจบ ที่ดึง event
                  if($run_day < 1){
                    $this_day = $lastday_previousmonth + $run_day;

                    if($month == 1){
                      $this_month = 12;
                      $this_year = $Year-1;
                    }else{
                      $this_month = $month-1;
                      $this_year = $Year;
                    }

                    $start = "$this_year-$this_month-$this_day";
                    $end = "$this_year-$this_month-$this_day";

                  }else if($run_day > $last_day_of_month){
                    $this_day = $run_day - $last_day_of_month;

                    if($month == 12){
                      $this_month = 1;
                      $this_year = $Year+1;
                    }else{
                      $this_month = $month-1;
                      $this_year = $Year;
                    }

                    $start = "$this_year-$this_month-$this_day";
                    $end = "$this_year-$this_month-$this_day";

                  }else{
                      $start = "$Year-$month-$run_day";
                      $end = "$Year-$month-$run_day";
                  }
                  //จบเช็คเงื่อนไข และกำหนดวันเริ่ม วันจบ ที่ดึง event


      //ดึง event จาก DB ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                  $eventmulti = RequestJob::getrequestjobmulti($start,$end,$user_id);
                  $event = RequestJob::getrequestonejob($start,$user_id);

                  $numberevent_of_day = count($event);
                  $numbermultievent_of_day = count($eventmulti);

                  $all_event_of_day = $numberevent_of_day + $numbermultievent_of_day;

      //จบดึง event จาก DB ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

                    if($all_event_of_day > 0){

                      $eventmultincount = 0;
                      $eventcount = 0;

                      for($i = 0 ;$i < $week_event_row[$row_of_month-1];$i++){

                        if(empty($table2_row_event[$row_of_month-1][$i])){
                          $table2_row_event[$row_of_month-1][$i] = "<tr>";
                        }

//เพิ่มจำกัดกำนวนที่แสดง
if($i == 4){

  $table2_row_event[$row_of_month-1][$i] =
  "<td class='st-c st-more-c'><span class='ca-mlp23595 st-more st-moreul' id='". $current_day ."'>+ more</span></td>";

  break;
}
//เพิ่มจำกัดกำนวนที่แสดง


                        //เช็ค event หลายวัน
                        if($numbermultievent_of_day > 0 && $numbermultievent_of_day > $eventmultincount){

                          $number_of_multiday = ($eventmulti[$eventmultincount]['Numberofday']+1);

                          $today_week_number = date('w',strtotime($current_day));

                            if(strtotime($eventmulti[$eventmultincount]['start_date']) == strtotime($current_day)){

                                  if((7-$today_week_number) >= $number_of_multiday){
                                    $colspan = $number_of_multiday;
                                  }else{
                                    $colspan = 7-$today_week_number;
                                  }

                                  $table2_row_event[$row_of_month-1][$i] .= "<td class='st-c' colspan='". $colspan ."'>
                                                                        <div id='". $eventmulti[$eventmultincount]['id'] ."' class='st-c-pos'>
                                                                            <div class='rb-n' style='border:1px solid #fdcc8f; color:#777777;background-color:#fdead2;'>
                                                                            <div class='rb-ni'>&nbsp;</div>
                                                                            </div>
                                                                        </div>
                                                                        </td>";

                          }else if($today_week_number == 0){

                            $timeDiff = abs(strtotime($current_day)-strtotime($eventmulti[$eventmultincount]['start_date']));
                            $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                            $eventpassdate = intval($numberDays);

                            $resultdate = $number_of_multiday - $eventpassdate;

                                if((7-$today_week_number) >= $resultdate){
                                  $colspan = $resultdate;
                                }else{
                                  $colspan = 7-$today_week_number;
                                }

                                $table2_row_event[$row_of_month-1][$i] .= "<td class='st-c' colspan='". $colspan ."'>
                                                                      <div id='". $eventmulti[$eventmultincount]['id'] ."' class='st-c-pos'>
                                                                          <div class='rb-n' style='border:1px solid #fdcc8f; color:#777777;background-color:#fdead2;'>
                                                                          <div class='rb-ni'>&nbsp;</div>
                                                                          </div>
                                                                      </div>
                                                                      </td>";

                          }
//เพิ่มทีหลัง
                          /*else{

                            $rowspan = $week_event_row[$row_of_month-1] - $i;

                            $table2_row_event[$row_of_month-1][$i] .= "<td id='". $current_day ."' rowspan='". $rowspan ."' class='st-c st-s'>&nbsp;</td>";

                          }*/
//เพิ่มทีหลัง

                          $eventmultincount++;

                        }else

                        //เช็ค event เดี่ยว
                        if($numberevent_of_day > 0 && $numberevent_of_day > $eventcount && $numbermultievent_of_day == $eventmultincount){

                              if($numberevent_of_day == $eventcount+1){

                                $rowspan = $week_event_row[$row_of_month-1] - $i;

                                $table2_row_event[$row_of_month-1][$i] .= "<td class='st-c' rowspan='". $rowspan ."'>
                                                                      <div id='". $event[$eventcount]['id'] ."' class='st-c-pos'>
                                                                          <div class='rb-n' style='border:1px solid #fdcc8f; color:#777777;background-color:#fdead2;'>
                                                                          <div class='rb-ni'>&nbsp;</div>
                                                                          </div>
                                                                      </div>
                                                                      </td>";

                                break;

                              }else{

                                $table2_row_event[$row_of_month-1][$i] .= "<td class='st-c'>
                                                                      <div id='". $event[$eventcount]['id'] ."' class='st-c-pos'>
                                                                          <div class='rb-n' style='border:1px solid #fdcc8f; color:#777777;background-color:#fdead2;'>
                                                                          <div class='rb-ni'>&nbsp;</div>
                                                                          </div>
                                                                      </div>
                                                                      </td>";
                              }

                              $eventcount++;

                        }else if($numberevent_of_day == $eventcount && $numbermultievent_of_day == $eventmultincount){

                          $rowspan = $week_event_row[$row_of_month-1] - $i;

                          $table2_row_event[$row_of_month-1][$i] .= "<td id='". $current_day ."' rowspan='". $rowspan ."' class='st-c st-s'>&nbsp;</td>";

                          break;

                        }


                      }

                    }else{

                      if(empty($table2_row_event[$row_of_month-1][0])){
                        $table2_row_event[$row_of_month-1][0] = "<tr>";
                      }

                      $table2_row_event[$row_of_month-1][0] .= "<td id='". $current_day ."' rowspan='". $week_event_row[$row_of_month-1] ."' class='st-c st-s'>&nbsp;</td>";


                    }

                  //ถ้าปัจจุบันเป็นวันสุดท้ายของสัปดาห์
                  if($day_of_week == 7){

                    if($all_event_of_day > 0){

                      for($i = 0 ;$i < $week_event_row[$row_of_month-1];$i++){
                          $table2_row_event[$row_of_month-1][$i] .= "</tr>";
                      }

                    }else{
                      $table2_row_event[$row_of_month-1][0] .= "</tr>";
                    }

                      $day_of_week = 1;
                      $row_of_month++;

                      //เช็ควันสุดท้าย
                      if(($run_day > $last_day_of_month) || ($run_day == $last_day_of_month)){
                          break;
                      }


                  //ถ้าปัจจุบันไม่ใช่วันสุดท้ายของสัปดาห์
                  }else{

                      $day_of_week++;

                  }

                }
//จบคำสั่ง for เพื่อสร้าง event =================================================================================

			          //run เพื่อแสดงผล
			          for($round = 0; $round < $weekrow_of_month; $round++){

                    $all_event_of_week = "";

                    if($week_event_row[$round] != 0){
                      $countthisweek[$round] = count($table2_row_event[$round]);
                    }else{
                      $countthisweek[$round] = 0;
                    }

                    for($i = 0;$i < $countthisweek[$round]; $i++){

                      /*if(empty($all_event_of_week)){
                        $all_event_of_week = "";
                      }*/

                      $all_event_of_week .= $table2_row_event[$round][$i];

                    }

			              echo $weekrow[$round] .
			              $table1_head .
			              $table1_row[$round] .
			              $table1_foot .
			              $table2_head .
			              $table2_row[$round] .
			              $table2_row_foot .
                    $all_event_of_week .
                    $table2_row_foot .
			              $table2_foot .
			              $weekrowfoot;
			          }

			        echo "</div>
			      </div>
			    </div>

			  </div>
			";

      //add test
      /*echo "<div>";
      for($i = 0 ;$i < count($countthisweek); $i++){
        echo $countthisweek[$i] . "<br>";
      }
      echo "</div><br>";
      //end test

      echo "<div>";
      for($i = 0 ;$i < count($week_event_row); $i++){
        echo $week_event_row[$i] . "<br>";
      }
      echo "</div>";*/
      //end test

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
      $event = RequestJob::getrequestonejob($currentday,Auth::user()->id);

      $numberevent_of_day = count($event);

      return ['number' => $numberevent_of_day, 'event' => $event];

    }

}
