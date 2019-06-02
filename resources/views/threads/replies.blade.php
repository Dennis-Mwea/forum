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