<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreReplyRequest $request, Channel $channel, Thread $thread): RedirectResponse
    {
        $thread->addReply([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function show(Reply $reply): View
    {
        //
    }

    public function edit(Reply $reply): View
    {
        //
    }

    public function update(Request $request, Reply $reply): RedirectResponse
    {
        //
    }

    public function destroy(Reply $reply): RedirectResponse
    {
        //
    }
}
