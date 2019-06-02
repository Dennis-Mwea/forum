<?php

namespace App\Http\Controllers;

use App\Thread;

class RepliesController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a reply for a thread
     *
     * @param Thread $thread
     * @return response
     */
    public function store($channelId, Thread $thread)
    {
        $thread->addReply([
            'body' => request()->body,
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
