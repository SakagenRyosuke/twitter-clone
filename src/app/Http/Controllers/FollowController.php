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
     * @param int $id
     * @param \App\Models\Follow $follow
     * @return object
     */
    public function getFollowList(int $id, Follow $follow): object
    {
        return $follow->getFollowList($id, Auth::id());
    }

    /**
     * フォローする
     * 
     * @param int $id
     * @param \App\Models\Follow $follow
     * @return void
     */
    public function follow(int $id, Follow $follow)
    {
        $follow->follow($id, Auth::id());
    }

    /**
     * フォロー解除する
     * 
     * @param int $id
     * @param \App\Models\Follow $follow
     * @return void
     */
    public function unfollow(int $id, Follow $follow)
    {
        $follow->unfollow($id, Auth::id());
    }

    /**
     * フォローリストの取得
     * 
     * @param \App\Models\Follow $follow
     * @return array
     */
    public function getFollowIds(Follow $follow): array
    {
        return $follow->getFollowIds(Auth::id());
    }
}
