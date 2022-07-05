<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['followingId', 'followedId'];

    /**
     * idが引数と一致する人のフォローしている人数を取得してその値を返す
     * 
     * @return integer
     */
    public function getFollowingCount($id): int
    {
        return $this->where('followingId', $id)->count();
    }

    /**
     * idが引数と一致する人のフォローされている人数を取得してその値を返す
     * 
     * @return integer
     */
    public function getFollowedCount($id): int
    {
        return $this->where('followedId', $id)->count();
    }

    /**
     * 引数$idのことをauthUserがフォローしているかをintで返す
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
     * レコードを作成しfollowsテーブルに追加する
     * 
     * @return void
     */
    public function doFollowing(int $id, int $authUserId)
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
    public function doUnfollowing(int $id, int $authUserId)
    {
        $follow = $this->where('followedId', $id)
            ->where('followingId', $authUserId)
            ->first();
        if ($follow) {
            $follow->delete();
        }
    }
}
