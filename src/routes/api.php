<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\RetweetController;
use App\Http\Controllers\TimelineController;
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
     * AuthUserのプロフィール編集
     * EditButtonComponent
     */
    Route::post('/editUser', [UserController::class, 'update']);
    /**
     * AuthUserのidを取得
     * EditButtonComponent
     */
    Route::get('/authId', [UserController::class, 'getAuthId']);
    /**
     * userNameの取得
     * TweetComponent
     */
    Route::get('/userName/{userId}', [UserController::class, 'getUserName']);
    /**
     * idが引数と一致するユーザーのtweetを取得
     * UserListDetailComponent
     */
    Route::get('/timeline/{userId}', [TimelineController::class, 'getTimeline']);
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
    /**
     * フォローリスト取得
     * FollowButtonComponent
     */
    Route::get('/followIds', [FollowController::class, 'getFollowIds']);
    /**
     * Tweetの作成
     * CreateTweetComponent
     */
    Route::post('/createTweet', [TweetController::class, 'store']);
    /**
     * Tweetの編集
     * UpdateTweetComponent
     */
    Route::post('/updateTweet/{tweetId}', [TweetController::class, 'update']);
    /**
     * Tweetの削除
     * DestroyTweetComponent
     */
    Route::post('/destroyTweet/{tweetId}', [TweetController::class, 'destroy']);
    /**
     * Tweetの状態を取得
     * UserListDetailComponent
     */
    Route::get('/tweetStatus', [TweetController::class, 'getTweetStatus']);
    /**
     * Tweet単体の情報と状態を取得
     * TweetDetailComponent
     */
    Route::get('/tweet/{tweetId}', [TweetController::class, 'show']);
    /**
     * ファボする
     * FavoriteComponent
     */
    Route::post('/tweets/{tweetId}/favorite', [FavoriteController::class, 'favorite']);
    /**
     * ファボを解除する
     * FavoriteComponent
     */
    Route::post('/tweets/{tweetId}/unfavorite', [FavoriteController::class, 'unfavorite']);
    /**
     * リツイートする
     * RetweetComponent
     */
    Route::post('/tweets/{tweetId}/retweet', [RetweetController::class, 'retweet']);
    /**
     * リツイートを解除する
     * RetweetComponent
     */
    Route::post('/tweets/{tweetId}/unretweet', [RetweetController::class, 'unretweet']);
    /**
     * Commentの作成
     * CreateCommentComponent
     */
    Route::post('/createComment/{tweetId}', [CommentController::class, 'store']);
    /**
     * Comment一覧の取得
     * TweetDetailComponent
     */
    Route::get('/comments/{tweetId}', [CommentController::class, 'index']);
    /**
     * Comment一覧の取得
     * TweetDetailComponent
     */
    Route::get('/timelines', [TimelineController::class, 'getTimelines']);
});
