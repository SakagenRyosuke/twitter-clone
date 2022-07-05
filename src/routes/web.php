<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
});
