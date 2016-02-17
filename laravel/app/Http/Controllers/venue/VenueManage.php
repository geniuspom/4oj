<?php
namespace App\Http\Controllers\venue;
use App\Models\Database\venue_room as venue_room;
use App\Http\Controllers\Controller;
use Request;

Class VenueManage extends Controller{
    public static function main(){
        $role_method = Request::input('method');
        $data_form = Request::input('data_form');

        $room_name = $data_form['name'];
        $room_plan = $data_form['plan'];
        $venue_id = $data_form['venue_id'];

        if($role_method == "add_new"){
            return VenueManage::add_new_room($room_name,$room_plan,$venue_id);
        }else if($role_method == "update"){
            $room_id = $data_form['room_id'];
            return VenueManage::update_room($room_id,$room_name,$room_plan,$venue_id);
        }else if($role_method == "delete"){
            $room_id = $data_form['room_id'];
            return VenueManage::delete_room($room_id);
        }else if($role_method == "get_room"){
            VenueManage::get_room($venue_id);
        }else if($role_method == "get_room_form"){
            $room_id = $data_form['room_id'];
            return VenueManage::get_edit_room_form($room_id);
        }


    }

    public static function add_new_room($room_name,$room_plan,$venue_id){
        $venue_room = new venue_room();
        $venue_room->room_name = $room_name;
        $venue_room->venue_id = $venue_id;
        $venue_room->room_plan = $room_plan;

        if($venue_room->save()){
          if(!empty($room_plan)){
            $save_id = $venue_room->id;
            VenueManage::rename_room_plan($save_id,$room_plan);
          }
          return json_encode(array("status"=>"complete", "message"=>"เพิ่มห้องประชุมสำเร็จ"));
        }else{
          return json_encode(array("status"=>"error", "message"=>"เกิดข้อผิดพลาด ไม่สามารถเพิ่มห้องประชุมได้"));
        }

    }

    public static function rename_room_plan($room_id,$room_plan){

      $root_url = dirname($_SERVER['PHP_SELF']);
      $destination_folder = '..' . $root_url . '/upload_file/venue/default/';
      $destination_thumbnail = '..' . $root_url . '/upload_file/venue/thumbnail/';

      $image_info = pathinfo($destination_folder.$room_plan);
      $image_extension = strtolower($image_info["extension"]); //image extension


      $new_file_name = "room_plan_".$room_id.".".$image_extension;

      rename($destination_folder.$room_plan, $destination_folder.$new_file_name);
      rename($destination_thumbnail.$room_plan, $destination_thumbnail.$new_file_name);

      $venue_room = venue_room::where('id','=',$room_id)->first();
      $venue_room->room_plan = $new_file_name;

      $venue_room->save();

    }

    public static function update_room($room_id,$room_name,$room_plan,$venue_id){

      $venue_room = venue_room::where('id','=',$room_id)->first();
      $venue_room->room_name = $room_name;
      //$venue_room->venue_id = $venue_id;
      $venue_room->room_plan = $room_plan;

      if($venue_room->save()){
        return json_encode(array("status"=>"complete", "message"=>"แก้ไขห้องประชุมสำเร็จ",));
      }else{
        return json_encode(array("status"=>"error", "message"=>"เกิดข้อผิดพลาด ไม่สามารถแก้ไขปห้องประชุมได้",));
      }

    }

    public static function delete_room($room_id){

      $venue_room = venue_room::where('id','=',$room_id)->first();

      $room_plan = $venue_room->room_plan;
      $room_name = $venue_room->room_name;
      $venue_id = $venue_room->venue_id;

      if(!empty($room_plan)){
          $root_url = dirname($_SERVER['PHP_SELF']);
          $destination_folder = '..' . $root_url . '/upload_file/venue/default/';
          $destination_thumbnail = '..' . $root_url . '/upload_file/venue/thumbnail/';

          unlink($destination_folder.$room_plan);
          unlink($destination_thumbnail.$room_plan);

      }

      if($venue_room->delete()){
        return json_encode(array("status"=>"complete", "message"=>"ลบห้องประชุมชื่อ". $room_name ."สำเร็จ", "venue_id"=>$venue_id));
      }else{
        return json_encode(array("status"=>"error", "message"=>"เกิดข้อผิดพลาด ไม่สามารถแก้ไขปห้องประชุมได้"));
      }

    }

    public static function get_room($venue_id){
      $venue_room = venue_room::where('venue_id','=',$venue_id)->get();

      $htmlreturn = "";

      foreach($venue_room as $data){
          $room_id = $data->id;
          $plan_name = $data->room_name;
          $root_url = dirname($_SERVER['PHP_SELF']);
          $plan_url = $root_url."/upload_file/venue/default/".$data->room_plan;
          $plan_thumbnail = $root_url."/upload_file/venue/thumbnail/".$data->room_plan;

          $htmlreturn .= VenueManage::gererate_html($room_id,$plan_name,$plan_url,$plan_thumbnail);

      }

      echo $htmlreturn;
    }

    public static function gererate_html($room_id,$plan_name,$plan_url,$plan_thumbnail){

      $return_html =  '<div class="panel panel-default" id="room_id_'. $room_id .'">
                        <div class="panel-heading">
                          <h3 class="panel-title">'.$plan_name.'</h3>
                        </div>
                        <div class="panel-body">
                          <div class="form-horizontal">
                              <div class="form-group">
                                  <label class="col-md-5 text-right">ชื่อห้อง</label>
                                  <div class="col-md-6 text-info room_name">'. $plan_name .'
                                  </div>
                                  <div class="col-md-6 text-info" id="form_room_name">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-5 text-right">แบบห้อง</label>
                                  <div class="col-md-6 text-info room_plan">
                                      <div style="width:206px;">
                                          <a target="_blank" href="'. $plan_url .'">
                                              <i style="background-image: url('. $plan_thumbnail .'); display: block; background-position: center center; width: 206px; padding-top: 206px;"></i>
                                          </a>
                                      </div>
                                  </div>
                                  <label class="col-md-5 text-right"></label>
                                  <div class="col-md-6 text-info" id="form_plan_room">
                                  </div>
                              </div>
                              <div class="form-group room_detail_button" >
                                  <div class="col-md-6 col-md-offset-4">
                                      <a class="btn btn-primary edit_room" id="'. $room_id .'"> แก้ไขข้อมูล </a>
                                      <button type="submit" class="btn btn-primary delete_room" id="'. $room_id .'" room_name="'. $plan_name .'">
                                        ลบ
                                      </button>
                                      <a id="'. $room_id .'" class="btn btn-primary confirm_edit_room hidden"> บันทึก </a>
                                      <a id="'. $room_id .'" class="btn btn-primary cancle_edit_room hidden"> ยกเลิก </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                      </div>';

      return $return_html;

    }

    public static function get_edit_room_form($room_id){

      $venue_room = venue_room::where('id','=',$room_id)->first();

      $plan_url = $venue_room->room_plan;

      $room_name = $venue_room->room_name;

      $form_room_name = '<input type="text" class="form-control" name="name" id="room_name" value="'.$room_name.'">
                          <input type="hidden" class="form-control" name="room_url" id="room_url" value="'.$plan_url.'">';

      $form_plan_room = '<form action="../uploadplan" method="post" enctype="multipart/form-data" class="Edit_plan_form" id="Edit_plan_id_'.$room_id.'">
                            <div id="result" class="hidden"></div>
                            <input type="hidden" name="method" value="edit_image">
                            <input type="hidden" name="room_id" value="'.$room_id.'">
                            <input name="image_file" id="imageInput" type="file" />
                            <div class="progress upload_progress hidden" >
                                <div class="bar upload_bar"></div>
                                <div class="percent upload_percent">0%</div>
                            </div>
                            <div id="output"></div>
                            <button room_id="'.$room_id.'" class="edit_plan" value="Upload" >upload</button>
                          </form>';

      return json_encode(array("form_plan_room"=>$form_plan_room, "form_room_name"=>$form_room_name));

    }

}
