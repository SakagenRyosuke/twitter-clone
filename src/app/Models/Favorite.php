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
     * @return int
     */
    public function getFavoriteCount($tweetId): int
    {
        return $this->where('tweetId', $tweetId)->count();
    }

    // /**
    //  * authUserがファボしているか取得
    //  * 
    //  * @return int
    //  */
    // public function isFavorite(int $tweetId, int $authUserId): int
    // {
    //     return $this->where('userId', $authUserId)->where('tweetId', $tweetId)->exists() == true ? 1 : 0;
    // }

    /**
     * ファボする
     * 
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
     * @return array
     */
    public function getFavoriteIds(int $authUserId): array
    {
        $favoriteIdsData = $this->where('userId', $authUserId)->get('tweetId')->pluck('tweetId')->toArray();
        return array_map('intval', $favoriteIdsData);
    }

    /**
     * ファボしているか取得する
     * 
     * @return int
     */
    public function getIsFavorite(int $tweetId): int
    {
        return $this->where('tweetId', $tweetId)->exits() ? 1 : 0;
    }
}
