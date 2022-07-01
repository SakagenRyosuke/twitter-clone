<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
  /**
   * /にアクセスした場合welcome.bladeを表示する
   * welcome.blade.php
   */
  Route::get('/', function () {
    return view('welcome');
  });
  /**
   * /homeにアクセスした場合home.bladeを表示する
   * home.blade.php
   */
  Route::get('/home', [HomeController::class, 'index'])->name('home');
  /**
   * /home以下にアクセスした場合home.bladeを表示する
   * home.blade.php
   */
  Route::get('/home/{any}', function () {
    return view('home');
  })->where('any', '.*');
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
  Route::get('/index/{page}', [UserController::class, 'index']);
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
