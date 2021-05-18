@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row  mb-3">
            <div class="col-md-8">
                <div class="card mb-5">
                    <div class="card-header">
                        <a href="{{route('profile',$thread->creator)}}">{{$thread->creator->name}}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        <div class="body">{{$thread->body}}</div>
                    </div>
                </div>

                @foreach ($replies as $reply)
                    <x-reply :reply="$reply"></x-reply>
                @endforeach

                {{$replies->links()}}

                @auth
                    <div class="card">
                        <form action="{{route('replies.store',[$thread->channel,$thread])}}" method="post">
                            @csrf
                            <textarea name="body" id="body" class="form-control" rows="5"
                                      placeholder="Have something to say?"></textarea>

                            <button class="btn btn-primary btn-block">Leave comment</button>
                        </form>
                    </div>
                @else
                    <h4 class="text-center ">
                        <a href="{{route('login')}}">Sign in </a> to participate in this discussion
                    </h4>
                @endauth
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} ago by
                            <a href="{{ route('profile', $reply->owner) }}">{{$thread->creator->name}}</a>, <br>and
                            currently has {{$thread->replies_count}}
                            {{\Illuminate\Support\Str::plural('comment',$thread->replies_count)}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
