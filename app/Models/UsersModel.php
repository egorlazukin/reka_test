<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class UsersModel extends Model
{
    use HasFactory;
    public static function CheckPassword($login, $password)
    {
        $password_hash = DB::table('users') ->select('id', 'password') -> where('login', '=', $login) ->get();

        if($password_hash == "[]")
            return json_encode(["error"=>"403", "message"=>"The entered username is not correct"]);

        $id_users = json_decode($password_hash, true)[0]['id'];
        $password_hash = json_decode($password_hash, true)[0]['password'];

        if (password_verify($password, $password_hash)) {
            $guid = UsersModel::generateHash_Auth($id_users);
            return json_encode(["error"=>"200", "message"=>"Successfully", "cookieID" => $guid[0]['guid']]);
        }
        else{
            return json_encode(["error"=>"403", "message"=>"The entered password is not correct"]);
        }
    }
    static function generateHash_Auth($id_users)
    {
        $guid = UsersModel::getGUID();
        $inserts = DB::table('hash_auth_private_key')->insert(
                [
                    'id_users' => $id_users, 
                    'hash_login' => $guid, 
                ]
            );
            $arr[] = ["return"=>$inserts, "guid"=>$guid];
        return $arr;
        
    }
    static function getGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }
        else {
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
            return $uuid;
        }
    }

    public static function Register($login, $password){
         $user_check = DB::table('users') ->select('id') -> where('login', '=', $login) ->get();

        if($user_check != "[]")
            return json_encode(["error"=>"403", "message"=>"The entered username is not correct"]);

        $id_users = DB::table('users')->insertGetId([
                'login' => $login, 
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s'), 
            ]);
        return json_encode(['id_user' => $id_users]);
    }

}
