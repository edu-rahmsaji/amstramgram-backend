<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', function () {
    return PostResource::collection(Post::all());
});
Route::get('user/{user}/posts', function (User $user) {
    return PostResource::collection(Post::where('user_id', '=', $user->id)->get());
});
Route::get('user/{id}/posts/liked', [PostLikeController::class, 'likedPosts']);
Route::post('posts', [PostController::class, 'create']);
Route::get('posts/{id}/likers', [PostController::class, 'likers']);

Route::get('posts/{post}', function (Post $post) {
    return new PostResource($post);
});

Route::post('user', [UserController::class, 'create']);
Route::get('user/{user}', function (User $user) {
    return new UserResource($user);
});

Route::get('user/{id}/followers', [FollowController::class, 'readFollowers']);
Route::get('user/{id}/followed', [FollowController::class, 'readFollowed']);
