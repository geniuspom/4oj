<?php
namespace App\Http\Controllers\Assignment;
use App\Http\Controllers\Controller;
use App\Models\Database\Assignment as Assignment;
use App\Models\event as event;
use Request;
use Auth;

Class AssignCalendar extends Controller{

    public static function getformjquery(){

      $day = Request::Input('day');
      $month = Request::Input('month');
      $year = Request::Input('year');

      if(!empty($day) && !empty($month) && !empty($year)){
        $fulldate = $day . "-" . $month . "-" . $year;
        AssignCalendar::getcalendar($fulldate);
      }else{
        AssignCalendar::getcalendar("");
      }

    }

    public static function getcalendar($fulldate){

      if(empty($fulldate)){
        //กำหนดตัวแปรที่ใช้คำนวณวัน
        $now = strtotime("now");

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
      $weekrow_of_month = AssignCalendar::getweekofmonth($now);
      $today = date("Y-n-j");

      //แปลงเป็นภาษาไทย
      $thai_month = AssignCalendar::get_month_thai($month);
      $BE_year = AssignCalendar::get_BE_year($Year);

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
                    <span style='font-size: 18px;'><b>" . $thai_month . "</b> " . $BE_year . "</span>
                </div>
                  <div class='col-xs-5 text-right'>
                        <button class='btn btn-outline btn-info btn-xs' type='submit' name = 'btn-previous' onclick='assign_previous(". date('d',$now) . "," . date('m',$now) . "," . $Year .")' > < </button>
                        <button class='btn btn-outline btn-info btn-xs' type='submit' name = 'btn-previous' onclick='assign_today()' > today </button>
                        <button class='btn btn-outline btn-info btn-xs' type='submit' name = 'btn-next' onclick='assign_next(". date('d',$now) . "," . date('m',$now) . "," . $Year .")'> > </button>
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
                    $table2_row_event[$row_of_month-1] = "<tr>";
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

                      $table2_row_event[$row_of_month-1] .= AssignCalendar::get_assign_event($current_day,Auth::user()->id);

                      break;

			            }else{

                    if($today == $current_day){$class_today = "st-bg-today";}else{$class_today = "";}

                    if($run_day == 1){$month_in_calendar = date('M',$now);}else{$month_in_calendar = "";}

			              $table1_row[$row_of_month-1] .= "<td class='st-bg ". $class_today ."' id='". $current_day ."' >&nbsp;</td>";

			              $table2_row[$row_of_month-1] .= "<td class='st-dtitle ". $class ."' id='". $current_day ."'>
			                                                <span>" . $month_in_calendar . $run_day . "</span>
			                                                </td>";

                    $table2_row_event[$row_of_month-1] .= AssignCalendar::get_assign_event($current_day,Auth::user()->id);

			            }

			            //ถ้าปัจจุบันเป็นวันสุดท้ายของสัปดาห์
			            if($day_of_week == 7){

			                $weekrow[$row_of_month-1] = "<div class='month-row weekrow". $row_of_month . "_" . $weekrow_of_month . "' >";//หลายค่า
                      $table2_row_event[$row_of_month-1] .= "</tr>";
                      $day_of_week = 1;
			                $row_of_month++;

			            //ถ้าปัจจุบันไม่ใช่วันสุดท้ายของสัปดาห์
			            }else{

			                $day_of_week++;

			            }

			          }
//จบคำสั่ง for เพื่อสร้างปฏิทิน ===================================================================================

			          //run เพื่อแสดงผล
			          for($round = 0; $round < $weekrow_of_month; $round++){

			              echo $weekrow[$round] .
			              $table1_head .
			              $table1_row[$round] .
			              $table1_foot .
			              $table2_head .
			              $table2_row[$round] .
			              $table2_row_foot .
                    $table2_row_event[$round] .
                    $table2_row_foot .
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

    public static function get_BE_year($year){
        $BE_year = $year+543;

        return $BE_year;
    }

    public static function get_assign_event($date,$user_id){

        $event_data = "<td valign='top'>";

        $event = event::where('event_date', '=', $date)->get();

        foreach($event as $data){

          //เช็คช่วงเวลา request
          if($data->meeting_period == 2){
            $event_color_class = "event_color_morning";
          }else if($data->meeting_period == 3){
            $event_color_class = "event_color_afternoon";
          }else{
            $event_color_class = "event_color_allday";
          }

          $count = Assignment::where('event_id', '=', $data->id)
                      ->where('user_id','=',$user_id)
                      ->count();


          if($count > 0){

            $assignment = Assignment::where('event_id', '=', $data->id)
                        ->where('user_id','=',$user_id)
                        ->get();

            foreach($assignment as $data_assign){
              //$event_data .= "<div id='". $date ."' class='st-c st-s'>".$data_assign->id."</div>";

              $event_data .= "<div id='". $data->id ."' class='st-c-pos goto_assign'>
                                  <div class='rb-n ".$event_color_class."' >
                                      <div class='rb-ni'>". $data->event_name ."</div>
                                  </div>
                                </div>";

            }

          }

        }

        $event_data .= "</td>";


        return $event_data;

    }

}
