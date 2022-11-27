<?php

namespace App\Http\Controllers;

use App\Consts\TweetStatus;
use App\Models\Favorite;
use App\Models\Timeline;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * ファボしているツイートを取得する
     * 
     * @param int $id
     * @param \App\Models\Favorite $favorite
     * @return object
     */
    public function getFavoriteList(int $id, Favorite $favorite): object
    {
        return $favorite->getFavoriteList($id, Auth::id());
    }

    /**
     * ファボする
     * 
     * @param int $tweetId
     * @param \App\Models\Favorite $favorite
     * @param \App\Models\Timeline $timeline
     * @return void
     */
    public function favorite(int $tweetId, Favorite $favorite, Timeline $timeline)
    {
        $favorite->favorite($tweetId, Auth::id());
        $timeline->createTimeline(Auth::id(), $tweetId, TweetStatus::TWEET_STATUS_IS_FAVORITE);
    }

    /**
     * ファボを解除する
     * 
     * @param int $tweetId
     * @param \App\Models\Favorite $favorite
     * @param \App\Models\Timeline $timeline
     * @return void
     */
    public function unfavorite(int $tweetId, Favorite $favorite, Timeline $timeline)
    {
        $favorite->unfavorite($tweetId, Auth::id());
        $timeline->destroyTimeline(Auth::id(), $tweetId, TweetStatus::TWEET_STATUS_IS_FAVORITE);
    }

    /**
     * ファボリストの取得
     * 
     * @param \App\Models\Favorite $favorite
     * @return array
     */
    public function getFavoriteIds(Favorite $favorite): array
    {
        return $favorite->getFavoriteIds(Auth::id());
    }
}
