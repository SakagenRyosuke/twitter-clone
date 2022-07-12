<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Timeline;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function getTimeline(Timeline $timeline, int $userId)
    {
        return $timeline->getTimeline($userId);
    }

    public function getTimelines(Timeline $timeline, Follow $follow)
    {
        $timelineIds = $follow->getFollowIds(Auth::id());
        array_push($timelineIds, Auth::id());
        return $timeline->getTimelines($timelineIds);
    }
}
