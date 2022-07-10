<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\User\PostRequest;
use App\Models\Follow;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
     * 引数のページ数に応じてusersテーブルから10件ずつ追加で取得して該当するユーザーの情報をarrayで返す
     *
     * @return array
     */
    public function index(User $user): array
    {
        $users = $user->getUserList(Auth::id());
        return [
            "users" => $users
        ];
    }

    /**
     * ログインユーザーの情報を返す
     * 
     * @return object
     */
    public function getLoginUser(): object
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
     * @return array<object, int>
     */
    public function show(User $user, Follow $follow, Tweet $tweet): array
    {
        return [
            "user" => $user,
            "followingCount" => $follow->getFollowingCount($user["id"]),
            "followedCount" => $follow->getFollowedCount($user["id"]),
            "isAuthUser" => Auth::id() == $user["id"] ? 1 : 0,
            "tweetsCount" => $tweet->getTweetCount($user["id"]),
            "isFollow" => $follow->isFollow($user["id"], Auth::id())
        ];
    }

    /**
     * ログインユーザーかどうかを0,1で返す
     * 
     * @return int
     */
    public function isLoginUser(int $user): int
    {
        return  Auth::id() == $user ? true : false;
    }

    /**
     * ログインユーザーのプロフィールを編集する
     * 
     * @return bool
     */
    public function update(PostRequest $request, User $user): bool
    {
        return $user->updateUser(Auth::id(), $request);
    }

    /**
     * ログインユーザーのIDを取得する
     * 
     * @return int
     */
    public function getAuthId(): int
    {
        return Auth::id();
    }
}
