<?php

namespace App;

use App\User;
use App\Thread;
use Illuminate\Database\Eloquent\Model;

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
}
