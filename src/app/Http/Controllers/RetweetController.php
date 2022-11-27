<?php

namespace App\Http\Controllers;

use App\Consts\TweetStatus;
use App\Models\Retweet;
use App\Models\Timeline;
use Illuminate\Support\Facades\Auth;

class RetweetController extends Controller
{
    /**
     * リツイートする
     * 
     * @param int $tweetId
     * @param \App\Models\Retweet $retweet
     * @param \App\Models\Timeline $timeline
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
     * @param int $tweetId
     * @param \App\Models\Retweet $retweet
     * @param \App\Models\Timeline $timeline
     * @return void
     */
    public function unretweet(int $tweetId, Retweet $retweet, Timeline $timeline)
    {
        $retweet->unretweet($tweetId, Auth::id());
        $timeline->destroyTimeline(Auth::id(), $tweetId, TweetStatus::TWEET_STATUS_IS_RETWEET);
    }

    /**
     * リツイートリストの取得
     * 
     * @param \App\Models\Retweet $retweet
     * @return array
     */
    public function getRetweetIds(Retweet $retweet): array
    {
        return $retweet->getRetweetIds(Auth::id());
    }
}
