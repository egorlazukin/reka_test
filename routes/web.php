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
Route::get('/panel/update/{id}', function () {
    return view('panel_update');
});



//api
Route::post('/api/user/login', [UsersController::class, 'CheckPassword']);
Route::post('/api/user/register', [UsersController::class, 'Register']);

Route::post('/api/spisok/add/', [SpisokController::class, 'AddNewItem']);
Route::put('/api/spisok/update/{id_tovar}', [SpisokController::class, 'UpdateItem']);
Route::post('/api/spisok/list/', [SpisokController::class, 'GetListItem']);

Route::post('/api/upload-photo/', [SpisokController::class, 'SetPhotoItem']);
Route::get('/api/upload-photo/{id_user}', [SpisokController::class, 'UpdatePhoto']);

Route::post('/api/spisok/search/tags/', [SpisokController::class, 'SearsListItemTags']);