@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $thread->title }}</div>

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
        <div class="col-md-8">
            @foreach ($thread->replies as $reply)
                <div class="card mt-10 replies">
                    <div class="card-header">
                        <a href="#">
                            {{ $reply->user->name }}
                        </a> said {{ $reply->created_at->diffForHumans() }}:
                    </div>

                    <div class="card-body">
                        <article>
                            <div class="body">
                                {{ $reply->body }}
                            </div>
                        </article>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection