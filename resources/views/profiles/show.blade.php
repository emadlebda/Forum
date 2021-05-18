@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                @foreach ($threads as $thread)
                    <div class="card mb-5">
                        <div class="card-header">
                            <div class="level">
                                   <span class="flex">
                                       <a href="{{route('profile',$thread->creator)}}">
                                            {{$thread->creator->name}}
                                       </a>
                                         posted:
                                       <b>
                                           <a href="{{route('threads.show',[$thread->channel,$thread])}}">{{ $thread->title }}</a>
                                       </b>
                                   </span>

                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="body">{{$thread->body}}</div>
                        </div>
                    </div>
                @endforeach

                {{ $threads->links() }}</div>
        </div>
    </div>
@endsection
