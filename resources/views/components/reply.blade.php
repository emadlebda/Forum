<div id="reply-{{ $reply->id }}" class="card mb-3">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profile', $reply->owner) }}">{{$reply->owner->name}}</a>
                Said {{ $reply->created_at->diffForHumans() }} ...
            </h5>

            <form method="POST" action="{{route('reply.favorite',$reply)}}">
                @csrf

                <button type="submit" class="btn btn-outline-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                    {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
                </button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <div class="body">{{$reply->body}}</div>
    </div>

</div>
