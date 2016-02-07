<?php
namespace App\Http\Controllers;
use App\Models\Member as Member;
use App\Models\Userdetail as Userdetail;
use App\Models\bank as bank;
use App\Models\education as education;
use App\Models\validateuser as validateuser;
use App\Models\institute as institute;
use App\Models\province as province;
use App\Models\district as district;
use App\Models\idcard as idcard;
use App\Models\images as upload;
use Illuminate\Support\Facades\Redirect;
use Route;
use Request;

Class AdminController extends Controller{

    public static function get_filter_jquery(){

      $filter_group = Request::input('filter_group');
      $filter_value = Request::input('filter_value');
      $sort = Request::input('sortby');

      AdminController::admingetuser($filter_group,$filter_value,$sort);

    }

    public static function admingetuser($filter_group,$filter_value,$sort){

        $root_url = dirname($_SERVER['PHP_SELF']);

        if($filter_value == 'all'){
            $data = Member::orderBy('id')->get();
        }else if($filter_value == 0){
            $data = Member::where('district','=',NULL)
                          ->orwhere('district','=','0')
                          ->orderBy('district')->get();
        }else{
            $data = Member::where('district','=',$filter_value)
                        ->orderBy('district')->get();
        }


        echo "<table class='table table-bordered table-hover table-striped'>
                <thead>
                  <tr>
                    <th class='text-center'>ชื่อ - นามสกุล</th>
                    <th class='text-center'>ชื่อเล่น</th>
                    <th class='text-center'>อีเมล</th>
                    <th class='text-center'>โทรศัพท์</th>
                    <th class='text-center'>เขต</th>
                    <th class='text-center'>เกรด</th>
                    <th class='text-center'>remark</th>
                    <th class='text-center'>สถานะผู้ใช้</th>
                    <th class='text-center'>ดำเนินการ</th>
                  </tr>
                </thead>
                <tbody>";


        foreach ($data as $record){

          //get idcard path
          $countid = idcard::where('id_user', '=', $record->id)->count();

          if($countid == 1){
            $resultidcard = idcard::where('id_user', '=', $record->id)->first();

            $idpath = $root_url."/upload_file/idcard/default/".$resultidcard->id_name;
          }else{
            $idpath = "";
          }
          //End get idcard path

          //get image path
          $countimage = upload::where('image_user', '=', $record->id)->count();

          if($countimage == 1){
            $resultimage = upload::where('image_user', '=', $record->id)->first();

            $image = $root_url."/upload_file/images/default/".$resultimage->image_name;
          }else{
            $image = "";
          }
          //End get image path


          //get distric
          if($record->district == 0 || $record->district == NULL){
            $district = "ต่างจังหวัด";
          }else{

            $resultdistric = district::where('id', '=', $record->district)->first();
            $district = $resultdistric->name;
          }
          //ENd get distric

          //get user detail
          $countuserdetail = Userdetail::where('user_id', '=', $record->id)->count();

          if($countuserdetail == 1){
            $Userdetail = Userdetail::where('user_id', '=', $record->id)->first();

            $grade = $Userdetail->grade;
            $remark = $Userdetail->remark;
          }else{
            $grade = "none";
            $remark = "";
          }
          //end get user detail

          $u_status = $record->validate;
          $mail_st = substr($u_status, 1,1);
          $id_st = substr($u_status, 2,1);
          $id_valid = substr($u_status, 3,1);
          echo "<tr><td><a href='profile_admin/". $record->id ."'>".
                $record->name . " " . $record->surname .
                "</a></td><td>".
                $record->nickname .
                "</td><td>".
                $record->email .
                "</td><td class='text-center'>".
                $record->phone .
                "</td><td class='text-center'>".
                $district .
                "</td><td>".
                $grade .
                "</td><td>".
                $remark .
                "</td><td class='text-center'>";
                //check image profile
                if($countimage == 1){
                  echo "<a href='".$image."' target='_blank' ><label class='fa fa-photo' style='cursor:pointer;'></label></a>";
                }
                //check validate email
                if($mail_st == 1){
                  echo "<img src='".$root_url."/public/image/email-valid.png' width='20px' />";
                }else{
                  echo "<img src='".$root_url."/public/image/email-not.png' width='20px' />";
                }
                //check id card status
                if($id_st == 1 && $id_valid == 1){
                  echo "<a href='".$idpath."' target='_blank'><img src='".$root_url."/public/image/id-valid.png' width='20px' /></a>";
                }else if($id_st == 1 && $id_valid == 0){
                  echo "<a href='".$idpath."' target='_blank'><img src='".$root_url."/public/image/id-not.png' width='20px' /></a>";
                }
          echo  "</td><td class='text-center'><a href='useredit_admin/".
                $record->id .
                "'><img src='".$root_url."/public/image/file_edit.png' width='20px' /></a></td><tr>";
        }

        echo "</tbody>
                </table>";


    }

    public static function get_distric_select(){

        $districts = district::orderBy('name')->get();

        $return_data = "";

        foreach ($districts as $distric) {
            $return_data .= "<option value=".$distric->id.">".$distric->name."</option>";
        }

        echo $return_data;

    }

    public static function update_user(){

      $user_id = Request::input('user_id');
      $permission = Request::input('permission');
      $validate_id_status = Request::input('validate_id_status');

      if($validate_id_status == true){
        $validate_id = "1";
      }else{
        $validate_id = "0";
      }

      $user = Member::where("id","=",$user_id)->first();

      $oldvalidate = $user->validate;

      $mail_st = substr($oldvalidate, 1,1);
      $upload_id = substr($oldvalidate, 2,1);

      $new_validate = "1".$mail_st.$upload_id.$validate_id;

      $user->permission = $permission;
      $user->validate = $new_validate;

      if($user->save()) {
          return Redirect::to('profile_admin/'. $user_id)
            ->with('status', 'แก้ไขข้อมูลสำเร็จ');
      } else {
          return Redirect::to('useredit_admin/'. $user_id)
            ->withErrors('เกิดข้อผิดพลาดไม่สามารถแก้ไขข้อมูลได้');
      }


    }

    public static function update_user_form($user_id,$value_name){

        $user = Member::where("id","=",$user_id)->first();

        $return_value = $user->$value_name;

        if($value_name == "permission"){

          $data_permissions = [
                              "1"=>"User - ผู้ใช้ทั่วไป",
                              "2"=>"Staff - พนักงาน",
                              "3"=>"Admin - ผู้ดูแลระบบ"
                              ];

          $return_data = "<select name='permission' id='permission' class='form-control'>";
            foreach($data_permissions as $permission => $permission_value){
                $return_data .= "<option value='".$permission."'";
                    if($return_value == $permission){
                      $return_data .= " selected='selected'";
                    }
                $return_data .= ">".$permission_value."</option>";
            }
          $return_data .= "</select>";

        }else if($value_name == "validate"){

          $oldvalidate = $return_value;
          $validate_id_status = substr($oldvalidate, 3,1);

          if($validate_id_status == 1){
            $return_data = "checked";
          }else{
            $return_data = "";
          }

        }else{
          $return_data = $return_value;
        }

        echo $return_data;
    }

}
