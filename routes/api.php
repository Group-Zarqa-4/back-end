<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthController;

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

// ============ get methods ==========


// return user/s info
Route::get('users/{id?}', [UserController::class, 'getUsers']);

// return story/ies info
Route::get('stories/{id?}', [StoryController::class, 'getStories']);

// return comment/s info
Route::get('comments/{id?}', [CommentController::class, 'getComments']);

// return post/s info
Route::get('posts/{id?}', [PostController::class, 'getPosts']);




// ============ post methods ==========

//store new user
Route::post('storeUser', [UserController::class, 'storeUser']);

//store new story
Route::post('storeStory', [StoryController::class, 'storeStory']);

//store new comment
Route::post('storeComment', [CommentController::class, 'storeComment']);

//store new post
Route::post('storePost', [PostController::class, 'storePost']);

// ============ update methods ==========


//update user
Route::post('updateUser/{id?}', [UserController::class, 'updateUser']);


//update story
Route::post('updateStory/{id?}', [StoryController::class, 'updateStory']);


//update comment
Route::post('updateComment/{id}', [CommentController::class, 'updateComment']);

//update new post
Route::post('updatePost/{id?}', [PostController::class, 'updatePost']);

// ============ delete methods ==========

//delete user

Route::delete('deleteUser/{id?}', [UserController::class, 'deleteUser']);

//delete story
Route::delete('deleteStory/{id?}', [StoryController::class, 'deleteStory']);

//delete comment
Route::delete('deleteComment/{id?}', [CommentController::class, 'deleteComment']);

//delete user
Route::delete('deletePost/{id?}', [PostController::class, 'deletePost']);


// ============ Authentication routes ==========

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
Route::post('/loginGoogle', [AuthController::class, "login_google"]);
Route::post('/contact', [ContactController::class, "store"]);
Route::get('/contact/all', [ContactController::class, "index"]);
Route::delete('/contact/{id}', [ContactController::class, "destroy"]);

Route::post('/updateUser', [AuthController::class, "update_user"]);
Route::post('/updatePassword', [AuthController::class, "update_password"]);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, "logout"]);
});
