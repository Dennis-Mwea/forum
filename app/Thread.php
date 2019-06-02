<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'body', 'channel_id'
    ];

    /**
     * Get a user that created a thread
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all replies that belong to this thread
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Return the path to a single thread
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * Save a reply for this thread
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /**
     * Get the channel for this sthread
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
