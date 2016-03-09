<?php
namespace App\Http\Controllers\Assignment;
use App\Models\Database\Assignment as AssignmentDB;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Redirect;

Class Assign_result extends Controller{

  public static function main($event_id){

    Assign_result::generate_html(Assign_result::get_data($event_id));

  }

  public static function get_data($event_id){

    $assign = AssignmentDB::where('event_id','=',$event_id)->get();

    if(count($assign) > 0){
        foreach($assign as $record){
            $data[] = [
                        "id" => $record->id,
                        "user_id" => $record->user->id,
                        "name" => $record->user->nickname . " - " . $record->user->name . " " . $record->user->surname,
                        "assign_status" => $record->assign_status,
                        "position" => $record->position,
            ];
        }

        return $data;
    }

  }

  public static function generate_html($data){

    $root_url = dirname($_SERVER['PHP_SELF']);

    $return_data = '<table class="table table-bordered table-hover table-striped">
                    <thead>
                      <tr>
                        <th class="text-center" style="width:2%">ลำดับที่</th>
                        <th class="text-left">ชื่อคนที่ทำงาน</th>
                        <th class="text-center">ตำแหน่ง</th>
                        <th class="text-center">สถานะ</th>
                      </tr>
                    </thead>
                    <tbody>';

      $i=1;

      if($data > 0){

          foreach($data as $record){

              $statusall = [
                        "1" => "assign",
                        "2" => "confirm",
                        "3" => "reject"
              ];

              $positionall = [
                        "0" => "none",
                        "1" => "Admin",
                        "2" => "Register"
              ];

              $statusdata = '<select name="status['.$i.']" class="form-control">';
              $positiondata = '<select name="position['.$i.']" class="form-control">';


              foreach($statusall as $status => $statusvalue){

                $statusdata .= "<option value='".$status."'" ;
                    if ($record['assign_status'] == $status){
                        $statusdata .= " selected='selected'";
                    }
                $statusdata .= ">".$statusvalue."</option>";

              }

              foreach($positionall as $position => $positionvalue){

                $positiondata .= "<option value='".$position."'" ;
                    if ($record['position'] == $position){
                        $positiondata .= " selected='selected'";
                    }
                $positiondata .= ">".$positionvalue."</option>";

              }

              $statusdata .= '</select>';
              $positiondata .= '</select>';


              $return_data .= '<tr>
                                  <td class="text-center valign_mid">'.$i.'</td>
                                  <td class="valign_mid"><input type="hidden" size="1" name="assignid['.$i.']" value="'. $record['id'] .'">
                                  <a target="_blank" href="'. $root_url .'/profile_admin/'. $record['user_id'] .'">
                                  '. $record['name'] .'</td>
                                  <td class="text-center valign_mid">' . $positiondata . '</td>
                                  <td>'. $statusdata .'</td>
                              </tr>';

              $i++;
          }

      }else{

        $return_data .= '<tr>
                            <td class="text-center" colspan="4">ไม่มีรายชื่อคนที่ไปทำงานนี้</td>
                        </tr>';

      }


    $return_data .= '</tbody></table>';

    if($data > 0){

      $return_data .= '<button id="submit_bt" name="btn-trianing" type="submit" class="btn btn-primary" >
                          บันทึก
                      </button>';

    }

    echo $return_data;


  }

  public static function updatedata(){

    $assign_id = Request::input('assignid');
    $status = Request::input('status');
    $position = Request::input('position');
    $event_id = Request::input('event_id');

    if(count($assign_id) > 0){
      for($i = 1; $i <= count($assign_id);$i++){

        $assign = AssignmentDB::where('id','=',$assign_id[$i])->first();
        $assign->assign_status = $status[$i];
        $assign->position = $position[$i];
        $assign->save();

      }

      return redirect::to('assigment/'.$event_id)
              ->with('status',"บันทึกสำเร็จ");

    }else{

      return redirect::to('assigment/'.$event_id)
              ->with('status',"บันทึกสำเร็จ");

    }



  }


}
