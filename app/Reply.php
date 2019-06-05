<?php

namespace App;

use App\User;
use App\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Traits\Favoritable;

/**
 * Class Reply
 * @package App
 */
class Reply extends Model
{
    use Favoritable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'thread_id', 'body'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['user', 'favorites'];

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
}
