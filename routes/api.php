<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SocialMediaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    });
// Route::get('/signup',[UserController::class,'signup']);

// For user
Route::post('/signup-user',[UserController::class,'signupUser']);
Route::post('/login-user',[UserController::class,'loginUser'])->name('login-user');
Route::put('/profile-update',[UserController::class,'profileUpdate'])->middleware('auth:api');
Route::delete('/profile-delete',[UserController::class,'profileDelete']);

// For photos
Route::post('/upload', [PhotoController::class, 'upload'])->middleware('auth:api');
Route::get('/getAllPhotos',[PhotoController::class,'getAllPhotos']);
Route::post('/updatePhotos',[PhotoController::class,'updatePhotos'])->middleware('auth:api');
Route::delete('/deletePhotos/{id}',[PhotoController::class,'deletePhotos']);

// For comments
Route::post('/postComment/{id}',[CommentController::class,'postComment']);
Route::get('/getAllComments',[CommentController::class,'getAllComments']);
Route::put('/updateComment/{id}',[CommentController::class,'updateComment']);
Route::delete('/deleteComment/{id}',[CommentController::class,'deleteComment']);

// For social_media
Route::post('/postSocialMedia',[SocialMediaController::class,'postSocialMedia']);
Route::get('/getAllSocialMedias',[SocialMediaController::class,'getAllSocialMedias']);
Route::put('/updateSocialMedia/{id}',[SocialMediaController::class,'updateSocialMedia']);
Route::delete('/deleteSocialMedia/{id}',[SocialMediaController::class,'deleteSocialMedia']);


// Relation between user and photo
Route::get('userphoto',[UserController::class,'userphoto']);
// Route::get('userSocialMedia',[UserController::class,'userSocialMedia']);
Route::get('userSocialMedia/{id}',[UserController::class,'userSocialMedia'])->middleware('auth:api');