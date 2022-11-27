<?php

namespace App\Http\Controllers;

use App\Consts\TweetStatus;
use App\Http\Requests\Tweet\PostRequest;
use App\Models\Favorite;
use App\Models\Retweet;
use App\Models\Timeline;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tweet $tweet
     * @param \App\Models\Timeline $timeline
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, Tweet $tweet, Timeline $timeline)
    {
        $tweetId = $tweet->createTweet(Auth::id(), $request);
        return $timeline->createTimeline(Auth::id(), $tweetId, TweetStatus::TWEET_STATUS_IS_VANILLA);
    }

    /**
     * ツイートの状態を取得する
     * 
     * ファボリストとリツイートリストの取得
     * 
     * @param \App\Models\Favorite $favorite
     * @param \App\Models\Retweet $retweet
     * @return array
     */
    public function getTweetStatus(Favorite $favorite, Retweet $retweet): array
    {
        $favoriteIds = $favorite->getFavoriteIds(Auth::id());
        $retweetIds = $retweet->getRetweetIds(Auth::id());

        return [
            'favoriteIds' => $favoriteIds,
            'retweetIds' => $retweetIds
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param int $tweetId
     * @param \App\Models\Tweet $tweet
     * @return bool
     */
    public function update(PostRequest $request, int $tweetId, Tweet $tweet): bool
    {
        return $tweet->updateTweet($tweetId, $request, Auth::id());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param int $tweetId
     * @param \App\Models\Tweet $tweet
     * @return bool
     */
    public function destroy(int $tweetId, Tweet $tweet): bool
    {
        return $tweet->destroyTweet($tweetId, Auth::id());
    }

    /**
     * Tweet単体の情報と状態を取得
     *
     * @param int $tweetId
     * @param \App\Models\Tweet $tweet
     * @param \App\Models\Favorite $favorite
     * @param \App\Models\Retweet $retweet
     * @return array
     */
    public function show(int $tweetId, Tweet $tweet, Favorite $favorite, Retweet $retweet): array
    {
        return [
            'tweet' => $tweet->getTweet($tweetId),
            'isFavorite' => $favorite->getIsFavorite($tweetId),
            'isRetweet' => $retweet->getIsRetweet($tweetId)
        ];
    }
}
