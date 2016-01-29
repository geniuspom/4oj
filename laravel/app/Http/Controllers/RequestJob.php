<?php
namespace App\Http\Controllers;

use App\Models\request_job as request_job;
use App\Models\validaterequestjob as validaterequestjob;
use Illuminate\Support\Facades\Redirect;
use Request;

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
                    ->with('status',"เพิ่มคำร้องขอสำเร็จ");
          } else {
            return redirect::to('add_request/null')
                    ->withInput(Request::except('password'))
                    ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถเพิ่มคำร้องขอได้");
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

}
