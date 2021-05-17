@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        <div class="body">{{$thread->body}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @foreach ($thread->replies as $reply)
                        <x-reply :reply="$reply"></x-reply>
                    @endforeach
                </div>
            </div>
        </div>


        @auth
            <div class="row justify-content-center mt-3">
                <div class="col-md-8">
                    <div class="card">
                        <form action="{{route('replies.store',[$thread->channel,$thread])}}" method="post">
                            @csrf
                            <textarea name="body" id="body" class="form-control" rows="5"
                                      placeholder="Have something to say?"></textarea>

                            <button class="btn btn-primary btn-block">Leave comment</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <h4 class="text-center ">
                <a href="{{route('login')}}">Sign in </a> to participate in this discussion
            </h4>
        @endauth
    </div>
@endsection
