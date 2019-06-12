@extends('layouts.app')

@section('content')
<div class="container">
    <div class="pb-2 mt-4 mb-2 border-bottom">
        <h1>
            {{ $profileUser->name }}
            <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>
    </div>

    @foreach ($threads as $thread)
        <div class="card">
            <div class="card-header">
                <div class="level">
                    <span class="flex">
                        <a href="/profiles/{{ $thread->user->name }}">{{ $profileUser->name }}</a> posted:
                        {{ $thread->title }}
                    </span>
                    <span>
                        {{ $thread->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <article>
                    <div class="body">
                        {{ $thread->body }}
                    </div>
                </article>
            </div>
        </div>
    @endforeach
    {{ $threads->links() }}
</div>
@endsection
