<?php

namespace App\Http\Controllers;

use App\Consts\TweetStatus;
use App\Models\Retweet;
use App\Models\Timeline;
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
    public function getRetweetList(int $id, Retweet $retweet)
    {
        return $retweet->getRetweetList($id, Auth::id());
    }

    /**
     * リツイートする
     * 
     * @return void
     */
    public function retweet(int $tweetId, Retweet $retweet, Timeline $timeline)
    {
        $retweet->retweet($tweetId, Auth::id());
        $timeline->createTimeline(Auth::id(), $tweetId, TweetStatus::TWEET_STATUS_IS_RETWEET);
    }

    /**
     * リツイートを解除する
     * 
     * @return void
     */
    public function unretweet(int $tweetId, Retweet $retweet, Timeline $timeline)
    {
        $retweet->unretweet($tweetId, Auth::id());
        $timeline->destroyTimeline(Auth::id(), $tweetId, TweetStatus::TWEET_STATUS_IS_FAVORITE);
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
