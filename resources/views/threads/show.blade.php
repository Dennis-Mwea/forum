@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ $thread->user->name }} posted 
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    <article>
                        <div class="body">
                            {{ $thread->body }}
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            @foreach ($thread->replies as $reply)
                @include('threads.replies')
            @endforeach
        </div>
    </div>

    @if (auth()->check())
        <div class="row justify-content-center replies">
            <div class="col-md-10">
                <form action="{{ $thread->path() . '/replies' }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea name="body" id="body" rows="5" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Reply</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
    @endif
</div>
@endsection