<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UsersController;
use \App\Http\Controllers\SpisokController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/panel', function () {
    return view('panel');
});
Route::get('/panel/add/', function () {
    return view('panel_add');
});



//api
Route::post('/api/user/login', [UsersController::class, 'CheckPassword']);
Route::post('/api/user/register', [UsersController::class, 'Register']);

Route::post('/api/spisok/add/', [SpisokController::class, 'AddNewItem']);
Route::post('/api/spisok/list/', [SpisokController::class, 'GetListItem']);

Route::get('/api/spisok/list/', [SpisokController::class, 'GetListItem']);