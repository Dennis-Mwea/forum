<?php

namespace App;

use App\User;
use App\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Reply
 * @package App
 */
class Reply extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'thread_id', 'body'
    ];

    /**
     * Get a thread for this reply
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Get a user that made this reply
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the favorited replies
     *
     * @return MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Favorite a reply
     */
    public function favorite($userId)
    {
        $attributes = ['user_id' => $userId];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    /**
     * Check whether a reply is favorited or not
     *
     * @return bool
     */
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
}
