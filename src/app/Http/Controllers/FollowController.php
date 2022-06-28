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
    public function getFollowList()
    {
        return Follow::all()->where('followingId', Auth::id());
    }

    /**
     * idが引数と一致する人のフォローしている人数を取得してその値を返す
     * 
     * @return integer
     */
    public function getFollowingCount($id)
    {
        return Follow::where('followingId', $id)->count();
    }

    /**
     * idが引数と一致する人のフォローされている人数を取得してその値を返す
     * 
     * @return integer
     */
    public function getFollowedCount($id)
    {
        return Follow::where('followedId', $id)->count();
    }

    /**
     * フォローする
     * 
     * レコードを作成しfollowsテーブルに追加する
     * 
     * @return void
     */
    public function follow($id)
    {
        Follow::firstOrCreate([
            'followedId' => $id,
            'followingId' => Auth::id(),
        ]);
    }

    /**
     * フォロー解除する
     * 
     * followsテーブルに検索をかけて、一致したものがあった場合レコードをデリートする
     * 
     * @return void
     */
    public function unfollow($id)
    {
        $follow = Follow::where('followedId', $id)
            ->where('followingId', Auth::id())
            ->first();
        if ($follow) {
            $follow->delete();
        }
    }
}
