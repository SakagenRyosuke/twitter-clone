<?php

namespace App\Models;

use App\Consts\Paginate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = ['text'];

    /**
     * ユーザごとのtweet一覧を取得
     * 
     * @return object
     */
    public function getTimeLine(int $id): object
    {
        return DB::table('users')
        ->where('users.id', $id)
        ->join('tweets', 'users.id', '=', 'tweets.userId')
        ->select('users.*', 'tweets.*')
        ->orderBy('tweets.created_at', 'desc')
        ->paginate(Paginate::NUM_TWEET_PER_PAGE);
    }

    /**
     * タイムラインを取得
     * 
     * @return object
     */
    public function getTimeLines(array $ids): object
    {
        return DB::table('users')
        ->whereIn('users.id', $ids)
        ->join('tweets', 'users.id', '=', 'tweets.userId')
        ->select('users.*', 'tweets.*')
        ->orderBy('tweets.created_at', 'desc')
        ->paginate(Paginate::NUM_TWEET_PER_PAGE);
    }

    /**
     * tweet数の取得
     * 
     * @return int
     */
    public function getTweetCount(int $id): int
    {
        return $this->where('userId', $id)->count();
    }

    /**
     * Tweet作成
     */
    public function createTweet(int $authId, object $request)
    {
        $this->userId = $authId;
        $this->text = $request->tweet;

        return $this->save();
    }

    /**
     * ツイートの編集
     */
    public function updateTweet(int $tweetId, object $request, int $authId): bool
    {
        $tweet = $this->where('id', $tweetId)->first();

        if($tweet->userId == $authId) {
            $tweet->text = $request->tweet;
            return $tweet->save();
        }else {
            return false;
        }
    }

    /**
     * ツイートの削除
     */
    public function destroyTweet(int $tweetId, int $authId): bool
    {
        $tweet = $this->where('id', $tweetId)->first();
        
        if($tweet->userId == $authId) {
            return $tweet->delete();
        }else {
            return false;
        }
    }
}
