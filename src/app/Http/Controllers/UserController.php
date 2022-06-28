<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private const SHOW_NUMBER = 10;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 引数のページ数に応じてusersテーブルから10件ずつ追加で取得して該当するユーザーの情報をobjectで返す
     *
     * @return object
     */
    public function getUserList($page)
    {
        $count = self::SHOW_NUMBER * $page;
        $allUser = User::all()->whereBetween('id', [1, $count]);
        $loginUser = Auth::user();
        unset($allUser[$loginUser["id"] - 1]);
        return $allUser;
    }

    /**
     * getUserListで引数にしているページが最大何ページまで対応できるのか、その値を返す
     * 
     * @return integer
     */
    public function getMaxPage()
    {
        $showNum = self::SHOW_NUMBER;
        $maxCount = User::all()->count();
        return $maxCount % $showNum == 0 ? $maxCount / $showNum : $maxCount / $showNum + 1;
    }

    /**
     * ログインユーザーの情報を返す
     * 
     * @return object
     */
    public function getLoginUser()
    {
        return Auth::user();
    }

    /**
     * ログアウトする
     * 
     * @return void
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    /**
     * 引数と一致するidのユーザー情報を取得してその値を返す
     * 
     * @return object
     */
    public function show(User $id)
    {
        return $id;
    }
}
