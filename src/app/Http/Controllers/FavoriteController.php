<?php

namespace App\Http\Controllers;

use App\Consts\TweetStatus;
use App\Models\Favorite;
use App\Models\Timeline;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
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
     * ファボしているツイートを取得する
     * 
     * @return object
     */
    public function getFavoriteList(int $id, Favorite $favorite): int
    {
        return $favorite->getFavoriteList($id, Auth::id());
    }

    /**
     * ファボする
     * 
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
     * @return array
     */
    public function getFavoriteIds(Favorite $favorite): array
    {
        return $favorite->getFavoriteIds(Auth::id());
    }
}
