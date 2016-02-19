<?php
namespace App\Http\Controllers\event_task;
use App\Http\Controllers\Controller;
use App\Models\Database\even_job_status as even_job_status;
use Request;
use Illuminate\Support\Facades\Redirect;

Class event_task_manage extends Controller{

  public static function update_event_task(){

      $event_id = Request::input('event_id');

      if(even_job_status::where('id','=',$event_id)->count() > 0){
          $even_job_status = even_job_status::where('id','=',$event_id)->first();
      }else{
          $even_job_status = new even_job_status;
          $even_job_status->id = $event_id;
      }

      for($i = 1;$i < 16;$i++){
        if($i == 5){

            for($r = 1;$r< 8;$r++){
              $st = '5_'.$r.'_status';
              $st_name = '5_'.$r.'_Plan';
              $rp_name = '5_'.$r.'_respons';
              if(Request::input($st) == true){$even_job_status->$st = "1";}else{$even_job_status->$st = "0";}
              $even_job_status->$st_name = Request::input('5_'.$r.'_Plan');
              $even_job_status->$rp_name = Request::input('5_'.$r.'_respons');
            }

        }else{
            $st = $i.'_status';
            $st_name = $i.'_Plan';
            $rp_name = $i.'_respons';
            if(Request::input($st) == true){$even_job_status->$st = "1";}else{$even_job_status->$st = "0";}
            $even_job_status->$st_name = Request::input($i.'_Plan');
            $even_job_status->$rp_name = Request::input($i.'_respons');

        }
      }

      if($even_job_status->save()){
        return redirect::to('assigment/'.$event_id)
                ->with('status',"บันทึกสำเร็จ");
      }


  }

}
