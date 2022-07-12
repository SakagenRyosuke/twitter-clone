<?php

namespace App\Models;

use App\Consts\Paginate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = ['userId', 'tweetId', 'state'];

    /**
     * プロフィール画面用タイムライン取得
     * 
     * @return object
     */
    function getTimeline(int $userId)
    {
        return DB::table('timelines')
            ->where('timelines.userId', $userId)
            ->join('tweets', 'timelines.tweetId', '=', 'tweets.id')
            ->join('users', 'tweets.userId', '=', 'users.id')
            ->select(
                'timelines.userId as timelineUserId',
                'timelines.state',
                'tweets.*',
                'users.name',
                'users.screenName',
                'users.profileImage'
            )
            ->orderBy('timelines.created_at', 'desc')
            ->paginate(Paginate::NUM_TWEET_PER_PAGE);
    }

    /**
     * ホーム画面用タイムライン取得
     * 
     * @return object
     */
    function getTimelines(array $timelineIds): object
    {
        return DB::table('timelines')
            ->whereIn('timelines.userId', $timelineIds)
            ->join('tweets', 'timelines.tweetId', '=', 'tweets.id')
            ->join('users', 'tweets.userId', '=', 'users.id')
            ->select(
                'timelines.userId as timelineUserId',
                'timelines.state',
                'tweets.*',
                'users.name',
                'users.screenName',
                'users.profileImage'
            )
            ->orderBy('timelines.created_at', 'desc')
            ->paginate(Paginate::NUM_TWEET_PER_PAGE);
    }

    public function createTimeline(int $authId, int $tweetId, string $state)
    {
        $this->firstOrCreate([
            'userId' => $authId,
            'tweetId' => $tweetId,
            'state' => $state
        ]);
    }

    public function destroyTimeline(int $authId, int $tweetId, string $state)
    {
        $this->where([['userId', $authId], ['tweetId', $tweetId], ['state', $state]])
            ->delete();
    }
}
