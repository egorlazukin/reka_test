<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpisokModel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
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
    public static function UpdateItem(Request $request, $id_tovar)
    {
        $hash = $request['hash'];
        $text = $request['text'];
        $tags = $request['tags'];
        if (SpisokController::CheckValide($hash) || SpisokController::CheckValide($text)) 
        {
            return json_encode(["message"=>"Обязательные поля не введены", "error" => "500", 'color'=>'red']);
        }

        return SpisokModel::UpdateItem($hash, $id_tovar, $text, $tags);
    }

    public function SetPhotoItem(Request $request)
    {

        if( $request->hasFile('photo')){
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $img = Image::make($request->file('photo')->getRealPath());
            $img->resize(150, 150);
            Storage::disk('public')->put($filename, $img->stream()->__toString());
            $fileNameToStore = "/storage/".$filename;
            return ['photo_url' => $fileNameToStore];
        }        
    }
    static function UpdatePhoto(Request $request, $id_tovar)
    {
        $photo_url = $request['photo_url'];
        $hash = $request['hash'];
        return SpisokModel::UpdatePhoto($photo_url, $hash, $id_tovar);
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
    public static function SearsListItemTags(Request $request)
    {
        $hash = $request['hash'];
        $tags = $request['tags'];
        if (SpisokController::CheckValide($hash)) 
        {
            return json_encode(["message"=>"Обязательные поля не введены", "error" => "500", 'color'=>'red']);
        }
        $SearsListItemTags = [];
        foreach (explode(' ', $tags) as $key => $value) {
            $SearsListItemTags = SpisokModel::SearsListItemTags($hash, $tags);
        }
        return $SearsListItemTags;        
    }
    static function CheckValide($value){
        return $value == "";
    }
}
