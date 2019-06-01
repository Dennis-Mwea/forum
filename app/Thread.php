<?php

namespace App;

use App\User;
use App\Reply;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'body',
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
}
