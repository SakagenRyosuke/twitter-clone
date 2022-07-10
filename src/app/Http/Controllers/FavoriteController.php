<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
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
    public function favorite(int $tweetId, Favorite $favorite)
    {
        $favorite->favorite($tweetId, Auth::id());
    }

    /**
     * ファボを解除する
     * 
     * @return void
     */
    public function unfavorite(int $tweetId, Favorite $favorite)
    {
        $favorite->unfavorite($tweetId, Auth::id());
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
