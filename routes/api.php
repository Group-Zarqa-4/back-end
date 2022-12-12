<?php

use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
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
Route::post('updateUser', [UserController::class, 'updateUser']);

//update story
Route::post('updateStory', [StoryController::class, 'updateStory']);

//update comment
Route::post('updateComment', [CommentController::class, 'updateComment']);

//update new post
Route::post('updatePost', [PostController::class, 'updatePost']);



// ============ delete methods ==========

//delete user

Route::delete('deleteUser', [UserController::class, 'deleteUser']);

//delete story
Route::delete('deleteStory', [StoryController::class, 'deleteStory']);

//delete comment
Route::delete('deleteComment', [CommentController::class, 'deleteComment']);

//delete user
Route::delete('deletePost', [PostController::class, 'deletePost']);


// ============ Authentication routes ==========

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
Route::post('/loginGoogle', [AuthController::class, "login_google"]);
// Route::post('/loginGoogle', [AuthController::class, "login_google"]);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, "logout"]);
});
