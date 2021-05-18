<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadRequest;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel)
    {
        if ($channel->exists) {
            $threads = $channel->threads()->latest();
        } else {
            $threads = Thread::latest();
        }

        // if request('by'), we should filter by the given username.
        if ($username = request('by')) {
            $user = User::where('name', $username)->firstOrFail();

            $threads->where('user_id', $user->id);
        }

        $threads = $threads->get();

        $threads->load('channel');

        return view('threads.index', compact('threads'));
    }

    public function create(): View
    {
        return view('threads.create');
    }

    public function store(StoreThreadRequest $request): RedirectResponse
    {
        $thread = Thread::create($request->validated() + ['user_id' => auth()->id()]);

        return redirect()->route('threads.show', [$thread->channel, $thread]);
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

    public function destroy(Thread $thread): RedirectResponse
    {
        //
    }
}
