<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retweet extends Model
{
    use HasFactory;

    protected $fillable = ['userId', 'tweetId'];

    /**
     * リツイート数の取得
     * 
     * @return int
     */
    public function getRetweetCount($authUserId): int
    {
        return $this->where('userId', $authUserId)->count();
    }

    /**
     * authUserがリツイートしているか取得
     * 
     * @return int
     */
    public function isRetweet(int $tweetId, int $authUserId): int
    {
        return $this->where('userId', $authUserId)->where('tweetId', $tweetId)->exists() == true ? 1 : 0;
    }

    /**
     * リツイートする
     * 
     * @return void
     */
    public function retweet(int $tweetId, int $authUserId)
    {
        $this->firstOrCreate([
            'tweetId' => $tweetId,
            'userId' => $authUserId,
        ]);
    }

    /**
     * リツイートを解除する
     * 
     * @return void
     */
    public function unretweet(int $tweetId, int $authUserId)
    {
        $retweet = $this->where('tweetId', $tweetId)
            ->where('userId', $authUserId)
            ->first();
        if ($retweet) {
            $retweet->delete();
        }
    }

    /**
     * リツイートリストの取得
     * 
     * @return array
     */
    public function getRetweetIds(int $authUserId): array
    {
        $retweetIdsData = $this->where('userId', $authUserId)->get('tweetId')->pluck('tweetId')->toArray();
        return array_map('intval', $retweetIdsData);
    }
}
