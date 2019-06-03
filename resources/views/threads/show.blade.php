@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->user->name }}</a> posted:
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

            @foreach ($replies as $reply)
                @include('threads.replies')
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
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
            @else
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <article>
                        <div class="body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }}
                                by <a href="#">{{ $thread->user->name }}</a> and currently has {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
