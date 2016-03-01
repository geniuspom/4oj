<?php
namespace App\Http\Controllers\venue;
use App\Models\Database\venue as venue;
use App\Models\Database\venue_area as venue_area;
use App\Http\Controllers\Controller;
use Request;

Class area extends Controller{

  public static function main($venue_id,$method){

    $data = area::query_data($venue_id);

    if($method == 'form'){
      if(!empty($data) && isset($data)){
        echo area::get_form($data);
      }
    }else{
      if(!empty($data) && isset($data['select'])){
        echo $data['select']['name'];
      }
    }

  }

  public static function get_form($data){

      $return = '<select name="venue_area" id="venue_area" class="form-control">';

      foreach($data['all_area'] as $record){
        $return .= '<option ';

            if(isset($data['select'])){
              if($record['id'] == $data['select']['id']){
                $return .= 'selected="selected"';
              }
            }

        $return .= 'value="'. $record['id'] .'">'. $record['name'] .'</option>';
      }

      $return .= '</select>';

      return $return;

  }

  public static function query_data($venue_id){

      if(!empty($venue_id)){
        $area_select = venue::where('id','=',$venue_id)->first();
      }

      $area_all = venue_area::orderBy('area_name')->get();

      if(isset($area_select) && $area_select->venue_area){
          $data['select'] = ['id' => $area_select->venue_area->id,
                          'name' => $area_select->venue_area->area_name,];
      }

      if(!empty($area_all)){
        foreach($area_all as $record){
            $data['all_area'][] = ['id' => $record->id,
                                'name' => $record->area_name];
        }
      }

      if(!empty($data) && isset($data)){
          return($data);
      }

  }

}
