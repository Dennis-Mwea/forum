<div class="card mt-10 replies">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="/profiles/{{ $reply->user->name }}">
                    {{ $reply->user->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}:
            </h5>

            <div>
                <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                    @csrf

                    <button class="btn btn-primary {{ $reply->isFavorited()? 'disabled': '' }}" type="submit">
                        {{ $reply->favorites()->count() }} {{ str_plural('Favorite', $reply->favorites()->count()) }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <article>
            <div class="body">
                {{ $reply->body }}
            </div>
        </article>
    </div>
</div>
