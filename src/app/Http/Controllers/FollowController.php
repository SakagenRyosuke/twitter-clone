<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
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
     * ログインユーザーがフォローしている人を取得する
     * 
     * followingIdがログインIdであるレコードをfollowsテーブルから取得してその値を返す
     * 
     * @return object
     */
    public function getFollowList(int $id, Follow $follow): int
    {
        return $follow->getFollowList($id, Auth::id());
    }

    /**
     * フォローする
     * 
     * レコードを作成しfollowsテーブルに追加する
     * 
     * @return void
     */
    public function follow(int $id, Follow $follow)
    {
        $follow->follow($id, Auth::id());
    }

    /**
     * フォロー解除する
     * 
     * followsテーブルに検索をかけて、一致したものがあった場合レコードをデリートする
     * 
     * @return void
     */
    public function unfollow(int $id, Follow $follow)
    {
        $follow->unfollow($id, Auth::id());
    }

    /**
     * フォローリストの取得
     * 
     * @return array
     */
    public function getFollowIds(Follow $follow): array
    {
        return $follow->getFollowIds(Auth::id());
    }
}
