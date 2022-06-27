<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    // ログインユーザーがフォローしている人を取得する
    public function followList()
    {
        return Follow::all()->where('followingId', Auth::user()["id"]);
    }

    public function getNumFollowing($id)
    {
        return Follow::where('followingId', $id)->count();
    }

    public function getNumFollowed($id)
    {
        return Follow::where('followedId', $id)->count();
    }

    //フォローする
    public function follow($id)
    {
        Follow::firstOrCreate([
            'followedId' => $id,
            'followingId' => Auth::id(),
        ]);
    }
    //フォロー解除する
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