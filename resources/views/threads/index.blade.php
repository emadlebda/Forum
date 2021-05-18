@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($threads as $thread)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{route('threads.show',[$thread->channel,$thread->id])}}">
                                        {{ $thread->title }}
                                    </a>
                                </h4>

                                <a href="{{route('threads.show',[$thread->channel,$thread->id])}}">
                                    {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <article>
                                <div class="body">{{$thread->body}}</div>
                            </article>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
