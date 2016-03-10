<?php
namespace App\Http\Controllers\After_event;
use App\Http\Controllers\Controller;
use App\Models\Database\after_event as DBafter_event;
use Request;
use Auth;
use Illuminate\Support\Facades\Redirect;

Class after_event_Manage extends Controller{

  public static function get_data($event_id){

    $after_event = DBafter_event::where('event_id','=',$event_id)->first();

    if(count($after_event) > 0){

            $data = [
                        "id" => $after_event->id,
                        "note" => $after_event->note,
                        "self_register" => $after_event->self_register,
                        "proxy_register" => $after_event->proxy_register,
                        "created_by" => $after_event->created_by,
                        "event_id" => $after_event->event_id,
            ];

        return $data;
    }

  }

  public static function updatedata(){

    $event_id = Request::input('event_id');
    $note = Request::input('note');
    $proxy_register = Request::input('proxy_register');
    $self_register = Request::input('self_register');
    $created_by = Auth::user()->id;

    $after_event = DBafter_event::where('event_id','=',$event_id)->first();

    if(count($after_event) == 0){

      $after_event = new DBafter_event();

    }

    $after_event->note = $note;
    $after_event->self_register = $self_register;
    $after_event->proxy_register = $proxy_register;
    $after_event->created_by = $created_by;
    $after_event->event_id = $event_id;

    $after_event->save();

    return redirect::to('assigment/'.$event_id)
            ->with('status',"บันทึกสำเร็จ");

  }


}
