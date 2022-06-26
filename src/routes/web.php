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

Route::get('/loginUser', [UserController::class, 'loginUser']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/userList', [UserController::class, 'userList']);
Route::get('/userProfile/{id}', [UserController::class, 'show']);
Route::get('/userProfile/{id}/following', [FollowController::class, 'getNumFollowing']);
Route::get('/userProfile/{id}/followed', [FollowController::class, 'getNumFollowed']);
Route::get('/users/followList', [FollowController::class, 'followList']);
Route::post('/users/{id}/follow', [FollowController::class, 'follow']);
Route::post('/users/{id}/unfollow', [FollowController::class, 'unfollow']);

Route::group(['middleware' => 'auth'], function () {
  Route::get('/', function () {
    return view('welcome');
  });

  Route::get('/home', [HomeController::class, 'index'])->name('home');

  Route::get('/home/{any}', function () {
    return view('home');
  })->where('any', '.*');
});
