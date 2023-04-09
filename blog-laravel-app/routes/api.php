<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // User
    Route::get('/user',[AuthController::class,'user']);
    Route::post('/logout',[AuthController::class,'logout']);

    // Posts
    Route::get('/posts',[PostController::class,'index']); // get all posts
    Route::post('/posts',[PostController::class,'store']); // create a post
    Route::get('/posts/{id}',[PostController::class,'show']); // get a single post
    Route::put('/posts/{id}',[PostController::class,'update']); // update a post
    Route::delete('/posts/{id}',[PostController::class,'destroy']); // delete a post

    // Comments
    Route::get('/posts/{id}/comments',[CommentController::class,'index']); // get all comments
    Route::post('/posts/{id}/comments',[CommentController::class,'store']); // create a comment
    Route::put('/comments/{id}',[CommentController::class,'update']); // update a comment
    Route::delete('/comments/{id}',[CommentController::class,'destroy']); // delete a comment

    // Likes
    Route::get('/posts/{id}/likes',[LikeController::class,'likeOrUnlike']); // get all likes


});

