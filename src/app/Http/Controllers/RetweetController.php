<?php

namespace App\Http\Controllers;

use App\Models\Retweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetweetController extends Controller
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
     * リツイートしているツイートを取得する
     * 
     * @return int
     */
    public function getRetweetList(int $id, Retweet $retweet): int
    {
        return $retweet->getRetweetList($id, Auth::id());
    }

    /**
     * リツイートする
     * 
     * @return void
     */
    public function retweet(int $tweetId, Retweet $retweet)
    {
        $retweet->retweet($tweetId, Auth::id());
    }

    /**
     * リツイートを解除する
     * 
     * @return void
     */
    public function unretweet(int $tweetId, Retweet $retweet)
    {
        $retweet->retweet($tweetId, Auth::id());
    }

    /**
     * リツイートリストの取得
     * 
     * @return array
     */
    public function getRetweetIds(Retweet $retweet): array
    {
        return $retweet->getRetweetIds(Auth::id());
    }
}
