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
     * @return integer
     */
    public function getFollowingCount($id): int
    {
        return $this->where('followingId', $id)->count();
    }

    /**
     * フォロワー数取得
     * 
     * @return integer
     */
    public function getFollowedCount($id): int
    {
        return $this->where('followedId', $id)->count();
    }

    /**
     * authUserがフォローしているか取得
     * 
     * @return int
     */
    public function getFollowList(int $id,int $authUserId): int
    {
        return $this->where('followingId', $authUserId)->where('followedId', $id)->count();
    }

    /**
     * フォローする
     * 
     * レコードを作成しfollowsテーブルに追加
     * 
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
}
