<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersModel;
class UsersController extends Controller
{
    //
    public static function CheckPassword(Request $request)
    {
        $login = $request['login'];
        $password = $request['password'];
        if (UsersController::CheckValide($login) or UsersController::CheckValide($password)) {
            return ["message" => "Login or password no valide"];
        }
        return UsersModel::CheckPassword($login, $password);
    }
    public static function Register(Request $request)
    {
        $login = $request['login'];
        $password = $request['password'];
        if (UsersController::CheckValide($login) or UsersController::CheckValide($password)) {
            return ["message" => "Email or password no valide"];
        }
        return UsersModel::Register($login, $password);
    }
    static function CheckValide($value){
        return $value == "";
    }
}
