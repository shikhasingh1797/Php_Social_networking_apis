<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>'auth:api'],function(){
    Route::get('getUserDetails','UserControlller@getUserDetails');
});

Route::post('/signup-user',[UserController::class,'signupUser']);
Route::post('/login-user',[UserController::class,'loginUser']);
Route::put('/profile-update',[UserController::class,'profileUpdate']);
Route::delete('/profile-delete',[UserController::class,'profileUpdate']);