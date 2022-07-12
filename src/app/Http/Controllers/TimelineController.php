<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Timeline;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    /**
     * プロフィール用のタイムライン取得
     * 
     * @param \App\Models\Timeline $timeline
     * @param int $userId
     * @return object
     */
    public function getTimeline(Timeline $timeline, int $userId): object
    {
        return $timeline->getTimeline($userId);
    }

    /**
     * ホーム用のタイムライン取得
     * 
     * @param \App\Models\Timeline $timeline
     * @param \App\Models\Follow $follow
     * @return object
     */
    public function getTimelines(Timeline $timeline, Follow $follow): object
    {
        $timelineIds = $follow->getFollowIds(Auth::id());
        array_push($timelineIds, Auth::id());
        return $timeline->getTimelines($timelineIds);
    }
}
