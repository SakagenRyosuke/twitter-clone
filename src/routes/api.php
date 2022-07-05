<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth')->group(function () {
    /**
     * ログインユーザーの取得
     * NavComponent
     */
    Route::get('/loginUser', [UserController::class, 'getLoginUser']);
    /**
     * ログアウトの実行
     * NavComponent
     */
    Route::post('/logout', [UserController::class, 'logout']);
    /**
     * ユーザー一覧の取得
     * UserListComponent
     */
    Route::get('/index', [UserController::class, 'index']);
    /**
     * 引数のidとログインユーザーのidが一致するかどうかをブール値で取得
     * UserListDetailComponent
     */
    Route::get('/isLoginUser/{user}', [UserController::class, 'isLoginUser']);
    /**
     * idと一致するユーザーの取得
     * UserListDetailComponent
     */
    Route::get('/userProfile/{user}', [UserController::class, 'show']);
    /**
     * idが引数と一致するユーザーのtweetを取得
     * UserListDetailComponent
     */
    Route::get('/timeLine/{id}', [TweetController::class, 'index']);
    /**
     * ログインユーザーのフォローリストの取得
     * FollowButtonComponent
     */
    Route::get('/users/followList/{id}', [FollowController::class, 'getFollowList']);
    /**
     * フォローの実行
     * FollowButtonComponent
     */
    Route::post('/users/{id}/follow', [FollowController::class, 'follow']);
    /**
     * フォロー解除の実行
     * FollowButtonComponent
     */
    Route::post('/users/{id}/unfollow', [FollowController::class, 'unfollow']);
});
