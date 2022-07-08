<?php

namespace App\Models;

use App\Consts\Paginate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = ['text'];

    /**
     * 引数のユーザーのtweet一覧を投稿日順にソートしてその値を返す。
     * 
     * @return object
     */
    public function getTimeLine(int $id): object
    {
        return $this->where('userId', $id)
            ->orderBy('created_at', 'desc')
            ->select("id", "text", "created_at")
            ->paginate(Paginate::NUM_TWEET_PER_PAGE);
    }

    /**
     * 引数のユーザーのtweet数を取得してその値を返す。
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
}
