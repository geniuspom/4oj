<?php
namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\images as upload;
use App\Models\idcard as idcard;

use Request;
use Image;

class UploadController extends Controller{
    public function getIndex(){
        $images = upload::get();
        return view('upload.index',['images' => $images]);
    }

    public function postAction(){
        if(Request::exists('btn-upload')){
            $file = Request::file('uploader');
            $path = 'images/uploads';
            $filename = $file->getClientOriginalName();
            $file->move('images/uploads',$file->getClientOriginalName());
            $image = new upload;
            $image->image_name = $filename;
            $image->save();

        }
        return redirect()->back();
    }

    //Upload profile picture
    public function profilepicture(){

      if(Request::exists('btn-upload')){
        $user_id = Request::input('user_id');
        $file = Request::file('uploader');
        $path = 'upload_file/images/default';
        $filename = $file->getClientOriginalName();
        $file->move('upload_file/images/default',$file->getClientOriginalName());

        //create thumbnail
        $img = Image::make('upload_file/images/default/'.$filename);

        if($img->height() == $img->width()){
          $imgresult = $img->resize(206, 206);
        }else if($img->height() > $img->width()){
          $imgresult = $img->resize(206, null, function ($constraint) {
          $constraint->aspectRatio();
          });
        }else{
          $imgresult = $img->resize(null, 206, function ($constraint) {
          $constraint->aspectRatio();
          });
        }

        $imgresult->save('upload_file/images/thumbnail/'.$filename);
        $thunbnail = 'upload_file/images/thumbnail/'.$filename;
        //end create thumbnail

        //find image by userid
        $count = upload::where('image_user', '=', $user_id)->count();

        if($count == 1){
          $image = upload::where('image_user', '=', $user_id)->first();
          $image_path = $_SERVER['DOCUMENT_ROOT'] . '/4oj/upload_file/images/default/' . $image->image_name;
          $image_thumbnail = $_SERVER['DOCUMENT_ROOT'] . '/4oj/' . $image->image_thumbnail;
          unlink($image_path);
          unlink($image_thumbnail);

          //update link
          $image->image_name = $filename;
          $image->image_thumbnail = $thunbnail;
          $image->save();

        }
        //Not found image
        else{
          //save to batabase
          $image = new upload;
          $image->image_name = $filename;
          $image->image_user = $user_id;
          $image->image_thumbnail = $thunbnail;
          $image->save();
        }

      }
      return redirect()->back();

    }

    //Get profile picture
    public static function getImage($id,$type){
        $count = upload::where('image_user', '=', $id)->count();

        if($count == 1){
          $images = upload::where('image_user', '=', $id)->first();

          if($type == 'image'){
            return $images->image_name;
          }else if($type == 'thumbnail'){
            return $images->image_thumbnail;
          }
        }

    }

    //Upload id card
    public function uploadidcard(){

      if(Request::exists('btn-upload')){
        $user_id = Request::input('user_id');
        $file = Request::file('uploader');
        $path = 'upload_file/idcard/default';
        $filename = $file->getClientOriginalName();
        $file->move('upload_file/idcard/default',$file->getClientOriginalName());

        //check file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if($ext == 'pdf'){
          //if pdf set pdf icon to thumbnail
          $thunbnail = 'upload_file/idcard/thumbnail/pdf.png';

        }else if($ext == 'jpg' || $ext == 'png' || $ext == 'gif'){
          //if image create thumbnail
          $img = Image::make('upload_file/idcard/default/'.$filename);

          if($img->height() == $img->width()){
            $imgresult = $img->resize(206, 206);
          }else if($img->height() > $img->width()){
            $imgresult = $img->resize(206, null, function ($constraint) {
            $constraint->aspectRatio();
            });
          }else{
            $imgresult = $img->resize(null, 206, function ($constraint) {
            $constraint->aspectRatio();
            });
          }

          //set and save resize image to thumbnail
          $imgresult->save('upload_file/idcard/thumbnail/'.$filename);
          $thunbnail = 'upload_file/idcard/thumbnail/'.$filename;

        }

        $count = idcard::where('id_user', '=', $user_id)->count();

        if($count == 1){
          $dbidcard = idcard::where('id_user', '=', $user_id)->first();

          $oldext = pathinfo($dbidcard->id_name, PATHINFO_EXTENSION);

          $image_path = $_SERVER['DOCUMENT_ROOT'] . '/4oj/upload_file/idcard/default/' . $dbidcard->id_name;

          if($oldext != 'pdf'){
            $image_thumbnail = $_SERVER['DOCUMENT_ROOT'] . '/4oj/' . $dbidcard->id_thumbnail;
            unlink($image_thumbnail);
          }

          unlink($image_path);

          //update link
          $dbidcard->id_name = $filename;
          $dbidcard->id_thumbnail = $thunbnail;
          $dbidcard->save();

        }
        //Not found image
        else{

          //save to batabase
          $dbidcard = new idcard;
          $dbidcard->id_name = $filename;
          $dbidcard->id_user = $user_id;
          $dbidcard->id_thumbnail = $thunbnail;
          $dbidcard->save();

        }

      }
      return redirect()->back();

    }

    //Get id card
    public static function getidcard($id,$type){
        $count = idcard::where('id_user', '=', $id)->count();

        if($count == 1){
          $resultidcard = idcard::where('id_user', '=', $id)->first();

          if($type == 'image'){
            return $resultidcard->id_name;
          }else if($type == 'thumbnail'){
            return $resultidcard->id_thumbnail;
          }
        }

    }

    //create thumbnail
    /*public static function resize_thumbnail($id){
      $count = upload::where('image_user', '=', $id)->count();

      if($count == 1){
        $images = upload::where('image_user', '=', $id)->first();
        $path_img = $images->image_name;

        $img = Image::make('upload_file/images/default/' . $path_img);

        if($img->height() > $img->width()){
          $imgresult = $img->resize(null, 206, function ($constraint) {
          $constraint->aspectRatio();
          });
        }else{
          $imgresult = $img->resize(206, null, function ($constraint) {
          $constraint->aspectRatio();
          });
        }
        $imgresult;

      }

    }*/

}
