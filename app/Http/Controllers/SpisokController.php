<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpisokModel;

class SpisokController extends Controller
{
    //
    public static function AddNewItem(Request $request)
    {
        $hash = $request['hash'];
        $text = $request['text'];
        if (SpisokController::CheckValide($hash) || SpisokController::CheckValide($text)) 
        {
            return json_encode(["message"=>"Обязательные поля не введены", "error" => "500", 'color'=>'red']);
        }
        return SpisokModel::AddNewItem($hash, $text);
    }
    public static function GetListItem(Request $request)
    {
        $hash = $request['hash'];
        if (SpisokController::CheckValide($hash)) 
        {
            return json_encode(["message"=>"Обязательные поля не введены", "error" => "500", 'color'=>'red']);
        }
        return SpisokModel::GetListItem($hash);
    }
    static function CheckValide($value){
        return $value == "";
    }
}
