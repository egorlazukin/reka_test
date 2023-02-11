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
    public static function UpdatePhoto($url_image, $hash, $id_tovar)
    {
        $user_check = SpisokModel::hash_cheker($hash);
        if ($user_check == null) {
            return json_encode(["error"=>"403", "message"=>"The entered hash is not correct", "hash"=>$hash, 'color'=>'red']);
        }
        $id_users = json_decode(json_encode($user_check), true)['id_users'];

        $array_update_photo = DB::table('spisok') -> where('id_users', '=', $id_users) -> where('id', '=', $id_tovar) -> update(['photo' => $url_image]);
        return json_encode(["update"=>$array_update_photo]);

    }
    public static function UpdateItem($hash, $id_tovar, $text, $tags)
    {
        var_dump($tags);
        $user_check = SpisokModel::hash_cheker($hash);
        if ($user_check == null) {
            return json_encode(["error"=>"403", "message"=>"The entered hash is not correct", 'color'=>'red']);
        }
        $id_users = json_decode(json_encode($user_check), true)['id_users'];


        $array_update_photo[] = DB::table('spisok') -> where('id_users', '=', $id_users) -> where('id', '=', $id_tovar) -> update(['text' => $text]);

        
        $delete[] = DB::table('tags') -> where('id_spisok', '=', $id_tovar) -> delete();

        $countTags = 0;
        $count = substr_count($tags, ' ',0);
        if ($count == 0 && $tags != "") 
        {
            DB::table('tags')->insertGetId([
                'tags' => $tags, 
                'id_spisok' => $id_tovar,
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s'), 
            ]);
            $countTags = $countTags + 1;
        }
        elseif ($tags == "") {
            // code...
        }
        else{
            foreach (explode(' ', $tags) as $key => $value) {
                DB::table('tags')->insertGetId([
                    'tags' => $value, 
                    'id_spisok' => $id_tovar,
                    'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s'), 
                ]);
                $countTags = $countTags + 1;
            }
        }
        
        return json_encode(["update"=>$array_update_photo, 'delete' => $delete, 'insert']);

    }

    public static function SearsListItemTags($hash, $tags)
    {
        $user_check = SpisokModel::hash_cheker($hash);
        if ($user_check == null) {
            return json_encode(["error"=>"403", "message"=>"The entered hash is not correct", 'color'=>'red']);
        }
        $id_users = json_decode(json_encode($user_check), true)['id_users'];
        
        $array_Item = json_decode(json_encode(SpisokModel::AllListUser($id_users)), true);
        $array_tags = [];
        foreach ($array_Item as $key => $value) {
            $spisokTags = SpisokModel::SearchTags($value['id'], $tags);
            if ($spisokTags != null) {
                $array_tags[] = ["item_tags"=>$spisokTags, "item"=>$value];
            }
        }

        return json_encode($array_tags);
    }
    static function SearchTags($id, $tags){
        $tags = DB::table('tags') ->select('tags') -> where('id_spisok', '=', $id) -> where('tags', 'like', "%$tags%") -> get();
        if (!empty($tags[0])) {
            return $tags;
        }
        return null;
    }
    static function AllListUser($id_users)
    {
        return DB::table('spisok') -> select('id', 'Text', 'photo', 'created_at') -> where('id_users', '=', $id_users) -> get();
    }
    public static function GetListItem($hash)
    {
        $user_check = SpisokModel::hash_cheker($hash);
        if ($user_check == null) {
            return json_encode(["error"=>"403", "message"=>"The entered hash is not correct", 'color'=>'red']);
        }
        $id_users = json_decode(json_encode($user_check), true)['id_users'];
        $array_Item = json_decode(json_encode(SpisokModel::AllListUser($id_users)), true);
        $array_tags = [];
        
        foreach ($array_Item as $key => $value) {
           $array_tags[] = ["item_tags"=>SpisokModel::GetTags($value['id']), "item"=>$value];
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
