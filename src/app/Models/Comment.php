<?php

namespace App\Models;

use App\Consts\Paginate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text'];

    /**
     * ツイートごとのcomment一覧を取得
     * 
     * @return object
     */
    public function getComments(int $tweetId): object
    {
        return $this->where('tweetId', $tweetId)
        ->orderBy('created_at', 'desc')
        ->paginate(Paginate::NUM_TWEET_PER_PAGE);
    }

    /**
     * Commentの作成
     */
    public function createComment(int $authId, object $request, int $tweetId)
    {
        $this->userId = $authId;
        $this->tweetId = $tweetId;
        $this->text = $request->comment;

        return $this->save();
    }
}
