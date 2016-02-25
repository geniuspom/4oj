<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\images as imageDB;
use App\Models\idcard as idcardDB;
use App\Models\Member as Member;
use Request;
//use Image;

class uploadfunction extends Controller{

  public static function main(){
    $root_url = dirname($_SERVER['PHP_SELF']);
    $role_method = Request::input('method');
    $user_id = Request::input('user_id');

    ############ Configuration ##############
    $thumb_square_size = 206; //Thumbnails will be cropped to 200x200 pixels
    $max_image_size = 2000; //Maximum image size (height and width)

    if($role_method == 'profile'){$folder = "images";}else{$folder = "idcard";}

    $destination_folder = '..' . $root_url . '/upload_file/'. $folder .'/default/';
    $show_folder_url = $root_url . '/upload_file/'. $folder .'/thumbnail/';
    $link_folder_url = $root_url . '/upload_file/'. $folder .'/default/';

    $jpeg_quality = 90; //jpeg quality
    ##########################################
    //continue only if $_POST is set and it is a Ajax request
    if (isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

        // check $_FILES['ImageFile'] not empty
        if (!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])) {
            die('Image file is Missing!'); // output error when above checks fail.
        }

        //uploaded file info we need to proceed
        $image_name = $_FILES['image_file']['name']; //file name
        $image_size = $_FILES['image_file']['size']; //file size
        $image_temp = $_FILES['image_file']['tmp_name']; //file temp

        $image_size_info = getimagesize($image_temp); //get image size

        if ($image_size_info) {
            $image_width = $image_size_info[0]; //image width
            $image_height = $image_size_info[1]; //image height
            $image_type = $image_size_info['mime']; //image type
        } else {
            die("Make sure image file is valid!");
        }

        //switch statement below checks allowed image type
        //as well as creates new image from given file
        switch ($image_type) {
            case 'image/png':
                $image_res = imagecreatefrompng($image_temp);
                break;
            case 'image/gif':
                $image_res = imagecreatefromgif($image_temp);
                break;
            case 'image/jpeg': case 'image/pjpeg':
                $image_res = imagecreatefromjpeg($image_temp);
                break;
            default:
                $image_res = false;
        }

        if ($image_res) {
            //Get file extension and name to construct new file name
            $image_info = pathinfo($image_name);
            $image_extension = strtolower($image_info["extension"]); //image extension
            $image_name_only = strtolower($image_info["filename"]); //file name only, no extension
            //create a random name for new image (Eg: fileName_293749.jpg) ;

            if($role_method == "profile"){
                $new_file_name = "imageprofile_id".$user_id.".".$image_extension;
                $destination_output = "#result_profile";
            }else{
                $new_file_name = "idcard_id".$user_id.".".$image_extension;
                $destination_output = "#result_idcard";
            }

            //folder path to save resized images and thumbnails
            $thumb_save_folder = '..' . $root_url . '/upload_file/'. $folder .'/thumbnail/' . $new_file_name;
            $image_save_folder = $destination_folder . $new_file_name;

            //call normal_resize_image() function to proportionally resize image
            if (uploadfunction::normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality)) {
                //call crop_image_square() function to create square thumbnails
                if (!uploadfunction::crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality)) {
                    die('Error Creating thumbnail');
                }

                $htmlcode = '<div align="left"><a href="'.$link_folder_url.$new_file_name.'" target="_blank"><img src="'. $show_folder_url . $new_file_name . '" alt="Thumbnail"></a></div>';

                $arr = array("htmlcode"=>$htmlcode, "filename"=>$new_file_name, "destination_output"=>$destination_output,);

                uploadfunction::save_database($user_id,$new_file_name,$role_method);

                return json_encode($arr);


            }

            imagedestroy($image_res); //freeup memory
        }
    }
  }

    #####  This function will proportionally resize image #####

    public static function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality) {

        if ($image_width <= 0 || $image_height <= 0) {
            return false;
        } //return false if nothing to resize
        //do not resize if image is smaller than max size
        if ($image_width <= $max_size && $image_height <= $max_size) {
            if (uploadfunction::save_image($source, $destination, $image_type, $quality)) {
                return true;
            }
        }

        //Construct a proportional size of new image
        $image_scale = min($max_size / $image_width, $max_size / $image_height);
        $new_width = ceil($image_scale * $image_width);
        $new_height = ceil($image_scale * $image_height);

        $new_canvas = imagecreatetruecolor($new_width, $new_height); //Create a new true color image
        //Copy and resize part of an image with resampling
        if (imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)) {
            uploadfunction::save_image($new_canvas, $destination, $image_type, $quality); //save resized image
        }

        return true;
    }



  ##### This function corps image to create exact square, no matter what its original size! ######

  public static function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality) {
      if ($image_width <= 0 || $image_height <= 0) {
          return false;
      } //return false if nothing to resize

      if ($image_width > $image_height) {
          $y_offset = 0;
          $x_offset = ($image_width - $image_height) / 2;
          $s_size = $image_width - ($x_offset * 2);
      } else {
          $x_offset = 0;
          $y_offset = ($image_height - $image_width) / 2;
          $s_size = $image_height - ($y_offset * 2);
      }
      $new_canvas = imagecreatetruecolor($square_size, $square_size); //Create a new true color image
      //Copy and resize part of an image with resampling
      if (imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)) {
          uploadfunction::save_image($new_canvas, $destination, $image_type, $quality);
      }

      return true;
  }

  ##### Saves image resource to file #####

  public static function save_image($source, $destination, $image_type, $quality) {
      switch (strtolower($image_type)) {//determine mime type
          case 'image/png':
              imagepng($source, $destination);
              return true; //save png file
              break;
          case 'image/gif':
              imagegif($source, $destination);
              return true; //save gif file
              break;
          case 'image/jpeg': case 'image/pjpeg':
              imagejpeg($source, $destination, $quality);
              return true; //save jpeg file
              break;
          default: return false;
      }
  }

  public static function save_database($user_id,$save_name,$role_method){

    if($role_method == "profile"){

        $count = imageDB::where('image_user', '=', $user_id)->count();

        if($count == 1){
          $database = imageDB::where('image_user', '=', $user_id)->first();
        }else{
          $database = new imageDB;
        }

        $database->image_name = $save_name;
        $database->image_thumbnail = "upload_file/images/thumbnail/".$save_name;
        $database->image_user = $user_id;

    }else{

        $count = idcardDB::where('id_user', '=', $user_id)->count();

        if($count == 1){
          $database = idcardDB::where('id_user', '=', $user_id)->first();
        }else{
          $database = new idcardDB;
        }

        $database->id_name = $save_name;
        $database->id_thumbnail = "upload_file/idcard/thumbnail/".$save_name;
        $database->id_user = $user_id;

        //update id validate status
        $user = Member::where('id', '=', $user_id)->first();

        $validate = $user->validate;

        $mail_st = substr($validate, 1,1);
        $verify_id = substr($validate, 3,1);

        $new_validate = "1".$mail_st."1".$verify_id;

        $user->validate = $new_validate;

        $user->save();
        //End update id validate status

    }

    $database->save();

  }


}
