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
     * @param int $authUserId
     * @return int
     */
    public function getRetweetCount(int $authUserId): int
    {
        return $this->where('userId', $authUserId)->count();
    }

    /**
     * リツイートする
     * 
     * @param int $tweetId
     * @param int $authUserId
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
     * @param int $tweetId
     * @param int $authUserId
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
     * @param int $authUserId
     * @return array
     */
    public function getRetweetIds(int $authUserId): array
    {
        $retweetIdsData = $this->where('userId', $authUserId)
            ->get('tweetId')->pluck('tweetId')->toArray();
        return array_map('intval', $retweetIdsData);
    }

    /**
     * リツイートしているか取得する
     * 
     * @param int $tweetId
     * @return int
     */
    public function getIsRetweet(int $tweetId): int
    {
        return $this->where('tweetId', $tweetId)
            ->exists() === true ? 1 : 0;
    }
}
