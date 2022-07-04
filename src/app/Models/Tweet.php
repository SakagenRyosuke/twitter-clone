<?php

namespace App\Models;

use App\Consts\AdditionalNumber;
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
    public function getTimeLine(int $id, int $page): object
    {
        $count = AdditionalNumber::SHOW_TWEETS_NUMBER;
        $start = ($page - 1) * AdditionalNumber::SHOW_TWEETS_NUMBER;
        return $this->where('userId', $id)->orderBy('created_at', 'desc')->select("id", "text", "created_at")->skip($start)->take($count)->get();
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
}
