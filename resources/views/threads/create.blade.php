@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create a New Thread') }}</div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{route('threads.store')}}">
                            @csrf

                            <div class="form-group">
                                <label for="channel_id"></label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option>Choose one ...</option>
                                    @foreach ($channels as $channel)
                                        <option
                                            value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected':''}}>
                                            {{$channel->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{old('title')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea name="body" id="body" class="form-control" rows="8" required>
                                    {{old('body')}}
                                </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Publish</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
