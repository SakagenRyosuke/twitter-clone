<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\PostRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return object
     */
    public function index(Comment $comment, int $tweetId): object
    {
        return $comment->getComments($tweetId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Comment\PostRequest  $request
     * @return bool
     */
    public function store(int $tweetId, PostRequest $request,Comment $comment): bool
    {
        return $comment->createComment(Auth::id(), $request, $tweetId);
    }
}
