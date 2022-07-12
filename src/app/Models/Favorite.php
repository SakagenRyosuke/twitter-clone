<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['userId', 'tweetId'];


    /**
     * ファボ数の取得
     * 
     * @param int $tweetId
     * @return int
     */
    public function getFavoriteCount(int $tweetId): int
    {
        return $this->where('tweetId', $tweetId)->count();
    }

    /**
     * ファボする
     * 
     * @param int $tweetId
     * @param int $authUserId
     * @return void
     */
    public function favorite(int $tweetId, int $authUserId)
    {
        $this->firstOrCreate([
            'tweetId' => $tweetId,
            'userId' => $authUserId,
        ]);
    }

    /**
     * ファボを解除する
     * 
     * @param int $tweetId
     * @param int $authUserId
     * @return void
     */
    public function unfavorite(int $tweetId, int $authUserId)
    {
        $favorite = $this->where('tweetId', $tweetId)
            ->where('userId', $authUserId)
            ->first();
        if ($favorite) {
            $favorite->delete();
        }
    }

    /**
     * ファボリストの取得
     * 
     * @param int $authUserId
     * @return array
     */
    public function getFavoriteIds(int $authUserId): array
    {
        $favoriteIdsData = $this->where('userId', $authUserId)
            ->get('tweetId')->pluck('tweetId')->toArray();
        return array_map('intval', $favoriteIdsData);
    }

    /**
     * ファボしているか取得する
     * 
     * @param int $tweetId
     * @return int
     */
    public function getIsFavorite(int $tweetId): int
    {
        return $this->where('tweetId', $tweetId)
            ->exists() == true ? 1 : 0;
    }
}
