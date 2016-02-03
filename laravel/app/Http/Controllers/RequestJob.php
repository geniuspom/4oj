<?php
namespace App\Http\Controllers;

use App\Models\request_job as request_job;
use App\Models\event as event;
use App\Models\Member as Member;
use App\Models\validaterequestjob as validaterequestjob;
use Illuminate\Support\Facades\Redirect;
use Request;
use Auth;

Class RequestJob extends Controller{

    //add request job
    public function add(){
      //check input form
      $validate = validaterequestjob::validaterequestjob(Request::all());

      if($validate->passes()){

        //หาระยะเวลาว่ากี่วัน
        $input_start = explode("/", Request::input('start_date'));
        $input_end = explode("/", Request::input('end_date'));
        $start_date = $input_start[2]."/".$input_start[1]."/".$input_start[0];
        $end_date = $input_end[2]."/".$input_end[1]."/".$input_end[0];
        $startTimeStamp = strtotime($start_date);
        $endTimeStamp = strtotime($end_date);
        $timeDiff = abs($endTimeStamp - $startTimeStamp);
        $numberDays = $timeDiff/86400;  // 86400 seconds in one day
        $numberDays = intval($numberDays);
        //ถ้ามากกว่า 1 วัน

        $even_id = Request::input('event_id');
        if(empty($even_id)){$even_id = 0;}

        if($numberDays > 0){$multiple_day = 1;}else{$multiple_day = 0;}

          //add to db
          $request = new request_job();
          $request->request_name = /*Request::input('request_name')*/" ";
          $request->user_id = Request::input('user_id');
          $request->start_date = $start_date;
          $request->end_date = $end_date;
          $request->duration = Request::input('duration');
          $request->event_id = $even_id;
          $request->multiple_day = $multiple_day;
          $request->remark = Request::input('remark');

          if($request->save()) {
            return redirect::to('/')
                    ->with('status',"เพิ่มวันและเวลาที่คุณสามารถทำงานได");
          } else {
            return redirect::to('add_request/null')
                    ->withInput(Request::except('password'))
                    ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถเพิ่มวันและเวลาที่คุณสามารถทำงานได้");
          }

      }else{
          return redirect::to('add_request/null')
              ->withInput(Request::all())
              ->withErrors($validate->messages());
      }

    }

    public static function getrequestjob($start,$end){
      $request = request_job::where('multiple_day', '=', '0')->whereBetween('start_date', array($start, $end))->orderBy('start_date')->get();

      $event = array();

      $i = 0;

      foreach ($request as $record){

        $start = $record->start_date;
        $end = $record->end_date;
        $startTimeStamp = strtotime($start);
        $endTimeStamp = strtotime($end);
        $timeDiff = abs($endTimeStamp - $startTimeStamp);
        $numberDays = $timeDiff/86400;  // 86400 seconds in one day
        $Numberofday = intval($numberDays);


        $event[$i] = array('id' => $record->id,
                      'request_name' => $record->request_name,
                      'user_id' => $record->user_id,
                      'start_date' => $record->start_date,
                      'end_date' => $record->end_date,
                      'duration' => $record->duration,
                      'event_id' => $record->event_id,
                      'multiple_day' => $record->multiple_day,
                      'remark' => $record->remark,
                      'Numberofday' => $Numberofday);
        $i++;

      }

      return $event;

      /*for($r = 0; $r < count($event);$r++){

        echo $event[$r]['Numberofday']."<br>";

      }*/

    }

    public static function getrequestjobmulti($start,$end,$user_id){
      $request = request_job::where(function ($query) use ($start,$end,$user_id){
                                 $query->where('multiple_day', '=', '1')
                                        ->where('user_id', '=', $user_id)
                                        ->whereBetween('start_date', array($start, $end))
                                        ->whereBetween('end_date', array($start, $end));
                              })
                              ->orwhere(function ($query) use ($start,$end,$user_id){
                                 $query->where('multiple_day', '=', '1')
                                        ->where('user_id', '=', $user_id)
                                        ->whereBetween('start_date', array($start, $end))
                                        ->where('end_date', ">" , $end);
                              })
                              ->orwhere(function ($query) use ($start,$end,$user_id){
                                 $query->where('multiple_day', '=', '1')
                                        ->where('user_id', '=', $user_id)
                                        ->whereBetween('end_date', array($start, $end))
                                        ->where('start_date', "<" , $start);
                              })
                              ->orwhere(function ($query) use ($start,$end,$user_id){
                                 $query->where('multiple_day', '=', '1')
                                        ->where('user_id', '=', $user_id)
                                        ->where('start_date', "<" , $start)
                                        ->where('end_date', ">" , $end);
                              })
                              ->orderBy('start_date')
                              ->get();

      $event = array();

      $i = 0;

      foreach ($request as $record){

        $start = $record->start_date;
        $end = $record->end_date;
        $startTimeStamp = strtotime($start);
        $endTimeStamp = strtotime($end);
        $timeDiff = abs($endTimeStamp - $startTimeStamp);
        $numberDays = $timeDiff/86400;  // 86400 seconds in one day
        $Numberofday = intval($numberDays);


        $event[$i] = array('id' => $record->id,
                      'request_name' => $record->request_name,
                      'user_id' => $record->user_id,
                      'start_date' => $record->start_date,
                      'end_date' => $record->end_date,
                      'duration' => $record->duration,
                      'event_id' => $record->event_id,
                      'multiple_day' => $record->multiple_day,
                      'remark' => $record->remark,
                      'Numberofday' => $Numberofday);
        $i++;

      }

      return $event;

      /*for($r = 0; $r < count($event);$r++){

        echo $event[$r]['Numberofday']."<br>";
        echo $event[$r]['request_name']."<br>";

      }*/

    }


    //old completed code
    /*public static function getrequestjobmulti($start,$end){
      $request = request_job::where('multiple_day', '=', '1')
                              ->where(function ($query) use ($start,$end){
                                 $query->whereBetween('start_date', array($start, $end))
                                        ->orwhereBetween('end_date', array($start, $end));
                              })
                              ->orderBy('start_date')
                              ->get();

      $event = array();

      $i = 0;

      foreach ($request as $record){

        $start = $record->start_date;
        $end = $record->end_date;
        $startTimeStamp = strtotime($start);
        $endTimeStamp = strtotime($end);
        $timeDiff = abs($endTimeStamp - $startTimeStamp);
        $numberDays = $timeDiff/86400;  // 86400 seconds in one day
        $Numberofday = intval($numberDays);


        $event[$i] = array('id' => $record->id,
                      'request_name' => $record->request_name,
                      'user_id' => $record->user_id,
                      'start_date' => $record->start_date,
                      'end_date' => $record->end_date,
                      'duration' => $record->duration,
                      'event_id' => $record->event_id,
                      'multiple_day' => $record->multiple_day,
                      'remark' => $record->remark,
                      'Numberofday' => $Numberofday);
        $i++;

      }

      return $event;

    }*/

    //request one day
    public static function getrequestonejob($start,$user_id){

      $request = request_job::where('multiple_day', '=', '0')
                              ->where('start_date', '=', $start)
                              ->where('user_id', '=', $user_id)
                              ->orderBy('start_date')
                              ->get();

      $event = array();

      $i = 0;

      foreach ($request as $record){

        $event[$i] = array('id' => $record->id,
                      'request_name' => $record->request_name,
                      'user_id' => $record->user_id,
                      'start_date' => $record->start_date,
                      'end_date' => $record->end_date,
                      'duration' => $record->duration,
                      'event_id' => $record->event_id,
                      'multiple_day' => $record->multiple_day,
                      'remark' => $record->remark);
        $i++;

      }

      return $event;

    }


    //get customer
    /*public static function get($id,$value){

        $venue = venue::where("id","=", $id)->first();

        $returndata = $venue->$value;

        echo $returndata;

    }

    //get all customer
    public static function getall(){

        $venue = venue::orderBy('name')->get();

        foreach ($venue as $record){

          echo "<tr><td class='text-center'><a href='venue_detail/".
                $record->id .
                "'>" .
                $record->name .
                "</a></td><td>".
                $record->address .
                "</td><td class='text-center'>".
                $record->phone .
                "</td><td class='text-center'>".
                $record->area .
                "</td><td class='text-center'><a href='edit_venue/".
                $record->id .
                "'><img src='/4oj/public/image/file_edit.png' width='20px' /></a></td><tr>";
        }

    }

    //edit
    public function edit(){

        //check input form
        $validate = validatevenue::validateeditvenue(Request::all());

        if($validate->passes()){
            $venue = venue::where("id","=",Request::input('id'))->first();
            $venue->name = Request::input('name');
            $venue->address = Request::input('address');
            $venue->phone = Request::input('phone');
            $venue->area = Request::input('area');

            if($venue->save()) {
              return redirect::to('venue_detail/' . Request::input('id'))
                      ->with('status',"แก้ไขข้อมูลสถานที่จัดงาน ". Request::input('name') ." สำเร็จ");
            } else {
              return redirect::to('edit_venue')
                      ->withInput(Request::except('password'))
                      ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถแก้ไขข้อมูลลูกค้าได้");
            }

        }else{
            return redirect::to('edit_venue')
                    ->withInput(Request::all())
                    ->withErrors($validate->messages());
        }

    }*/

/* Get detail request job ======================================================================
*
*
================================================================================================*/
  public static function gatdeatail($id,$value,$type){

    $root_url = dirname($_SERVER['PHP_SELF']);

    $request_job = request_job::where("id","=", $id)->first();

    $returndata = $request_job->$value;

    if($value == 'start_date' || $value == 'end_date'){
      $split_date= explode("-", $returndata);
      $returndata = $split_date[2]."/".$split_date[1]."/".$split_date[0];
    }else if($value == 'duration'){

      if($type == 'edit'){

        $periods = array(
                      "1" => "ทั้งวัน",
                      "2" => "ช่วงเช้า",
                      "3" => "ช่วงบ่าย"
              );

          $data = "<select class='form-control' id='duration' name='duration'>";
              foreach ($periods as $period => $value){
                  $data .= "<option value='".$period."'" ;
                      if ($returndata == $period){
                          $data .= " selected='selected'";
                      }
                  $data .= ">".$value."</option>";
              }
          $data .= "</select>";

          $returndata = $data;

      }else{

        if($returndata == 1){
          $returndata = "ทั้งวัน";
        }else if($returndata == 2){
          $returndata = "ช่วงเช้า";
        }else if($returndata == 3){
          $returndata = "ช่วงบ่าย";
        }

      }


    }else if($value == 'event_id' && $returndata != 0){

      if($type == "getid"){

        $event_id_value = $returndata;
        $returndata = $root_url."/event_detail/".$event_id_value;

      }else{

        $event = event::where("id","=", $returndata)->first();
        $returndata = $event->event_name;

      }

    }

    if($type == 'edit'){
      echo $returndata;
    }else{
      return $returndata;
    }

  }
/* End Get detail request job ======================================================================
*
*
================================================================================================*/


/* delete request job ======================================================================
*
*
================================================================================================*/
  public static function delete(){

      $request_job = request_job::find(Request::input('requestjob_id'));

      if($request_job->delete()){
        return redirect::to('/')
                ->with('status',"ลบวันและเวลาที่คุณสามารถทำงานได้สำเร็จ");
      }else{
        return redirect::to('detail_request/'.Request::input('requestjob_id'))
                ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถลบวันและเวลาที่คุณสามารถทำงานได");
      }

  }
/* End delete request job ======================================================================
*
*
================================================================================================*/

/* edit request job ======================================================================
*
*
================================================================================================*/
  public static function edit(){
    //check input form
    $validate = validaterequestjob::validaterequestjob(Request::all());

    if($validate->passes()){

      //หาระยะเวลาว่ากี่วัน
      $input_start = explode("/", Request::input('start_date'));
      $input_end = explode("/", Request::input('end_date'));
      $start_date = $input_start[2]."/".$input_start[1]."/".$input_start[0];
      $end_date = $input_end[2]."/".$input_end[1]."/".$input_end[0];
      $startTimeStamp = strtotime($start_date);
      $endTimeStamp = strtotime($end_date);
      $timeDiff = abs($endTimeStamp - $startTimeStamp);
      $numberDays = $timeDiff/86400;  // 86400 seconds in one day
      $numberDays = intval($numberDays);
      //ถ้ามากกว่า 1 วัน

      if($numberDays > 0){$multiple_day = 1;}else{$multiple_day = 0;}

        //add to db
        $request_job = request_job::where("id","=", Request::input('id'))->first();
        $request_job->start_date = $start_date;
        $request_job->end_date = $end_date;
        $request_job->duration = Request::input('duration');
        $request_job->multiple_day = $multiple_day;
        $request_job->remark = Request::input('remark');

        if($request_job->save()) {
          return redirect::to('/')
                  ->with('status',"แก้ไขวันและเวลาที่คุณสามารถทำงานได้");
        } else {
          return redirect::to('add_request/null')
                  ->withInput(Request::except('password'))
                  ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถแก้ไขวันและเวลาที่คุณสามารถทำงานได้");
        }

    }else{
        return redirect::to('add_request/null')
            ->withInput(Request::all())
            ->withErrors($validate->messages());
    }

  }

/* edit request job ======================================================================
*
*
================================================================================================*/

  public static function get_report_jquery(){

    $filter_group = Request::input('filter_group');
    $filter_value = Request::input('filter_value');
    $sort = Request::input('sortby');

    if(empty($filter_value)){
      $filter_group = "all";
    }

    RequestJob::report_request_job($filter_group,$filter_value,$sort);

  }


  public static function report_request_job($filter_group,$filter_value,$sort){

    $root_url = dirname($_SERVER['PHP_SELF']);

  //===========================================================================================
    if($filter_group == 'all'){
      $request = request_job::orderBy('start_date')->get();

      $returndata = "";
      $returndata .= "<div class='row'>
        <div class='col-lg-12'>
          <div class='table-responsive'>
              <table class='table table-bordered table-hover table-striped'>
                <thead>
                  <tr>
                    <th class='text-center'>ชื่อผู้ร้องขอ</th>
                    <th class='text-center'>วันเริ่ม</th>
                    <th class='text-center'>วันสิ้นสุด</th>
                    <th class='text-center'>ช่วงเวลา</th>
                    <th class='text-center'>ชื่อกิจกรรม</th>
                    <th class='text-center'>หมายเหตุ</th>
                  </tr>
                </thead>
                <tbody>";

        foreach ($request as $row) {

            $user = Member::where("id","=",$row->user_id)->first();

            $user_id = $user->id;
            $user_name = $user->nickname  . "-" . $user->name . " " . $user->surname;

            $split_start_date = explode("-", $row->start_date);
            $start_date = $split_start_date[2]."/".$split_start_date[1]."/".$split_start_date[0];

            $split_end_date = explode("-", $row->end_date);
            $end_date = $split_end_date[2]."/".$split_end_date[1]."/".$split_end_date[0];

            if($row->duration == 1){
              $duration = "ทั้งวัน";
            }else if($row->duration == 2){
              $duration = "ช่วงเช้า";
            }else if($row->duration == 3){
              $duration = "ช่วงบ่าย";
            }

            $event_id = "";
            $event_name = "";

            if($row->event_id != 0){

              $event = event::where("id","=", $row->event_id)->first();

              $event_id = $event->id;
              $event_name = $event->event_name;

            }

            $returndata .= "<tr>
                            <td class=''>". $user_name ."</td>
                            <td class='text-center'>". $start_date ."</td>
                            <td class='text-center'>". $end_date ."</td>
                            <td class='text-center'>". $duration ."</td>
                            <td class='text-center'><a href='".$root_url."/event_detail/". $event_id ."'>". $event_name ."</a></td>
                            <td>". $row->remark ."</td>
                          </tr>";
        }

      $returndata .= "</tbody>
              </table>
            </div>
        </div>
      </div>";

    }
    //===========================================================================================
    else if($filter_group == '1'){

      $query_user_splite1 = explode("[", $filter_value);
      $query_user_splite2 = explode("]", $query_user_splite1[1]);
      $query_user = $query_user_splite2[0];

      $request = request_job::where("user_id","=", $query_user)
                              ->orderBy('start_date')->get();

      $returndata = "";
      $returndata .= "<div class='row'>
        <div class='col-lg-12'>
          <div class='table-responsive'>
              <table class='table table-bordered table-hover table-striped'>
                <thead>
                  <tr>
                    <th class='text-center'>ชื่อผู้ร้องขอ</th>
                    <th class='text-center'>วันเริ่ม</th>
                    <th class='text-center'>วันสิ้นสุด</th>
                    <th class='text-center'>ช่วงเวลา</th>
                    <th class='text-center'>ชื่อกิจกรรม</th>
                    <th class='text-center'>หมายเหตุ</th>
                  </tr>
                </thead>
                <tbody>";

        foreach ($request as $row) {

            $user = Member::where("id","=",$row->user_id)->first();

            $user_id = $user->id;
            $user_name = $user->nickname  . "-" . $user->name . " " . $user->surname;

            $split_start_date = explode("-", $row->start_date);
            $start_date = $split_start_date[2]."/".$split_start_date[1]."/".$split_start_date[0];

            $split_end_date = explode("-", $row->end_date);
            $end_date = $split_end_date[2]."/".$split_end_date[1]."/".$split_end_date[0];

            if($row->duration == 1){
              $duration = "ทั้งวัน";
            }else if($row->duration == 2){
              $duration = "ช่วงเช้า";
            }else if($row->duration == 3){
              $duration = "ช่วงบ่าย";
            }

            $event_id = "";
            $event_name = "";

            if($row->event_id != 0){

              $event = event::where("id","=", $row->event_id)->first();

              $event_id = $event->id;
              $event_name = $event->event_name;

            }

            $returndata .= "<tr>
                            <td class=''>". $user_name ."</td>
                            <td class='text-center'>". $start_date ."</td>
                            <td class='text-center'>". $end_date ."</td>
                            <td class='text-center'>". $duration ."</td>
                            <td class='text-center'><a href='".$root_url."/event_detail/". $event_id ."'>". $event_name ."</a></td>
                            <td>". $row->remark ."</td>
                          </tr>";
        }

      $returndata .= "</tbody>
              </table>
            </div>
        </div>
      </div>";

    }
    //===============================================================================================


    //===========================================================================================
    else if($filter_group == '2'){

      $input_date = explode("/", $filter_value);
      $date = $input_date[2]."-".$input_date[1]."-".$input_date[0];

      $request = request_job::where("start_date","<=", $date)
                              ->where("end_date",">=", $date)
                              ->orderBy('start_date')->get();

      $returndata = "";
      $returndata .= "<div class='row'>
        <div class='col-lg-12'>
          <div class='table-responsive'>
              <table class='table table-bordered table-hover table-striped'>
                <thead>
                  <tr>
                    <th class='text-center'>ชื่อผู้ร้องขอ</th>
                    <th class='text-center'>วันเริ่ม</th>
                    <th class='text-center'>วันสิ้นสุด</th>
                    <th class='text-center'>ช่วงเวลา</th>
                    <th class='text-center'>ชื่อกิจกรรม</th>
                    <th class='text-center'>หมายเหตุ</th>
                  </tr>
                </thead>
                <tbody>";

        foreach ($request as $row) {

            $user = Member::where("id","=",$row->user_id)->first();

            $user_id = $user->id;
            $user_name = $user->nickname  . "-" . $user->name . " " . $user->surname;

            $split_start_date = explode("-", $row->start_date);
            $start_date = $split_start_date[2]."/".$split_start_date[1]."/".$split_start_date[0];

            $split_end_date = explode("-", $row->end_date);
            $end_date = $split_end_date[2]."/".$split_end_date[1]."/".$split_end_date[0];

            if($row->duration == 1){
              $duration = "ทั้งวัน";
            }else if($row->duration == 2){
              $duration = "ช่วงเช้า";
            }else if($row->duration == 3){
              $duration = "ช่วงบ่าย";
            }

            $event_id = "";
            $event_name = "";

            if($row->event_id != 0){

              $event = event::where("id","=", $row->event_id)->first();

              $event_id = $event->id;
              $event_name = $event->event_name;

            }

            $returndata .= "<tr>
                            <td class=''>". $user_name ."</td>
                            <td class='text-center'>". $start_date ."</td>
                            <td class='text-center'>". $end_date ."</td>
                            <td class='text-center'>". $duration ."</td>
                            <td class='text-center'><a href='".$root_url."/event_detail/". $event_id ."'>". $event_name ."</a></td>
                            <td>". $row->remark ."</td>
                          </tr>";
        }

      $returndata .= "</tbody>
              </table>
            </div>
        </div>
      </div>";

    }
    //===============================================================================================

    echo $returndata;

  }

  public static function request_event(){

    $event = event::where("id","=", Request::input('event_id'))->first();

    $request_name = $event->event_name;
    $start_date = $event->event_date;
    $end_date = $event->event_date;
    $duration = $event->meeting_period;

    //=====================================================================================

    $request = new request_job();
    $request->request_name = $request_name;
    $request->user_id = Auth::user()->id;
    $request->start_date = $start_date;
    $request->end_date = $end_date;
    $request->duration = $duration;
    $request->event_id = Request::input('event_id');
    $request->multiple_day = 0;

    $url = "event_detail/".Request::input('event_id');

    if($request->save()) {
      return redirect::to($url)
              ->with('status',"ยื่นขอทำงานสำเร็จ");
    } else {
      return redirect::to($url)
              ->withInput(Request::except('password'))
              ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถยื่นขอทำงานนี้ได้ กรุณาติดต่อผู้ดูแลระบบ");
    }


  }


}
