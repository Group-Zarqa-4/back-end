<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('users/{id?}', [ApiController::class, 'getUsers']);

// return story/ies info
Route::get('stories/{id?}', [ApiController::class, 'getStories']);

// return comment/s info
Route::get('comments/{id?}', [ApiController::class, 'getComments']);


// ============ post methods ==========

//store new user
Route::post('storeUser', [ApiController::class, 'storeUser']);

//store new story
Route::post('storeStory', [ApiController::class, 'storeStory']);


//store new comment
Route::post('storeComment', [ApiController::class, 'storeComment']);


// ============ put methods ==========

//update user
Route::post('updateuser/{id}', [ApiController::class, 'updateUser']);

//update story
Route::put('updateStory', [ApiController::class, 'updateStory']);

//update comment
Route::put('updateComment', [ApiController::class, 'updateComment']);


// ============ delete methods ==========

//delete user
Route::delete('deleteuser/{id}', [ApiController::class, 'deleteUser']);

//delete user
Route::delete('deleteStory', [ApiController::class, 'deleteStory']);

//delete user
Route::delete('deletecomment/{id}', [ApiController::class, 'deleteComment']);
