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
     * ユーザー情報の取得
     * 
     * @param \App\Models\User $user
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
     * @param \Illuminate\Http\Request $request
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
     * @param \App\Models\User $user
     * @param \App\Models\Follow $follow
     * @param \App\Models\Tweet $tweet
     * @return array<object, int>
     */
    public function show(User $user, Follow $follow, Tweet $tweet): array
    {
        return [
            "user" => $user,
            "followingCount" => $follow->getFollowingCount($user["id"]),
            "followedCount" => $follow->getFollowedCount($user["id"]),
            "isAuthUser" => Auth::id() === $user["id"] ? 1 : 0,
            "tweetsCount" => $tweet->getTweetCount($user["id"]),
            "isFollow" => $follow->isFollow($user["id"], Auth::id())
        ];
    }

    /**
     * ログインユーザーかどうかを0,1で返す
     * 
     * @param int $user
     * @return int
     */
    public function isLoginUser(int $user): int
    {
        return  Auth::id() === $user ? 1 : 0;
    }

    /**
     * ログインユーザーのプロフィールを編集する
     * 
     * @param \App\Http\Requests\User\PostRequest $request
     * @param \App\Models\User $user
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

    /**
     * 名前取得
     * 
     * @param int $userId
     * @param \App\Models\User $user
     * @return string
     */
    public function getUserName(int $userId, User $user): string
    {
        return $user->getUserName($userId);
    }
}
