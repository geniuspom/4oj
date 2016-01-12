<?php
namespace App\Http\Controllers;
use App\Models\bank as bank;
use App\Models\education as education;

Class Getdataform extends Controller{
    public static function getbank($id){

        $bank = bank::orderBy('id')->get();

        echo "<select name='bank' id='bank' class='form-control'>";
            foreach ($bank as $recode){
                echo "<option value='".$recode->id."'" ;
                    if ($id == $recode->id){
                        echo " selected='selected'";
                    }
                echo ">".$recode->name."</option>";
            }
        echo "</select>";
    }

    public static function geteducation($id){

        $education = education::orderBy('id')->get();

        echo "<select name='education' id='education' class='form-control'>";
            foreach ($education as $recode){
                echo "<option value='".$recode->id."'" ;
                    if ($id == $recode->id){
                        echo " selected='selected'";
                    }
                echo ">".$recode->name."</option>";
            }
        echo "</select>";
    }

}
