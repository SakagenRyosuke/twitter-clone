<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['followingId', 'followedId'];

    /**
     * フォロー数取得
     * 
     * @param int $id
     * @return int
     */
    public function getFollowingCount(int $id): int
    {
        return $this->where('followingId', $id)->count();
    }

    /**
     * フォロワー数取得
     * 
     * @param int $id
     * @return int
     */
    public function getFollowedCount(int $id): int
    {
        return $this->where('followedId', $id)->count();
    }

    /**
     * authUserがフォローしているか取得
     * 
     * @param int $id
     * @param int $authUserId
     * @return int
     */
    public function isFollow(int $id, int $authUserId): int
    {
        return $this->where('followingId', $authUserId)
            ->where('followedId', $id)->exists() == true ? 1 : 0;
    }

    /**
     * フォローする
     * 
     * レコードを作成しfollowsテーブルに追加
     * 
     * @param int $id
     * @param int $authUserId
     * @return void
     */
    public function follow(int $id, int $authUserId)
    {
        $this->firstOrCreate([
            'followedId' => $id,
            'followingId' => $authUserId,
        ]);
    }

    /**
     * フォロー解除する
     * 
     * followsテーブルに検索をかけて、一致したものがあった場合レコードをデリートする
     * 
     * @param int $id
     * @param int $authUserId
     * @return void
     */
    public function unfollow(int $id, int $authUserId)
    {
        $follow = $this->where('followedId', $id)
            ->where('followingId', $authUserId)
            ->first();
        if ($follow) {
            $follow->delete();
        }
    }

    /**
     * フォローリストの取得
     * 
     * @param int $authUserId
     * @return array
     */
    public function getFollowIds(int $authUserId): array
    {
        $followIdsData = $this->where('followingId', $authUserId)
            ->get('followedId')->pluck('followedId')->toArray();
        return array_map('intval', $followIdsData);
    }
}
