<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tweet\PostRequest;
use App\Models\Favorite;
use App\Models\Follow;
use App\Models\Retweet;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id, Tweet $tweet): object
    {
        return $tweet->getTimeLine($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, Tweet $tweet): bool
    {
        return $tweet->createTweet(Auth::id(), $request);
    }

    /**
     * ツイートの状態を取得する
     * 
     * ファボリストとリツイートリストの取得
     * 
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, int $tweetId, Tweet $tweet): bool
    {
        return $tweet->updateTweet($tweetId, $request, Auth::id());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $tweetId, Tweet $tweet): bool
    {
        return $tweet->destroyTweet($tweetId, Auth::id());
    }

    /**
     * Tweet単体の情報と状態を取得
     *
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

    /**
     * home用のタイムラインを取得
     * 
     * @return object
     */
    public function getTimelines(Tweet $tweet, Follow $follow): object
    {
        $list = $follow->getFollowIds(Auth::id());
        array_push($list, Auth::id());
        return $tweet->getTimeLines($list);
    }
}
