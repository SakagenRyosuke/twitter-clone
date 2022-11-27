<?php

namespace App\Models;

use App\Consts\Paginate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text'];

    /**
     * ツイートごとのcomment一覧を取得
     * 
     * @param int $tweetId
     * @return object
     */
    public function getComments(int $tweetId): object
    {
        return DB::table('comments')
            ->where('comments.tweetId', $tweetId)
            ->join('users', 'comments.userId', '=', 'users.id')
            ->select('users.*', 'comments.*')
            ->orderBy('comments.created_at', 'desc')
            ->paginate(Paginate::NUM_TWEET_PER_PAGE);
    }

    /**
     * Commentの作成
     * 
     * @param int $authId
     * @param object $request
     * @param int $tweetId
     * @return bool
     */
    public function createComment(int $authId, object $request, int $tweetId): bool
    {
        $this->userId = $authId;
        $this->tweetId = $tweetId;
        $this->text = $request->comment;

        return $this->save();
    }
}
