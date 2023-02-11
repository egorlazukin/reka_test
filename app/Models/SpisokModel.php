<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class SpisokModel extends Model
{
    use HasFactory;
    public static function AddNewItem($hash, $text)
    {
        $user_check = SpisokModel::hash_cheker($hash);
        if ($user_check == null) {
            return json_encode(["error"=>"403", "message"=>"The entered hash is not correct", 'color'=>'red']);
        }

        $id_users = json_decode(json_encode($user_check), true)['id_users'];

        $id_item = DB::table('spisok')->insertGetId([
                'Text' => $text, 
                'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Default_pfp.svg/150px-Default_pfp.svg.png', 
                'id_users' => $id_users,
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s'), 
        ]);

        return json_encode(["id_item" => $id_item, 'message'=>'Добавлена новая запись.', 'color'=>'green']);
    }
    public static function GetListItem($hash)
    {
        $user_check = SpisokModel::hash_cheker($hash);
        if ($user_check == null) {
            return json_encode(["error"=>"403", "message"=>"The entered hash is not correct", 'color'=>'red']);
        }
        $id_users = json_decode(json_encode($user_check), true)['id_users'];
        $array_Item = DB::table('spisok') ->select('id', 'Text', 'photo', 'created_at') -> where('id_users', '=', $id_users) ->get();
        $array_Item = json_decode(json_encode($array_Item), true);
        $array_tags = [];
        
        foreach ($array_Item as $key => $value) {
           $array_tags[] = ["item_tags"=>SpisokModel::getTags($value['id']), "item"=>$value];
        }
        return json_encode($array_tags);
    }
    static function GetTags($id){
        return DB::table('tags') ->select('tags') -> where('id_spisok', '=', $id) ->get();
    }
    static function hash_cheker($hash)
    {
        return DB::table('hash_auth_private_key') ->select('id_users') -> where('hash_login', '=', $hash) ->first();
    }
}
