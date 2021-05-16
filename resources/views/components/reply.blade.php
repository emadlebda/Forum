<div class="card-header">
    <a href="#">{{$reply->owner->name}}</a>
    Said {{ $reply->created_at->diffForHumans() }} ...
</div>

<div class="card-body">
    <div class="body">{{$reply->body}}</div>
</div>
