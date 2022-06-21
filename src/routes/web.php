<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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
Route::post('/userList', [UserController::class, 'userList']);

Route::group(['middleware' => 'auth'], function () {
  Route::get('/', function () {
    return view('welcome');
  });

  Route::get('/home', [HomeController::class, 'index'])->name('home');

  Route::get('/home/{any}', function () {
    return view('home');
  })->where('any', '.*');
});
