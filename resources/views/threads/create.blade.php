@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create A Thread</div>

                <div class="card-body">
                    <form action="/threads" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="channel">Choose a channel:</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose one...</option>
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id? 'selected': '' }}>{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea name="body" id="body" rows="5" class="form-control" required>{{ old('body') }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Post Thread</button>
                        </div>
                    </form>

                    @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
