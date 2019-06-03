<?php

namespace App\Http\Controllers;

use App\Filters\ThreadsFilter;
use App\Thread;
use App\Channel;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadsFilter $filters
     * @return Response
     */
    public function index(Channel $channel, ThreadsFilter $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'channel_id' => $request->channel_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect($thread->path());
    }

    /**
     * Show a single thread
     *
     * @param [type] $channelId
     * @param Thread $thread
     * @return void
     */
    public function show($channelId, Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(5),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Thread $thread
     * @return void
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Thread $thread
     * @return void
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thread $thread
     * @return void
     */
    public function destroy(Thread $thread)
    {
        //
    }

    /**
     * @param Channel $channel
     * @param ThreadsFilter $filters
     * @return mixed
     */
    private function getThreads(Channel $channel, ThreadsFilter $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->get();
        return $threads;
    }
}
