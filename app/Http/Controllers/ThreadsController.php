<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Http\Requests\StoreThreadRequest;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) return $threads;

        return view('threads.index', compact('threads'));
    }

    public function create(): View
    {
        return view('threads.create');
    }

    public function store(StoreThreadRequest $request): RedirectResponse
    {
        $thread = Thread::create($request->validated() + ['user_id' => auth()->id()]);

        return redirect()->route('threads.show', [$thread->channel, $thread])
            ->with('flash', 'Your thread has been published!');
    }

    public function show(Channel $channel, Thread $thread): View
    {
        return view('threads.show', compact('thread'));
    }

    public function edit(Thread $thread): View
    {
        //
    }

    public function update(Request $request, Thread $thread): RedirectResponse
    {
        //
    }

    public function destroy(Channel $channel, Thread $thread)
    {
//        abort_if($thread->user_id != auth()->id(), 403,'you do not have permission to do this');

        $this->authorize('delete', $thread);
        $thread->delete();

        if (request()->wantsJson())
            return response([], 204);

        return redirect()->route('threads.index');
    }

    /**
     * Fetch all relevant threads.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists)
            $threads->where('channel_id', $channel->id);

        return $threads->get();
    }
}
