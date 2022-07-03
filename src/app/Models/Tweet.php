<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = ['text'];
    private const SHOW_NUMBER = 10;

    /**
     * 引数のユーザーのtweet一覧を投稿日順にソートしてその値を返す。
     * 
     * @return object
     */
    public function getTimeLine(int $id, int $page): object
    {
        $count = self::SHOW_NUMBER * $page;
        $start = $count - self::SHOW_NUMBER + 1;
        // dd($this->where('userId', $id)->orderBy('created_at', 'desc')->select("text","created_at")->whereBetween('userId', [$start, $count])->get());
        return $this->where('userId', $id)->orderBy('created_at', 'desc')->select("id", "text", "created_at")->whereBetween('userId', [$start, $count])->get();
    }

    /**
     * 引数のユーザーのtweet数を取得してその値を返す。
     * 
     * @return int
     */
    public function getTweetCount(int $id): int
    {
        // dd($this->where('userId', $id)->count());
        return $this->where('userId', $id)->count();
    }
}
