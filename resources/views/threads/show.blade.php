{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <div class="row  mb-3">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card mb-5">--}}
{{--                    <div class="card-header">--}}
{{--                        <div class="level">--}}
{{--                            <span class="flex">--}}
{{--                                <a href="{{route('profile',$thread->creator)}}">{{$thread->creator->name}}</a> posted:{{ $thread->title }}--}}
{{--                            </span>--}}

{{--                            @can('delete',$thread)--}}
{{--                                <form action="{{route('threads.delete',[$thread->channel,$thread])}}" method="post">--}}
{{--                                    @csrf--}}
{{--                                    @method('delete')--}}

{{--                                    <button type="submit" class="btn btn-danger ">Delete Thread</button>--}}
{{--                                </form>--}}
{{--                            @endcan--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="card-body">--}}
{{--                        <div class="body">{{$thread->body}}</div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                @forelse ($replies as $reply)--}}
{{--                    <x-reply :reply="$reply"></x-reply>--}}
{{--                @empty--}}
{{--                    <h4 class="text-center">No Replies yet!</h4>--}}
{{--                @endforelse--}}

{{--                {{$replies->links()}}--}}

{{--                @auth--}}
{{--                    <div class="card">--}}
{{--                        <form action="{{route('replies.store',[$thread->channel,$thread])}}" method="post">--}}
{{--                            @csrf--}}
{{--                            <textarea name="body" id="body" class="form-control" rows="5"--}}
{{--                                      placeholder="Have something to say?"></textarea>--}}

{{--                            <button class="btn btn-primary btn-block">Leave comment</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                @else--}}
{{--                    <h4 class="text-center ">--}}
{{--                        <a href="{{route('login')}}">Sign in </a> to participate in this discussion--}}
{{--                    </h4>--}}
{{--                @endauth--}}
{{--            </div>--}}

{{--            <div class="col-md-4">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <p>--}}
{{--                            This thread was published {{ $thread->created_at->diffForHumans() }} by--}}
{{--                            <a href="{{ route('profile', $thread->creator) }}">{{$thread->creator->name}}</a>, <br>and--}}
{{--                            currently has {{$thread->replies_count}}--}}
{{--                            {{\Illuminate\Support\Str::plural('comment',$thread->replies_count)}}--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}


@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <span class="flex">
                                    <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                                    posted: {{ $thread->title }}
                                </span>

                                @can ('delete', $thread)
                                    <form action="{{ route('threads.delete',[$thread->channel,$thread]) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies :data="{{ $thread->replies }}"
                             @added="repliesCount++"
                             @removed="repliesCount--"></replies>

                    {{--{{ $replies->links() }}--}}
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a>, and currently
                                has <span
                                    v-text="repliesCount"></span> {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}
                                .
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
